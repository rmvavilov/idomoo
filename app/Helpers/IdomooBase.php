<?php

namespace App\Helpers;

class IdomooBase
{
    const US_URL = 'https://usa-api.idomoo.com/api/v2';

    private $token = '';

    //region [GETTERS/SETTER]

    /**
     * @return string
     */
    protected function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    private function setToken(string $token): void
    {
        $this->token = $token;
    }

    //endregion [GETTERS/SETTER]

    private function generateToken(): string
    {
        return 'Basic ' . base64_encode(config('idomoo.account_id') . ':' . config('idomoo.secret_key'));
    }

    protected function generateGuzzleHeaders($isTestMode = true): array
    {
        $headers = [
            'Authorization' => $this->getToken(),
            'Content-Type' => 'application/json'
        ];

        if ($isTestMode) {
            $headers['x-idomoo-api-mode'] = 'developer';
        }

        return $headers;
    }

    public function __construct()
    {
        $this->setToken($this->generateToken());
    }

}