<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if($request->email() === null) {
            return response("Permessi insufficienti",401);
        }

        $actions = $request->route()->getAction();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;

        if($request->utente()->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }
        
        return response("Permessi insufficienti",401);        
    }
}
