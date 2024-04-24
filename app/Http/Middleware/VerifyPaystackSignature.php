<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyPaystackSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->hasHeader('x-paystack-signature')):
            exit();
        endif;

        $input = json_encode($request->all());
        if($request->header('x-paystack-signature') !== 
        hash_hmac('sha512', $input, env('PAYSTACK_SECRET', ''))):
            exit();
        endif;

        return $next($request);
    }
}
