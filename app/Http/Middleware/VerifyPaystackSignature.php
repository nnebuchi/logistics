<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class VerifyPaystackSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(!$request->hasHeader('X-Paystack-Signature')):
        //     exit();
        // endif;

       
        $input = $request->getContent();

        $paystackSecret = env('PAYSTACK_SECRET', '');
        $expectedSignature = hash_hmac('sha512', $input, $paystackSecret);

        // if($request->header('X-Paystack-Signature') !== $expectedSignature):
           
        //     exit();
        // endif;

        return $next($request);
    }
}
