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

        // Retrieve the request's raw body content
        $input = $request->getContent();
        // Verify the Paystack signature
        $paystackSecret = env('PAYSTACK_SECRET', '');
        $expectedSignature = hash_hmac('sha512', $input, $paystackSecret);

        if($request->header('X-Paystack-Signature') !== $expectedSignature):
            //Log::info('Invalid Paystack Signature', ['input' => $input]);
            // If the signature does not match, abort with a 403 Forbidden status
            //abort(403, 'Forbidden');
            exit();
        endif;

        return $next($request);
    }
}
