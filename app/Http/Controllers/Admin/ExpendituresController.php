<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Expenditure;
use Illuminate\Http\Request;

class ExpendituresController extends Controller
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
            $expenditures = Expenditure::where('outgoings', 'LIKE', "%$keyword%")
                ->orWhere('amount', 'LIKE', "%$keyword%")
                ->orWhere('particulars', 'LIKE', "%$keyword%")
                ->orWhere('expenditure_date', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $expenditures = Expenditure::latest()->paginate($perPage);
        }

        return view('admin.expenditures.index', compact('expenditures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $expenditure = new Expenditure;
        return view('admin.expenditures.create', compact('expenditure'));
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
        
        Expenditure::create($requestData);

        return redirect('admin/expenditures')->with('flash_message', 'Expenditure added!');
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
        $expenditure = Expenditure::findOrFail($id);

        return view('admin.expenditures.show', compact('expenditure'));
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
        $expenditure = Expenditure::findOrFail($id);

        return view('admin.expenditures.edit', compact('expenditure'));
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
        
        $expenditure = Expenditure::findOrFail($id);
        $expenditure->update($requestData);

        return redirect('admin/expenditures')->with('flash_message', 'Expenditure updated!');
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
        Expenditure::destroy($id);

        return redirect('admin/expenditures')->with('flash_message', 'Expenditure deleted!');
    }

    public function validateRequest(Request $request){
        return $request->validate([
            'outgoings' => 'required',
            'amount' => 'required|numeric',
            'particulars' => 'required|min:5',
            'expenditure_date' => 'required|date_format:Y-m-d',
        ]);
    }

    public function expenditureMonths(Request $request){
        dd($request);
    }
}
