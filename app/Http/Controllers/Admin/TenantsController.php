<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tenant;
use Illuminate\Http\Request;

class TenantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $tenants = Tenant::where('surname', 'LIKE', "%$keyword%")
                ->orWhere('other_names', 'LIKE', "%$keyword%")
                ->orWhere('gender', 'LIKE', "%$keyword%")
                ->orWhere('national_id', 'LIKE', "%$keyword%")
                ->orWhere('phone_no', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $tenants = Tenant::latest()->paginate($perPage);
        }

        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tenant = new Tenant();
        return view('admin.tenants.create', compact('tenant'));
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
            $img_filePath = $request->file('image')->store('uploads/tenants_img', 'public');

            Tenant::create(array_merge(
                $validatedData,
                ['image' => $img_filePath]
            ));
        }else{
            Tenant::create($validatedData);
        }

        return redirect('admin/tenants')->with('flash_message', 'Tenant added!');
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
        $tenant = Tenant::findOrFail($id);

        return view('admin.tenants.show', compact('tenant'));
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
        $tenant = Tenant::findOrFail($id);

        return view('admin.tenants.edit', compact('tenant'));
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
        $tenant = Tenant::findOrFail($id);

        if ($request->hasFile('image')) {
            $img_filePath = $request->file('image')->store('uploads/tenants_img', 'public');

            $tenant->update(array_merge(
                $validatedData,
                ['image' => $img_filePath]
            ));

        }else{
            $tenant->update($validatedData);
        }

        return redirect('admin/tenants')->with('flash_message', 'Tenant updated!');
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
        Tenant::destroy($id);

        return redirect('admin/tenants')->with('flash_message', 'Tenant deleted!');
    }

    public function validateRequest(Request $request){
        return $request->validate([
            'surname' => 'required',
            'other_names' => 'required',
            'gender' => 'required',
            'national_id' => 'required',
            'phone_no' => 'required|max:12',
            'email' => 'required|email',
            'image' => 'image',
        ]);
    }
}
