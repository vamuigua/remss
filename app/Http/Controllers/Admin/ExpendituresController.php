<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $amount_data = array();
        $month_labels = array();
        $total_amount_for_month = 0;

        // get request from user ==> Months + Year
        $months = $request->get('months');  //array
        $year = $request->get('year');      // string

        // for each month in year selected, fetch the expenditure
        foreach ($months as $month) {
            // array of amounts of $month
            $amount = DB::select('select `amount` from expenditures where YEAR(expenditure_date) = :year AND MONTH(expenditure_date) = :month ORDER BY `id`',
                                ['year' => $year, 'month' => $month]);
            
            // sum all the expenditures for the selected month
            foreach ($amount as $value) {
                // store total amount for a month
                $total_amount_for_month += ($value->amount);
            }

            // add total amount for a month to an array
            array_push($amount_data, $total_amount_for_month);
            $total_amount_for_month = 0;

            // add the calculated month expenditure into a year array
            $current_month = date('F', mktime(0,0,0,$month, 1, date('Y')));
            array_push($month_labels, $current_month);
        }
        
        // return results in json  
        return response()->json(array('amount_data'=> $amount_data, 'month_labels'=> $month_labels), 200);
    }
}
