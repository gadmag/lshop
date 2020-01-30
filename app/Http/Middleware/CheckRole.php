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
    public function handle($request, Closure $next)
    {
//        dd($roles);
        $action = $request->route()->getAction();
        $roles = isset($action['roles'])? $action['roles'] : null;
//        dd($action['roles']);
        if($request->user() === null){
            return abort(404);
        }
        if (!$request->user()->hasRole($roles)){
//            dd($roles);
            return abort(404);
        }

        return $next($request);
    }
}
