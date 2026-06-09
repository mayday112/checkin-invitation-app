<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Import;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Jobs\SendWhatsAppInvitation;

class GuestImportService
{
    public function import(Event $event, UploadedFile $file): Import
    {
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // First row is assumed to be header
        $header = array_shift($rows);
        $header = array_map('strtolower', $header);
        
        $nameIndex = array_search('name', $header);
        $phoneIndex = array_search('phone', $header);
        $quotaIndex = array_search('quota', $header);

        if ($nameIndex === false || $phoneIndex === false) {
            throw new \Exception("Missing required columns (name, phone) in the spreadsheet.");
        }

        $import = Import::create([
            'event_id' => $event->id,
            'file_name' => $file->getClientOriginalName(),
            'total_rows' => count($rows),
            'successful_rows' => 0,
            'failed_rows' => 0,
        ]);

        $successful = 0;
        $failed = 0;

        foreach ($rows as $row) {
            $name = $row[$nameIndex] ?? null;
            $phone = $row[$phoneIndex] ?? null;
            $quota = ($quotaIndex !== false) ? ($row[$quotaIndex] ?? 1) : 1;

            if (empty($name) || empty($phone)) {
                $failed++;
                continue;
            }

            // check duplicate phone in this event
            // $exists = $event->guests()->where('phone', $phone)->exists();
            // if ($exists) {
            //     $failed++;
            //     continue;
            // }

            $guestCode = 'EVT-' . $event->id . '-' . strtoupper(Str::random(6));

            $guest = $event->guests()->create([
                'guest_code' => $guestCode,
                'name' => $name,
                'phone' => $phone,
                'quota' => (int)$quota,
                'status' => 'pending',
            ]);

            SendWhatsAppInvitation::dispatch($guest);
            $successful++;
        }

        $import->update([
            'successful_rows' => $successful,
            'failed_rows' => $failed,
        ]);

        return $import;
    }
}
