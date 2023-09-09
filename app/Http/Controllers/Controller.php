<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function success($message, $data, $code){
        return response()->json(['message' => $message, 'data' => $data, 'code'=> $code], $code);
    }
    public function error($message, $code){
        return response()->json(['message' => $message, 'data' => null,'code' => $code],  $code);
    }
}
