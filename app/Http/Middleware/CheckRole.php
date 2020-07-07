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
    public function handle($request, Closure $next, $roles)
    {
        //check if there is a logged in user
        if ($request->user() === null) {
            return response("Insufficient permissions", 401);
        }
        
        //get the request actions
        //$actions = $request->route()->getAction();

        $roles = isset($roles) ? $roles : null;

        //set the variable roles to the roles, if any was provided
        // $roles = isset($actions['roles']) ? $actions['roles'] : null;

        //allow the user to access the resource if he/she has one of the roles or if no roles were assigned to that resource
        if ($request->user()->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }

        return response("Insufficient permissions", 401);
    }
}
