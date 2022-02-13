<?php

namespace App\Repositories;

use App\Models\Error;
use Illuminate\Support\Facades\Log;

class ErrorRepository
{
    public static function save($userId, $request = '', $response = '', $message = '')
    {
        try {
            $error = new Error([
                'user_id' => $userId,
                'request' => json_encode($request),
                'response' => $response,
                'message' => $message,
            ]);
            $error->save();
        } catch (\Exception $e) {
            Log::error($e->__toString());
        }
    }
}
