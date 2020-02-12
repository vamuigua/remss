<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\House;
use Illuminate\Http\Request;

class HousesController extends Controller
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
            $houses = House::where('house_no', 'LIKE', "%$keyword%")
                ->orWhere('features', 'LIKE', "%$keyword%")
                ->orWhere('rent', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('water_meter_no', 'LIKE', "%$keyword%")
                ->orWhere('electricity_meter_no', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $houses = House::latest()->paginate($perPage);
        }

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
        
        House::create($requestData);

        return redirect('admin/houses')->with('flash_message', 'House added!');
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

        return redirect('admin/houses')->with('flash_message', 'House updated!');
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

    public function validateRequest(Request $request){
        return $request->validate([
            'house_no' => 'required',
            'features' => 'required',
            'rent' => 'required',
            'status' => 'required',
            'water_meter_no' => 'required',
            'electricity_meter_no' => 'required'
        ]);
    }
}
