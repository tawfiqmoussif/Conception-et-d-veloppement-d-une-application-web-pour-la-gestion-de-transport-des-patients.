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
        if($request->user()==null){
            return redirect('/');
        }
        $action = $request->route()->getAction();
        $roles = isset($action['roles']) ? $action['roles'] : null;
        if($request->user()->hasAnyRole($roles) || !$roles){// hasAnyRole swabtha f model User
            return $next($request);
        }
        if($request->user()->hasAnyRole("not_active") || !$roles){
            return redirect('/not_active');
        }
        if($request->user()->hasAnyRole("admin") || !$roles){
            return redirect('/admin');
        }if($request->user()->hasAnyRole("coordinateur") || !$roles){
            return redirect('/coordinateur');
        }if($request->user()->hasAnyRole("major") || !$roles){
            return redirect('/major');
        }if($request->user()->hasAnyRole("demandeur") || !$roles){
            return redirect('/demandeur');
        }
        if($request->user()->hasAnyRole("brancardier") || !$roles){
            return redirect('/brancardier');
        }
        return redirect('/');
    }
}
