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

        $input = json_encode($request->all());
        if($request->header('X-Terminal-Signature') !== 
        hash_hmac('sha512', $input, env('TERMINAL_AFRICA_SECRET_KEY', ''))):
            exit();
        endif;

        return $next($request);
    }
}
