<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Illuminate\Support\Facades\Http;


class NotifyService
{
    function sendSmsPattern($mobile, array $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('sms.mediana_token'),
        ])
            ->post(config("sms.sms_api"), [
                'recipients' => [
                    $mobile
                ],
                'patternCode' => $message['pattern'],
                'parameters' => $message['message'],
            ]);
        return $response->json();
    }
}
