<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\WaterReading;
use App\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class WaterReadingsController extends Controller
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
            $waterreadings = WaterReading::where('house_id', 'LIKE', "%$keyword%")
                ->orWhere('prev_reading', 'LIKE', "%$keyword%")
                ->orWhere('current_reading', 'LIKE', "%$keyword%")
                ->orWhere('units_used', 'LIKE', "%$keyword%")
                ->orWhere('cost_per_unit', 'LIKE', "%$keyword%")
                ->orWhere('total_charges', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $waterreadings = WaterReading::latest()->paginate($perPage);
        }

        return view('admin.water-readings.index', compact('waterreadings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $houses = House::all();
        $waterreading = new WaterReading();
        return view('admin.water-readings.create', compact('houses','waterreading'));
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
        
        WaterReading::create($requestData);

        return redirect('admin/water-readings')->with('flash_message', 'WaterReading added!');
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
        $waterreading = WaterReading::findOrFail($id);

        return view('admin.water-readings.show', compact('waterreading'));
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
        $houses = House::all();
        $waterreading = WaterReading::findOrFail($id);

        return view('admin.water-readings.edit', compact('waterreading', 'houses'));
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
        
        $waterreading = WaterReading::findOrFail($id);
        $waterreading->update($requestData);

        return redirect('admin/water-readings')->with('flash_message', 'WaterReading updated!');
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
        WaterReading::destroy($id);

        return redirect('admin/water-readings')->with('flash_message', 'WaterReading deleted!');
    }

    public function validateRequest(Request $request){
        return $request->validate([
            'house_id' => 'required',
            'prev_reading' => 'required',
            'current_reading' => 'required',
            'units_used' => 'required',
            'cost_per_unit' => 'required|max:10',
            'total_charges' => 'required',
        ]);
    }

    // Gets the getPrevWaterReading
    public function getPrevWaterReading(Request $request){
        $house_id = $request->get('house_id');
        
        $prev_reading = DB::select('select `prev_reading` from water_readings where house_id = :house_id ORDER BY `id` DESC LIMIT 1', ['house_id' => $house_id]);

        // checks conditions of the previous water reading
        if($prev_reading == null)
        {
            $prev_reading = '0';
        }
        else if($prev_reading >= '0'){
            $current_reading = DB::select('select `current_reading` from water_readings where house_id = :house_id ORDER BY `id` DESC LIMIT 1', ['house_id' => $house_id]);
            $prev_reading = $current_reading[0]->current_reading;
        }
        
        return response()->json(array('prev_reading'=> $prev_reading), 200);
    }
}
