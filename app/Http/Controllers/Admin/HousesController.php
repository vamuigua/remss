<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\House;
use App\Imports\HousesImport;
use App\Exports\HousesExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HousesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $houses = DB::table('houses')->latest()->get();
        return view('admin.houses.index', compact('houses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $house = new House();
        return view('admin.houses.create', compact('house'));
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
        $requestData = $this->validateRequest($request);
        $house = House::create($requestData);
        return redirect('admin/houses/' . $house->id)->with('flash_message', 'House added!');
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
        $house = House::findOrFail($id);
        return view('admin.houses.show', compact('house'));
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
        $house = House::findOrFail($id);
        return view('admin.houses.edit', compact('house'));
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
        $requestData = $this->validateRequest($request);
        $house = House::findOrFail($id);
        $house->update($requestData);
        return redirect('admin/houses/' . $house->id)->with('flash_message', 'House updated!');
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
        House::destroy($id);
        return redirect('admin/houses')->with('flash_message', 'House deleted!');
    }

    public function validateRequest(Request $request)
    {
        return $request->validate([
            'house_no' => 'required',
            'features' => 'required',
            'rent' => 'required',
            'status' => 'required',
            'water_meter_no' => 'required',
            'electricity_meter_no' => 'required'
        ]);
    }

    // Validates & Imports House Excel Files
    public function importHousesData(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx, xls, csv'
        ]);

        $extension = $request->file('import_file')->getClientOriginalExtension();

        if ($extension === "xlsx" || $extension === "xls" || $extension === "csv") {
            Excel::import(new HousesImport, $request->file('import_file'));
            return redirect('admin/houses')->with('flash_message', 'Houses Imported...All good!');
        } else {
            return redirect('admin/houses')->with('flash_message_error', 'Failed to Import upload file!');
        }
    }

    // Exports all House Details from the Database
    public function exportHousesData(Request $request)
    {
        $format = $request['excel_format'];
        return Excel::download(new HousesExport, 'Houses.' . $format);
    }
}
