<?php

namespace Tests\Traits;

use App\Role;
use App\User;
use App\Admin;
use App\Tenant;

trait MainActions
{
    // generates an Admin Role
    public function generateAdminRole()
    {
        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->description = 'An Admin';
        $role_admin->save();
    }

    // generates a User with Role Admin
    public function generateUserWithRoleAdmin()
    {
        $this->generateAdminRole();
        $this->actingAs(factory(User::class)->create());
        $user = User::latest()->first();
        factory(Admin::class)->create(['user_id' => $user->id]);
        $user->roles()->attach(Role::where('name', 'Admin')->first());
        return $user;
    }

    // generates an User Role
    public function generateUserRole()
    {
        $role_user = new Role();
        $role_user->name = 'User';
        $role_user->description = 'A User';
        $role_user->save();
    }

    // generates a User with Role User
    public function generateUserWithRoleUser()
    {
        $this->generateUserRole();
        $this->actingAs(factory(User::class)->create());
        $user = User::latest()->first();
        factory(Tenant::class)->create(['user_id' => $user->id]);
        $user->roles()->attach(Role::where('name', 'User')->first());
        return $user;
    }
}
