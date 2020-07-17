<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

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

    // Show Events Calendar
    public function events_calender()
    {
        $events = Event::all();
        $event_list = array();

        foreach ($events as $event) {
            $event_list[] = Calendar::event(
                $event->event_name, //event title
                $event->all_day, //full day event?
                new \DateTime($event->start_date . 'T' . $event->start_time), //start time, must be a DateTime object or valid DateTime format
                new \DateTime($event->end_date . 'T' . $event->end_time), //end time, must be a DateTime object or valid DateTime format,
                $event->id, //optional event ID
                [
                    'url' => url('/admin/events/' . $event->id),
                    'backgroundColor' => $event->bg_color
                ]
            );
        }
        $calendar_details = Calendar::addEvents($event_list);
        return view('admin.events.calendar', compact('calendar_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $event = new Event;
        return view('admin.events.create', compact('event'));
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
            $event = Event::create($requestData);
            return redirect('admin/events/' . $event->id)->with('flash_message', 'Event added!');
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
            return redirect('admin/events/' . $event->id)->with('flash_message', 'Event updated!');
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
            'description' => 'required|min:10',
            'all_day' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'date_format:"H:i"|required',
            'end_time' => 'date_format:"H:i"|required',
            'bg_color' => 'required',
        ]);
    }
}
