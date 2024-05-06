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
use App\Models\Shipment;
use App\Util\ResponseFormatter;
use App\Util\Logistics;
use App\Services\UserService;
use App\Http\Requests\ChangePassword;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ShippingController extends Controller
{
    private UserService $userService;
    private $logistics;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->logistics = new Logistics();
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

}