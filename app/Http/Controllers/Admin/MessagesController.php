<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jobs\SendMessageJob;

use App\Message;
use App\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use SimpleXLSX;

class MessagesController extends Controller
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
            $messages = Message::where('message', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $messages = Message::latest()->paginate($perPage);
        }

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $message = new Message();
        return view('admin.messages.create', compact('message'));
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
        $recepients = [];
        $requestData = $this->validateRequest($request);

        // check option of send_to
        // option for excel
        if($requestData['send_to'] == "excel"){
            $request->validate(['import_file' => 'required|file|mimes:xlsx']);
            
            // Open Excel File and store phone numbers 
            if ( $xlsx = SimpleXLSX::parse($request->file('import_file')) ) {
                foreach ($xlsx->rows() as $row) {
                    array_push($recepients, $row[0]);
                }
                $recepients_str = implode(", ",$recepients);
            } 
            else {
                return redirect('admin/messages/create')->with('flash_message_error', SimpleXLSX::parseError());
            }
        }
        // option for all_tenants
        else if($requestData['send_to'] == "all_tenants"){
            $tenant_phone_numbers = Tenant::all()->pluck('phone_no');
            
            foreach ($tenant_phone_numbers as $phone_no){
                array_push($recepients, $phone_no);
            }
            $recepients_str = implode(", ",$recepients);
        }
        
        // create a new message entry
        $message = Message::create(array_merge(
            $requestData,
            ['recepients' => $recepients_str]
        ));

        // dispatch job for sending bulk message
        $when = Carbon::now()->addSeconds(5);
        SendMessageJob::dispatch($message)->delay($when);

        return redirect('admin/messages')->with('flash_message', 'The Message will be sent to the Recepients shortly!');
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
        $message = Message::findOrFail($id);

        return view('admin.messages.show', compact('message'));
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
        $message = Message::findOrFail($id);

        return view('admin.messages.edit', compact('message'));
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
        
        $requestData = $request->all();
        
        $message = Message::findOrFail($id);
        $message->update($requestData);

        return redirect('admin/messages')->with('flash_message', 'Message updated!');
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
        Message::destroy($id);

        return redirect('admin/messages')->with('flash_message', 'Message deleted!');
    }

    // Validates Tenant Request Details
    public function validateRequest(Request $request){
        return $request->validate([
            'message' => 'required',
            'send_to' => 'required',
        ]);
    }
}
