<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use App\Services\GuestImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GuestController extends Controller
{
    public function index(Event $event)
    {
        $guests = $event->guests()->latest()->paginate(20);
        return view('guests.index', compact('event', 'guests'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'quota' => 'nullable|integer|min:1',
        ]);

        $guestCode = 'EVT-' . $event->id . '-' . strtoupper(Str::random(6));

        $guest = $event->guests()->create([
            'guest_code' => $guestCode,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'quota' => $validated['quota'] ?? 1,
            'status' => 'pending',
        ]);

        // Dispatch job to send WA
        \App\Jobs\SendWhatsAppInvitation::dispatch($guest);

        return back()->with('success', 'Guest added and invitation sent via WhatsApp.');
    }

    public function import(Request $request, Event $event, GuestImportService $importService)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        $import = $importService->import($event, $request->file('file'));

        return back()->with('success', "Import completed. {$import->successful_rows} imported successfully, {$import->failed_rows} failed.");
    }

    public function downloadQr(Guest $guest)
    {
        $qrCode = QrCode::format('png')->size(300)->generate($guest->guest_code);
        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="QR_'.$guest->guest_code.'.png"');
    }
    
    public function destroy(Guest $guest)
    {
        $guest->delete();
        return back()->with('success', 'Guest removed successfully.');
    }
}
