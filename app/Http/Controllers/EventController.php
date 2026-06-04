<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount('guests')->latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
        ]);

        $event = Event::create($validated);

        return redirect()->route('events.show', $event)->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $totalGuests = $event->guests()->count();
        $checkedIn = $event->guests()->where('status', 'checked_in')->count();
        $pending = $totalGuests - $checkedIn;
        $attendancePercentage = $totalGuests > 0 ? round(($checkedIn / $totalGuests) * 100) : 0;

        return view('events.show', compact('event', 'totalGuests', 'checkedIn', 'pending', 'attendancePercentage'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
