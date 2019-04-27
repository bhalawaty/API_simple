<?php

namespace App\Http\Controllers\api;

trait ApiResponseTrait
{

//        data=>data
//        status=>true:false
//        message=> error:success

    public function apiResponse($data = null, $message = null, $code = 200)
    {

        $array = [
            'data' => $data,
            'status' => in_array($code ,$this->successCodeArray())? true : false,
            'message' => $message
        ];

        return response($array,$code);

    }

    public function successCodeArray(){
        return [
            201,202,200
        ];
    }

}