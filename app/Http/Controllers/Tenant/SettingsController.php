<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{   
    // Profile Settings View
    public function profile($id){
        $user = Auth::user($id);
        return view ('tenant.settings.profile', compact('user'));     
    }

    // Update Profile Picture
    public function updateProfilePic(Request $request){
        $request->validate(['image' => 'image']);

        if ($request->hasFile('image')) {
            $img_filePath = $request->file('image')->store('uploads/tenants_img', 'public');

            //resize uploaded tenant image
            $image = Image::make(public_path("storage/{$img_filePath}"))->fit(200, 200);
            $image->save();

            $user = Auth::user();
            $user->tenant->update(['image' => $img_filePath]);
        }

        return redirect()->back()->with('flash_message', 'Profile Photo updated!');
    }

    // Password Update
    public function updatePassword(Request $request){
        $validatedData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'checkbox' => 'required',
        ]);

        // Conditions to check for Changing Password
        if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            // The passwords not matches
            return redirect()->back()->with("flash_message_error","Your current password does not matches with the password you provided. Please try again.");
            // return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
        }

        if(strcmp($request->get('old_password'), $request->get('password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("flash_message_error","New Password cannot be same as your current password. Please choose a different password.");
            // return response()->json(['errors' => ['current'=> ['New Password cannot be same as your current password']]], 422);
        }

        if(strcmp($request->get('password'), $request->get('password_confirmation')) != 0){
            return redirect()->back()->with("flash_message_error","New Password does not match your Re-typed Password.");
        }

        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($validatedData['password']);
        $user->save();
        return redirect()->back()->with('flash_message', 'Password Updated Successfully!');
    }
}
