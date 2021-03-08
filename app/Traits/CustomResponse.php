<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

trait CustomResponse {
    protected $lang_uri = 'api';
    protected $options = JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE;

    protected function respond($data, $message_uri = null, $http_code = 200, $replace = []){
        return response()->json([
            'success' => true,
            'status' => $http_code,
            'data' => $data,
            'message' => $message_uri ? Lang::get($this->lang_uri . '.' . $message_uri, $replace) : ''
        ], $http_code, [], $this->options);
    }

    protected function respondWithMessage($message_uri, $http_code = 200, $replace = []){
        return response()->json([
            'success' => true,
            'status' => $http_code,
            'message' => Lang::get($this->lang_uri . '.' . $message_uri, $replace)
        ], $http_code, [], $this->options);
    }

    protected function respondWithError($error_uri, $http_code, $replace = []){
        return response()->json([
            'success' => false,
            'status' => $http_code,
            'error' => [
                'message' => Lang::get($this->lang_uri . '.' . $error_uri, $replace)
            ]
        ], $http_code, [], $this->options);
    }

    protected function respondWithToken($token, $message_uri){
        return response()->json([
            'success' => true,
            'token' => $token,
            'message' => Lang::get($this->lang_uri . '.' . $message_uri),
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200, [], $this->options);
    }

    protected function respondWithValidationError($error_uri, $http_code, $replace = []){
        $messages = [];

        foreach($error_uri as $key => $val){
            $messages[$key] = Lang::get($val[0], $replace);
        }
        
        return response()->json([
            'success' => false,
            'status' => $http_code,
            'errors' => $messages
        ], $http_code, [], $this->options);
    }
}