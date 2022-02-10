<?php

namespace App\Helpers;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Message;

class IdomooVideo extends IdomooBase
{
    const STATUS_IN_PROCESS = 'IN_PROCESS';
    const STATUS_IN_QUEUE = 'IN_QUEUE';
    const STATUS_RENDERING = 'RENDERING';
    const STATUS_VIDEO_AVAILABLE = 'VIDEO_AVAILABLE';
    const STATUS_ERROR = 'ERROR';
    const STATUS_NOT_EXIST = 'NOT_EXIST';

    const STATUSES = [
        self::STATUS_IN_PROCESS,
        self::STATUS_IN_QUEUE,
        self::STATUS_RENDERING,
        self::STATUS_VIDEO_AVAILABLE,
        self::STATUS_ERROR,
        self::STATUS_NOT_EXIST,
    ];

    public function checkStatus($checkUrl)
    {

    }

    public function generate(array $data = [])
    {
        try {
            $url = self::US_URL . '/storyboards/generate';
            $client = new GuzzleHttpClient();
            $response = $client->post($url, [
                'json' => $data,
                'headers' => $this->generateGuzzleHeaders()
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            $content = $body->getContents();
            dump('$statusCode:', $statusCode);
            dump('$body:', $body);
            dump('$content:', $content);
            // save or update current storyboard
            return true;
        } catch (ClientException $e) {
            dump(Message::toString($e->getRequest()));
            dump(Message::toString($e->getResponse()));
        }
    }
}