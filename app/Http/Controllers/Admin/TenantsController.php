<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TenantsImport;
use App\Exports\TenantsExport;
use App\Http\Traits\TenantActions;
use App\Tenant;
use App\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class TenantsController extends Controller
{
    use TenantActions;

    /**
     * Display a listing all resources.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = Tenant::count();
        $tenants = Tenant::latest()->paginate($perPage);
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
        $tenant = $this->createTenant($request);
        return redirect('admin/tenants/' . $tenant->id)->with('flash_message', 'Tenant added!');
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
        $validatedData = $this->validateUpdatedTenantsRequest($request);
        $tenant = Tenant::findOrFail($id);

        // Conditions to check if image or file was passed or even both
        if ($request->hasFile('image') && !($request->hasFile('file'))) {
            // Image Only
            $tenant->update(array_merge(
                $validatedData,
                ['image' => $this->storeTenantImage($request)]
            ));
        } elseif ($request->hasFile('file') && !($request->hasFile('image'))) {
            // File Only
            $tenant->update(array_merge(
                $validatedData,
                ['file' => $this->storeTenantFile($request)]
            ));
        } else if ($request->hasFile('image') && $request->hasFile('file')) {
            // Image and File
            $tenant->update(array_merge(
                $validatedData,
                ['image' => $this->storeTenantImage($request)],
                ['file' => $this->storeTenantFile($request)]
            ));
        } else {
            $tenant->update($validatedData);
        }

        return redirect('admin/tenants/' . $tenant->id)->with('flash_message', 'Tenant updated!');
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


    /**
     * Validates & Imports Tenant Excel Files
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function importTenantsData(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx, xls, csv'
        ]);

        $extension = $request->file('import_file')->getClientOriginalExtension();

        if ($extension === "xlsx" || $extension === "xls" || $extension === "csv") {
            $tenantsImport = new TenantsImport;
            Excel::import($tenantsImport, $request->file('import_file'));
            return redirect('admin/tenants')->with('flash_message', 'Tenants Imported!');
        } else {
            return redirect('admin/tenants')->with('flash_message_error', 'Failed to Import upload file!');
        }
    }

    /**
     * Exports all Tenant Details from the Database
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function exportTenantsData(Request $request)
    {
        $format = $request['excel_format'];
        return Excel::download(new TenantsExport, 'Tenants.' . $format);
    }

    /**
     * Assign a house to a tenant
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
            if ($current_tenant->house !== null) {
                $current_tenant->house->status = 'vacant';
                $current_tenant->house->tenant_id = null;
                $current_tenant->house->save();
            }

            $house->save();

            return back()->with('flash_message', 'Tenant Successfully assigned House No: ' . $house_no);
        } elseif ($house->status === 'occipied') {
            return back()->with('flash_message_error', 'House No: ' . $house_no . ' is currently Occupied! Please select a vacant house');
        }
    }

    /**
     * Revoke a House from a Tenant
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function revokeHouse(Request $request)
    {
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
        } else {
            return back()->with('flash_message_error', 'Tenant does not have an assigned House!');
        }
    }

    /**
     * Download Agreement Document
     *
     * @param int $id
     * 
     * @return \Illuminate\View\View
     */
    public function download_doc($id)
    {
        $tenant = Tenant::findOrFail($id);
        if ($tenant->file != null) {
            $file_path = 'public/uploads/agreement_docs/' . $tenant->file;
            return Storage::download($file_path, $tenant->file);
        } else {
            return "The Agreement Document does not exist in the Database. Please add one";
        }
    }

    /**
     * View Agreement Document in Browser
     *
     * @param int $id
     * 
     * @return \Illuminate\View\View
     */
    public function view_doc($id)
    {
        $tenant = Tenant::findOrFail($id);
        $filename = $tenant->file;

        if ($filename != null) {
            $pathToFile = public_path('storage\uploads\agreement_docs\\' . $filename);
            // headers for pdf file
            $headers =  [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $tenant->file . '"',
                'Content-Transfer-Encoding' => 'binary',
                'Accept-Ranges' => 'bytes'
            ];

            return response()->file($pathToFile, $headers);
        } else {
            return "The Agreement Document does not exist in the Database. Please add one";
        }
    }
}
