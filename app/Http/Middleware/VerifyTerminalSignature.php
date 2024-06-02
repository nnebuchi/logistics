<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyTerminalSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->hasHeader('X-Terminal-Signature')):
            exit();
        endif;

        // Retrieve the request's raw body content
        $input = $request->getContent();
        // Verify the Terminal signature
        $secret = env('TERMINAL_AFRICA_SECRET_KEY', '');
        $expectedSignature = hash_hmac('sha512', $input, $secret);

        if($request->header('X-Terminal-Signature') !== $expectedSignature):
            exit();
        endif;

        return $next($request);
    }
}
