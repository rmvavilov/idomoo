<?php

namespace App\Services;

use App\Models\Video;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

class VideoService
{
    public static function checkStatus(Video $video)
    {
        $client = new GuzzleHttpClient();
        $checkStatusUrl = $video->data['output']['video'][0]['links']['check_status_url'] ?? '';

        if (!$checkStatusUrl) {
            return false;
        }

        try {
            $response = $client->get($checkStatusUrl);
            $body = $response->getBody();
            if ($response->getStatusCode() === 200) {
                $data = json_decode($body->getContents());
                $status = $data->status ?? '';
                if ($status) {
                    $video->status = $status;
                    $video->save();
                }
            }
        } catch (ClientException $e) {
            Log::error($e->__toString());
        }
    }
}
