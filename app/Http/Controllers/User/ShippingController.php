<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\{
    Shipment,
    Address,
    Item,
    Transaction
};
use App\Util\ResponseFormatter;
use App\Util\Logistics;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ShippingController extends Controller
{
    private Logistics $logistics;

    public function __construct(Logistics $logistics)
    {
        $this->logistics = $logistics;
    }

    private function generateReference($id)
    {
        $token = "";
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet .= '0123456789';
        $max = strlen($codeAlphabet) - 1;
        for($i=0; $i<14; $i++):
            $token .= $codeAlphabet[mt_rand(0, $max)]; 
        endfor; 
        return $id.strtolower($token);
    }

    public function showShippings()
    {
        $user = User::find(Auth::user()->id);
        $stats = [
            "cancelled" => $user->shipments()->where('status', "cancelled")->count(),
            "in-transit" => $user->shipments()->where('status', "in-transit")->count(),
            "delivered" => $user->shipments()->where('status', "delivered")->count(),
            "total" => $user->shipments()->count()
        ];

        return view('customer.shippings.shipping', compact('user', 'stats'));
    }

    public function getUserShipments(Request $request)
    {
        $user = User::find(Auth::user()->id);

        // Filter transactions by period
        if ($request->has('period')):
            switch($request->period):
                case "today":
                    $shipments = $user->shipments()
                    ->whereDate('created_at', Carbon::today())
                    ->orderByDesc("created_at")
                    ->get();
                break;
                case "week":
                    $shipments = $user->shipments()
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderByDesc("created_at")
                    ->get();
                break;
                case "month":
                    $shipments = $user->shipments()
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->orderByDesc("created_at")
                    ->get();
                break;
                case "year":
                    $shipments = $user->shipments()
                    ->whereYear('created_at', Carbon::now()->year)
                    ->orderByDesc("created_at")
                    ->get();
                break;
            endswitch;
        else:
            $shipments = $user->shipments()->orderByDesc("created_at")->get();
        endif;

        return ResponseFormatter::success("Shipments:", $shipments, 200);
    }

    public function showShippingForm()
    {
        $user = User::find(Auth::user()->id);
        $countries = Country::all();

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', env('TERMINAL_AFRICA_URI').'hs-codes/simplified/chapters/', [
            'headers' => [
                'Authorization' => 'Bearer '.env('TERMINAL_AFRICA_SECRET_KEY')
            ]
        ]);
        $response = json_decode($response->getBody());
        $chapters = $response->data;

        return view('customer.shippings.create-shipping', compact('user', 'countries', 'chapters'));
    }

    public static function getStates(int $countryId)
    {
        $states = State::where(['country_id' => $countryId])->get();

        return ResponseFormatter::success("States:", $states, 200);
    }
    
    public static function getCities(int $stateId)
    {
        $cities = City::where(['state_id' => $stateId])->get();
            
        return ResponseFormatter::success("Cities:", $cities, 200);
    }

    public function shipmentWebhook(Request $request)
    {
        http_response_code(200);

        $shipment = Shipment::where([
            'shipment_id' => $request["data"]["shipment_id"]
        ])->first();

        switch($request["event"]):
            case "shipment.in-transit":
                //Handle shipment in-transit event
                $shipment->status = "in-transit";
            break;
            case "shipment.delivered":
                //Handle shipment delivered update event
                $shipment->status = "delivered";
            break;
            case "shipment.cancelled":
                //Handle shipment cancelled update event
                $shipment->status = "cancelled";
            break;
            default:
                //Handle unknown event received
        endswitch;
        $shipment->save();
    }

    public static function showTrackingForm()
    {
        $user = User::find(Auth::user()->id);

        return view('customer.shippings.tracking', compact('user'));
    }

    public function makePayment(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $wallet = $user->wallet;
        if($wallet->balance <= $request->total):
            return ResponseFormatter::success("Insufficient wallet balance...", null, 400);
        endif;

        $wallet->balance -= $request->total;
        $wallet->save();

        $transaction = new Transaction();
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = $request->total;
        $transaction->type = "Debit";
        $transaction->purpose = "Payment for ".$request->shipment_id." shipment";
        $transaction->reference = $this->generateReference($wallet->id);
        $transaction->status = "success";
        $transaction->verified = true;
        $transaction->save();

        $payload = [
            'rate_id' => $request->rate_id
            //'shipment_id' => $request->shipment_id, //optional
        ];
        //Arrange pickup for shipment
        //$pickup = $this->logistics->arrangePickup($payload);
        //if($pickup["data"]["status"] == "confirmed"):
            $response = $this->logistics->getShipment($request->shipment_id);
            $response = json_decode($response);
            $data = $response->data;

            $shipment = new Shipment;
            $shipment->user_id = $user->id;
            $shipment->external_shipment_id = $data->shipment_id;
            $shipment->pickup_date = $data->pickup_date;
            $shipment->save();

            foreach($data->parcel->items as $item):
                $newItem = new Item;
                $newItem->shipment_id = $shipment->id;
                $newItem->name = $item->name;
                $newItem->currency = $item->currency;
                $newItem->description = $item->description;
                $newItem->value = $item->value;
                $newItem->quantity = $item->quantity;
                $newItem->weight = $item->weight;
                $newItem->save();
            endforeach;
    
            $from = new Address;
            $from->shipment_id = $shipment->id;
            $from->firstname = $data->address_from->first_name;
            $from->lastname = $data->address_from->last_name;
            $from->email = $data->address_from->email;
            $from->phone = $data->address_from->phone;
            $from->country = $data->address_from->country;
            $from->state = $data->address_from->state;
            $from->city = $data->address_from->city;
            $from->zip = $data->address_from->zip;
            $from->line1 = $data->address_from->line1;
            $from->type = "from";
            $from->save();
    
            $to = new Address;
            $to->shipment_id = $shipment->id;
            $to->firstname = $data->address_to->first_name;
            $to->lastname = $data->address_to->last_name;
            $to->email = $data->address_to->email;
            $to->phone = $data->address_to->phone;
            $to->country = $data->address_to->country;
            $to->state = $data->address_to->state;
            $to->city = $data->address_to->city;
            $to->zip = $data->address_to->zip;
            $to->line1 = $data->address_to->line1;
            $to->type = "to";
            $to->save();
        //endif;

        return ResponseFormatter::success("Shipment arranged successfully", null, 200);
    }

}