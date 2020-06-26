<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NoticeSentNotification;

class NoticesController extends Controller
{
    use Notifiable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = 25;
        $notices = Notice::latest()->paginate($perPage);
        return view('admin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $notice = new Notice;
        return view('admin.notices.create', compact('notice'));
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

        $notice = Notice::create($requestData);

        // Grab all Tenants only, remove Admins from the query
        $users = User::all()->reject(function ($user) {
            return $user->hasRole('User') === false;
        });

        //Send Notice Notification to Tenants
        Notification::send($users, new NoticeSentNotification($notice));

        return redirect('admin/notices')->with('flash_message', 'Notice added! Tenants will receive a Notice Notification shortly!');
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
        $notice = Notice::findOrFail($id);

        return view('admin.notices.show', compact('notice'));
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
        $notice = Notice::findOrFail($id);

        return view('admin.notices.edit', compact('notice'));
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

        $notice = Notice::findOrFail($id);
        $notice->update($requestData);

        return redirect('admin/notices')->with('flash_message', 'Notice updated!');
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
        Notice::destroy($id);

        return redirect('admin/notices')->with('flash_message', 'Notice deleted!');
    }

    public function validateRequest(Request $request)
    {
        return $request->validate([
            'subject' => 'required',
            'message' => 'required|min:5',
        ]);
    }
}
