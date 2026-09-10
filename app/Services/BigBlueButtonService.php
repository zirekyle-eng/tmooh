<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class BigBlueButtonService
{
    public function createMeeting(string $name, string $meetingId): string
    {
        $baseUrl = config('services.bbb.base_url');
        $secret = config('services.bbb.secret');

        if (!$baseUrl || !$secret) {
            throw new RuntimeException('إعدادات BigBlueButton غير مكتملة.');
        }

        $params = [
            'allowStartStopRecording' => 'true',
            'attendeePW' => Str::random(16),
            'autoStartRecording' => 'false',
            'meetingID' => $meetingId,
            'moderatorPW' => Str::random(20),
            'name' => $name,
            'record' => 'true',
        ];

        $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $checksum = sha1('create' . $query . $secret);
        $response = Http::timeout(15)->get($baseUrl . 'api/create', $params + ['checksum' => $checksum]);

        if (!$response->successful()) {
            throw new RuntimeException('تعذر الاتصال بخادم BigBlueButton.');
        }

        $xml = @simplexml_load_string($response->body());
        if (!$xml || (string) $xml->returncode !== 'SUCCESS') {
            throw new RuntimeException((string) ($xml->message ?? 'تعذر إنشاء غرفة BigBlueButton.'));
        }

        $joinParams = [
            'fullName' => 'طالب',
            'meetingID' => $meetingId,
            'password' => $params['attendeePW'],
        ];
        $joinQuery = http_build_query($joinParams, '', '&', PHP_QUERY_RFC3986);
        $joinChecksum = sha1('join' . $joinQuery . $secret);

        return $baseUrl . 'api/join?' . $joinQuery . '&checksum=' . $joinChecksum;
    }
}