<?php

namespace App\Http\Controllers\Api;

Trait ApiResponse{

    function apiResponse($data = null,$message=null,$code=200){

        return response()->json([
            'status'=>true,
            'message'=>$message,
            'data'=>$data
        ],$code);
    }

    function errorResponse($message=null,$code=null){
        return response()->json([
            'status'=>'false',
            'message'=>$message
        ],$code);
    }

    function SuccessResponse($message=null,$code=200){
        return response()->json([
            'status'=>'true',
            'message'=>$message
        ],$code);
    }
}