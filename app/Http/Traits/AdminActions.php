<?php

namespace App\Http\Traits;

use App\Admin;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

trait AdminActions
{

    /**
     * creates a new admin 
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Admin
     */
    public function createAdmin(Request $request)
    {
        $validatedData = $this->validateAdminsRequest($request);

        if ($request->hasFile('image')) {
            $img_filePath = $this->store_image($request);
            $admin = Admin::create(array_merge(
                $validatedData,
                ['image' => $img_filePath]
            ));
        } else {
            $admin = Admin::create($validatedData);
        }
        return $admin;
    }

    /**
     * Stores admin's image 
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Intervention\Image\Facades\Image $img_filePath      
     */
    public function storeAdminImage(Request $request)
    {
        $img_filePath = $request->file('image')->store('uploads/admins_img', 'public');

        //resize uploaded tenant image
        $image = Image::make(public_path("storage/{$img_filePath}"))->fit(200, 200);
        $image->save();

        return $img_filePath;
    }

    /**
     * Validates Admin details
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array      
     */
    public function validateAdminsRequest(Request $request)
    {
        return $request->validate([
            'surname' => 'required',
            'other_names' => 'required',
            'gender' => 'required',
            'national_id' => 'required|min:8|unique:admins',
            'phone_no' => 'required|max:12|unique:admins',
            'email' => 'required|email|unique:admins',
            'image' => 'image|mimes:jpeg,png,jpg|max:1999',
        ]);
    }
}
