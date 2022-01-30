<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\RoleGroup;
use App\Models\Permission;
use App\Models\RoleGroupPermission;
use App\Models\UserRoleGroup;
use DB;

class CheckPermission
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
        /*
        1.GET MIN (RoleGroup_ID) FROM UserRoleGroup
        2.GET Permission_ID FROM REQUEST
        3.SEARCH IN RoleGroupPermission IF TRUE
        */

        //1.
        
        $User_ID =  auth()->user()->id;
        
        $RoleGroup_ID = UserRoleGroup::where('User_ID' , '=' , $User_ID)->min('RoleGroup_ID');
        
       //2.        
        $url = $request->path();
        $string = strtolower($url);
        $string = preg_replace('/[^a-z0-9 -]+/', '', $string);
        $string = str_replace('', '/', $string);
        $string = preg_replace('/[0-9]+/', '', $string);
        //$string = str_replace('admin', '', $string);

        $route = $request->route()->getActionName();

        $route_destroy = substr ($route, -7);
        $route_show = substr ($route, -4);
        $route_index = substr ($route, -5);
        $route_update = substr ($route, -6);
        $route_store = substr ($route, -5);

        //dd($route);

        if ($route_destroy == 'destroy') {
            
            $permission_name =  $string . $route_destroy;

        }else if ($route_show == 'show' and substr ($url, -5) != 'fetch') {
            
            $permission_name = $string . $route_show;

        }else if ($route_index == 'index') {

            $permission_name =  $string . $route_index;
        }
        elseif ($route_update == 'update') {
            
            $route_update = 'edit';
            $permission_name =  $string . $route_update;
        }
        elseif ($route_store == 'store') {
            $route_store = 'create';
            $permission_name =  $string . $route_store;
        }
        else
        {
            $permission_name = $string;
        }

        //dd($url,$route ,$string, $route_store , $permission_name );
  
        $Permission  = Permission::where('Name' , '=' , $permission_name)->first();

        //dd($url);

        if ($Permission == '[]')
        {
            return response('Not Allowed'); 
        }

        //dd($permission_name);
       //3.
        $RoleGroupPermission = RoleGroupPermission::where('RoleGroup_ID' , '=' , $RoleGroup_ID)->where('Permission_ID' , '=' , $Permission->id)->get();
        //dd($RoleGroup_ID);
        if ($RoleGroupPermission != '[]')
        {
            //dd('azad');
            
            return $next($request);
        } 
        
        return response('Not Allowed');     
    }

}


//dd($request->route()->parameter);
//dd($request->route()->getActionName());

//Session::set('Check',false);
//\session('Check', false);

//@if(Session::get('Check' , 1 ))