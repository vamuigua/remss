<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Admin;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $admins = Admin::latest()->paginate($perPage);

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $admin = new Admin();
        return view('admin.admins.create', compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            $img_filePath = $this->store_image($request);
            Admin::create(array_merge(
                    $validatedData,
                    ['image' => $img_filePath]
                ));
        }else{
            Admin::create($validatedData);
        }

        return redirect('admin/admins')->with('flash_message', 'Admin added!');
    }

    // stores admin's image
    public function store_image(Request $request){
        $img_filePath = $request->file('image')->store('uploads/tenants_img', 'public');

        //resize uploaded tenant image
        $image = Image::make(public_path("storage/{$img_filePath}"))->fit(200, 200);
        $image->save();

        return $img_filePath;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $validatedData = $this->validateRequest($request);
        $admin = Admin::findOrFail($id);

        if ($request->hasFile('image')) {
            $img_filePath = $this->store_image($request);
            $admin->update(array_merge(
                $validatedData,
                ['image' => $img_filePath]
            ));
        }else{
            $admin->update($validatedData);
        }

        return redirect('admin/admins/'.$id)->with('flash_message', 'Admin updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Admin::destroy($id);

        return redirect('admin/admins')->with('flash_message', 'Admin deleted!');
    }

    // Validates Admin Request Details
    public function validateRequest(Request $request){
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
