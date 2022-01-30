<?php

namespace App\Providers;

use App\Models\RoleGroup;
use App\Models\UserRoleGroup;
use App\Models\Permission;
use App\Models\RoleGroupPermission;
use App\Models\UserRestaurant;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('checkpermission', function ($user, $requesttype) {

            //dd($this->app->request->getRequestUri());
            $User_ID = $user->id;

            $RoleGroup_ID = UserRoleGroup::where('User_ID', '=', $User_ID)->min('RoleGroup_ID');

            $url = $this->app->request->getRequestUri();
            $string = strtolower($url);
            $string = preg_replace('/[^a-z0-9 -]+/', '', $string);
            $string = str_replace('', '/', $string);
            $string = preg_replace('/[0-9]+/', '', $string);
            $string = str_replace('admin', '', $string);

            $permission_name =  $string . $requesttype;

            $Permission  = Permission::where('Name', '=', $permission_name)->first();
            //dd($permission_name);
            $RoleGroupPermission = RoleGroupPermission::where('RoleGroup_ID', '=', $RoleGroup_ID)->where('Permission_ID', '=', $Permission->id)->get();

            if ($RoleGroupPermission != '[]') {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('checkpermissionname', function ($user, $permission_name) {

            $User_ID = $user->id;

            $RoleGroup_ID = UserRoleGroup::where('User_ID', '=', $User_ID)->min('RoleGroup_ID');

            $Permission  = Permission::where('Name', '=', $permission_name)->first();
            //dd($permission_name);
            $RoleGroupPermission = RoleGroupPermission::where('RoleGroup_ID', '=', $RoleGroup_ID)->where('Permission_ID', '=', $Permission->id)->get();

            if ($RoleGroupPermission != '[]') {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('IsOwner', function ($user) {

            $User_ID = $user->id;

            $OwnerRoleGroup = RoleGroup::where('Name', '=', 'Owner User')->first();

            $UserRoleGroup = UserRoleGroup::where('User_ID', '=', $User_ID)->where('RoleGroup_ID', '=', $OwnerRoleGroup->id)->get();

            //dd($UserRoleGroup);
            if ($UserRoleGroup != '[]') {
                //dd($UserRoleGroup);
                return true;
            } else {

                return false;
            }
        });

        Gate::define('IsMyRestaurant', function ($user, $restaurant_id) {

            $User_ID = $user->id;

            $userrestaurant = UserRestaurant::where('User_ID', '=', $User_ID)->where('Restaurant_ID', '=', $restaurant_id)->get();

            //dd($userrestaurant);
            if ($userrestaurant != '[]') {
                //dd($userrestaurant);
                return true;
            } else {

                return false;
            }
        });

        Gate::define('IsAdmin', function ($user) {

            $User_ID = $user->id;

            $AdministratorRoleGroup = RoleGroup::where('Name', '=', 'Administrator')->first();
            $SuperAdminRoleGroup = RoleGroup::where('Name', '=', 'Super Admin')->first();
            $AdminRoleGroup = RoleGroup::where('Name', '=', 'Admin')->first();

            $UserRoleGroup = UserRoleGroup::where('User_ID', '=', $User_ID)->whereIn('RoleGroup_ID', [$AdministratorRoleGroup->id, $SuperAdminRoleGroup->id, $AdminRoleGroup->id])->get();

            //dd($UserRoleGroup);
            if ($UserRoleGroup != '[]') {
                //dd($UserRoleGroup);
                return true;
            } else {

                return false;
            }
        });
        
        Gate::define('IsSuperAdmin', function ($user) {

            $User_ID = $user->id;

            $AdministratorRoleGroup = RoleGroup::where('Name', '=', 'Administrator')->first();
            $SuperAdminRoleGroup = RoleGroup::where('Name', '=', 'Super Admin')->first();

            $UserRoleGroup = UserRoleGroup::where('User_ID', '=', $User_ID)->whereIn('RoleGroup_ID', [$AdministratorRoleGroup->id, $SuperAdminRoleGroup->id])->get();

            //dd($UserRoleGroup);
            if ($UserRoleGroup != '[]') {
                //dd($UserRoleGroup);
                return true;
            } else {

                return false;
            }
        });
    }
}
