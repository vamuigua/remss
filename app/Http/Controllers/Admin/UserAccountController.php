<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Traits\AdminActions;
use App\Http\Traits\TenantActions;
use App\User;
use App\Admin;
use App\Role;
use App\Tenant;

class UserAccountController extends Controller
{
    use AdminActions;
    use TenantActions;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 20;
        $users = User::latest()->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admins = Admin::all()->where('user_id', null);
        $tenants = Tenant::all()->where('user_id', null);
        return view('admin.users.create', compact('admins', 'tenants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role_user = Role::where('name', 'User')->first();
        $role_admin = Role::where('name', 'Admin')->first();

        // check which user_account_for was selected
        if ($request['user_account_for'] == 'new_admin') {
            // validate admin request details
            $validatedData = $this->validateAdminsRequest($request);
            // create new user
            $user = $this->createUser($validatedData);
            // attach role admin to new user
            $user->roles()->attach($role_admin);
            // create a new admin
            $admin = $this->createAdmin($request);
            // assign the user->id to admin->user_id & save
            $user->admin()->save($admin);
        } else if ($request['user_account_for'] == 'new_tenant') {
            // validate tenant details
            $validatedData = $this->validateTenantsRequest($request);
            // create new user
            $user = $this->createUser($validatedData);
            // attach role tenant to user
            $user->roles()->attach($role_user);
            // create new tenant
            $tenant = $this->createTenant($request);
            // assign user->id to tenant->user_id & save
            $user->tenant()->save($tenant);
        } else if ($request['user_account_for'] == 'existing_admin') {
            // get the admin
            $admin = Admin::findOrFail($request['admin_id']);
            // create new user
            $user = User::create([
                'name' => $admin->other_names . ' ' . $admin->surname,
                'email' => $admin->email,
                'password' => $admin->national_id,
            ]);
            // attach role admin to user
            $user->roles()->attach($role_admin);
            // attach user->id to admin->user_id & save admin
            $user->admin()->save($admin);
        } else if ($request['user_account_for'] == 'existing_tenant') {
            // get the tenant
            $tenant = Tenant::findOrFail($request['tenant_id']);
            // create new user
            $user = User::create([
                'name' => $tenant->other_names . ' ' . $tenant->surname,
                'email' => $tenant->email,
                'password' => $tenant->national_id,
            ]);
            // attach role tenant to user
            $user->roles()->attach($role_user);
            // attach user->id to admin->user_id & save tenant
            $user->tenant()->save($tenant);
        } else {
            return redirect('admin/users/')->with('flash_message_error', 'User Account Not Selected!');
        }

        return redirect('admin/users/' . $user->id)->with('flash_message', 'User Account created successfully!');
    }

    // creates a new user for new tenants & new admins
    public function createUser($validatedData)
    {
        $user = User::create(
            [
                'name' => $validatedData['other_names'] . ' ' . $validatedData['surname'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['national_id']) // default password is national_id
            ]
        );
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // add updating of notification preference
        // database, mail

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // need to deactivate a user account NOT delete a user  
    }
}
