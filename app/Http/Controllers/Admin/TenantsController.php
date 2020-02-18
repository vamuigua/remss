<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Imports\TenantsImport;
use App\Exports\TenantsExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Tenant;
use App\House;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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

            //resize uploaded tenant image
            $image = Image::make(public_path("storage/{$img_filePath}"))->fit(200, 200);
            $image->save();

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
        $has_house = $tenant->house; 
        $houses = House::all();

        return view('admin.tenants.show', compact('tenant', 'houses', 'has_house'));
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

            //resize uploaded tenant image
            $image = Image::make(public_path("storage/{$img_filePath}"))->fit(200, 200);
            $image->save();

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
        //check if tenant of $id is occupying a house
        $house = House::where('tenant_id', $id)->first();
        
        if ($house !== null) {
            $house->tenant_id = null;
            $house->status = 'vacant';
            $house->save();
        }
        
        Tenant::destroy($id);

        return redirect('admin/tenants')->with('flash_message', 'Tenant deleted!');
    }

    // Validates Tenant Request Details
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

    // Validates & Imports Tenant Excel Files
    public function importTenantsData(Request $request) 
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx, xls, csv'
        ]);
        
        $extension = $request->file('import_file')->getClientOriginalExtension();

        if($extension === "xlsx" || $extension === "xls" || $extension === "csv"){
            Excel::import(new TenantsImport, $request->file('import_file'));
            return redirect('admin/tenants')->with('flash_message', 'Tenants Imported...All good!');
        }else {
            return redirect('admin/tenants')->with('flash_message_error', 'Failed to Import upload file!');
        }
    }

    // Exports all Tenant Details from the Database
    public function exportTenantsData(Request $request) 
    {
        $format = $request['excel_format'];
        return Excel::download(new TenantsExport, 'Tenants.' . $format);
    }

    //assigns a house to a tenant
    public function assignHouse(Request $request)
    {
        $validatedData = $request->validate([
            'tenant_id' => 'required',
            'house_no' => 'required'
        ]);

        $tenant_id = $validatedData['tenant_id'];
        $house_no = $validatedData['house_no'];

        $current_tenant = Tenant::where('id', $tenant_id)->first();
        $house = House::where('house_no', $house_no)->first();

        //assign house to tenant
        if ($house->status === 'vacant') {
            $house->tenant_id = $tenant_id;
            $house->status = 'occipied';

            //check if the current tenant had was assigned a house previously
            if($current_tenant->house !== null){
                $current_tenant->house->status = 'vacant';
                $current_tenant->house->tenant_id = null;
                $current_tenant->house->save();
            }
            
            $house->save();
            
            return back()->with('flash_message', 'Tenant Successfully assigned House No: ' . $house_no);
        }elseif ($house->status === 'occipied') {
            return back()->with('flash_message_error', 'House No: ' . $house_no . ' is currently Occupied! Please select a vacant house');
        }
    }

    //function to revoke a House from a Tenant
    public function revokeHouse(Request $request){

        $validatedData = $request->validate([
            'tenant_id' => 'required'
        ]);

        $tenant_id = $validatedData['tenant_id'];

        $house = House::where('tenant_id', $tenant_id)->first();
        
        if ($house !== null) {
            $house->tenant_id = null;
            $house->status = 'vacant';
            $house->save();
            return back()->with('flash_message', 'Tenant Successfully revoked House No: ' . $house->house_no);
        }else{
             return back()->with('flash_message_error', 'Tenant does not have an assigned House!');
        }

    }
}
