<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WhatsAppHelper
{
    /**
     * Kirim notifikasi WhatsApp via API Fonnte
     *
     * @param string $recipient Nomor WA tujuan (62xxx)
     * @param string $message   Pesan yang dikirim
     * @return void
     */
    public static function sendNotification($recipient, $message)
    {
        $client = new Client();
        $apiToken = config('services.fonnte.token'); // ambil dari .env, bukan hardcode

        // Format nomor WA (ubah 08 jadi 628)
        if (substr($recipient, 0, 1) === '0') {
            $recipient = '62' . substr($recipient, 1);
        }

        $url = "https://api.fonnte.com/send";

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => $apiToken,
                ],
                'form_params' => [
                    'target' => $recipient,
                    'message' => $message,
                ],
            ]);

            Log::info("WA sent to {$recipient}: {$message}");
        } catch (RequestException $e) {
            Log::error("WA send failed: " . $e->getMessage());
        }
    }
}
