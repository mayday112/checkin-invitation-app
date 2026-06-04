<?php

namespace App\Jobs;

use App\Models\Guest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendWhatsAppInvitation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $guest;

    public function __construct(Guest $guest)
    {
        $this->guest = $guest;
    }

    public function handle(): void
    {
        // 1. Generate QR code in base64 format
        $qrImage = QrCode::format('png')->size(300)->generate($this->guest->guest_code);
        $base64Qr = base64_encode($qrImage);

        // 2. Format message
        $event = $this->guest->event;
        $date = $event->event_date ? $event->event_date->format('l, d F Y H:i') : 'TBA';
        $location = $event->location ?? 'TBA';

        $message = "Hello {$this->guest->name},\n\n";
        $message .= "You are invited to *{$event->name}*!\n\n";
        $message .= "📅 Date: {$date}\n";
        $message .= "📍 Location: {$location}\n";
        $message .= "🎟️ Quota: {$this->guest->quota} Person(s)\n\n";
        $message .= "Please find your Check-in QR Code attached. Present it at the entrance.\n\n";
        $message .= "Guest Code: {$this->guest->guest_code}\n\n";
        $message .= "Thank you!";

        // 3. Send payload to Node.js WA Service
        $waServiceUrl = env('WA_SERVICE_URL', 'http://localhost:3000/send-message');

        try {
            Http::post($waServiceUrl, [
                'phone' => $this->guest->phone,
                'message' => $message,
                'mediaBase64' => $base64Qr,
                'mediaMime' => 'image/png',
            ]);
        } catch (\Exception $e) {
            // Re-throw to make the job fail and retry if necessary
            throw $e;
        }
    }
}
