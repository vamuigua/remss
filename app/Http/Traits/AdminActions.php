<?php
namespace App\Http\Traits;
use App\Admin;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

trait AdminActions {
    // creates a new admin instance
    public function createAdmin(Request $request){
        $validatedData = $this->validateAdminsRequest($request);
        
        if ($request->hasFile('image')) {
            $img_filePath = $this->store_image($request);
            $admin = Admin::create(array_merge(
                $validatedData,
                ['image' => $img_filePath]
            ));
        }else{
            $admin = Admin::create($validatedData);
        }
        return $admin;
    }
    
    // stores admin's image
    public function store_image(Request $request){
        $img_filePath = $request->file('image')->store('uploads/admins_img', 'public');
        
        //resize uploaded tenant image
        $image = Image::make(public_path("storage/{$img_filePath}"))->fit(200, 200);
        $image->save();
        
        return $img_filePath;
    }

    // validates Admin details
    public function validateAdminsRequest(Request $request){
        return $request->validate([
            'surname' => 'required',
            'other_names' => 'required',
            'gender' => 'required',
            'national_id' => 'required|min:8',
            'phone_no' => 'required|max:12',
            'email' => 'required|email',
            'image' => 'image|mimes:jpeg,png,jpg|max:1999',
        ]);
    }
}