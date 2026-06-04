<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function scanner(Event $event)
    {
        return view('checkin.scanner', compact('event'));
    }

    public function process(Request $request, Event $event)
    {
        $request->validate([
            'guest_code' => 'required|string',
            'gate' => 'nullable|string',
        ]);

        $guest = $event->guests()->where('guest_code', $request->guest_code)->first();

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Guest not found for this event.',
            ], 404);
        }

        if ($guest->status === 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'Guest already checked in at ' . $guest->checked_in_at->format('Y-m-d H:i:s'),
                'guest' => $guest
            ], 400);
        }

        if ($guest->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Guest invitation is cancelled.',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $guest->update([
                'status' => 'checked_in',
                'checked_in_at' => now(),
            ]);

            $guest->checkins()->create([
                'gate' => $request->gate ?? 'Main Gate',
                'operator_name' => auth()->user()->name ?? 'System',
                'checked_in_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Check-in successful!',
                'guest' => $guest
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'System error during check-in.',
            ], 500);
        }
    }
}
