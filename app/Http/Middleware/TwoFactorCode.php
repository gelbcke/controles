<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactorCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if(auth()->check() && $user->two_factor_code)
        {
            if($user->two_factor_expires_at->lt(now()))
            {
                $user->resetTwoFactorCode();
                auth()->logout();

                return redirect()->route('login')
                    ->withMessage('O código de verificação expirou. Por favor, efetue o login novamente!');
            }

            if(!$request->is('verify*'))
            {
                return redirect()->route('verify.index');
            }
        }

        return $next($request);
    }
}
