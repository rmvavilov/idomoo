<?php

namespace App\Helpers;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Message;

class IdomooStoryBoard extends IdomooBase
{
    const DEFAULT_STORY_BOARD_ID = 31193;

    public function getStoryBoard()
    {
        try {
            $url = self::US_URL . '/storyboards/' . self::DEFAULT_STORY_BOARD_ID;
            $client = new GuzzleHttpClient();
            $response = $client->get($url, [
                'headers' => $this->generateGuzzleHeaders()
            ]);
            // storyboard_id
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            $content = $body->getContents();
            dump('$statusCode:', $statusCode);
            dump('$body:', $body);
            dump('$content:', $content);
            // save or update current storyboard
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $errorResponseBody = $response->getBody()->getContents();
            dump(Message::toString($e->getRequest()));
            dump($response->getStatusCode());
            dump(Message::toString($response));
            $json = json_decode($errorResponseBody);
            $success = ($json->status ?? '') !== 'Error';
            dump($success);
            dump($errorResponseBody);
            dump($json);
        }
    }
}