<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Traits\AdminActions;
use App\User;
use App\Admin;
use App\Role;

class UserAccountController extends Controller
{
    use AdminActions;

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
        $user = new User();
        $admin = new Admin();
        return view('admin.users.create', compact('user', 'admin'));
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
            $user = User::create([
                'name' => $validatedData['other_names'] .' '. $validatedData['surname'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['national_id']) // default password is national_id
                ]
            );

            // attach role admin to new user
            $user->roles()->attach($role_admin);

            // create a new admin
            $admin = $this->createAdmin($request);
            
            // attach the user->id to admin->user_id
            $admin->user_id = $user->id;
            $admin->save();

        }else if($request['user_account_for'] == 'new_tenant'){
            // create new user
            // attach role tenant to user
            // create new tenant
            // attach user->id to tenant->user_id
            // save tenant
            
        }else if($request['user_account_for'] == 'existing_admin'){
            // create new user
            // attach role admin to user
            // attach user->id to admin->user_id
            // save admin
        }else if($request['user_account_for'] == 'existing_tenant'){
            // create new user
            // attach role tenant to user
            // attach user->id to admin->user_id
            // save tenant
        }

        return redirect('admin/users/'.$user->id)->with('flash_message', 'User Account created successfully!');
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
