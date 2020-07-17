<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = Event::count();
        $events = Event::latest()->paginate($perPage);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.events.create');
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
        try {
            Event::create($requestData);
            return redirect('admin/events')->with('flash_message', 'Event added!');
        } catch (\Throwable $th) {
            Log::error('Failed to create event: ' . $th->getMessage());
            return redirect('admin/events')->with('flash_message_error', 'Failed to create event!');
        }
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
        $event = Event::findOrFail($id);

        return view('admin.events.show', compact('event'));
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
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
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
        try {
            $event = Event::findOrFail($id);
            $event->update($requestData);
            return redirect('admin/events')->with('flash_message', 'Event updated!');
        } catch (\Throwable $th) {
            Log::error('Failed to update event: ' . $th->getMessage());
            return redirect('admin/events')->with('flash_message_error', 'Failed to update event!');
        }
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
        try {
            Event::destroy($id);
            return redirect('admin/events')->with('flash_message', 'Event deleted!');
        } catch (\Throwable $th) {
            Log::error('Failed to delete event: ' . $th->getMessage());
            return redirect('admin/events')->with('flash_message_error', 'Failed to delete event!');
        }
    }

    // Validate event input
    public function validateRequest(Request $request)
    {
        return $request->validate([
            'event_name' => 'required|min:8',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);
    }
}
