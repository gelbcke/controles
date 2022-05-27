<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware 
{
    /*
    public function handle($request, Closure $next) {        
        if (Auth::user()->hasRole('Desenvolvedor')) //If user has admin role
        {
            return $next($request);
        }
        if (Auth::user()->hasRole('Administrador')) //If user has user role
        {
            if ($request->is('usuarios/create'))//If user is creating a post
            {
                if (!Auth::user()->hasPermissionTo('Criar'))
                {
                   abort('401');
                } 
                else {
                   return $next($request);
                }
            }
        }
        return $next($request);
    }*/
}