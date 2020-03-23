<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jobs\SendMessageJob;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        return view('admin.messages.create');
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
        
        $requestData = $request->all();
        
        // create a new message entry
        $message = Message::create($requestData);

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
}
