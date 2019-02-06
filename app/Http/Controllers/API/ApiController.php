<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    /**
     * API response function to be used by all endpoints
     * @param array $body
     * @param null $message
     * @param bool $success
     * @param int $status
     * @return JsonResponse response
     */
    public function api_response($data, $success = true, $message = null, $status = 200,$nextUrl=''){
        if(is_object($data)){
          $data = $data->toArray();
        }else if(empty($data)){
          $data=(object)$data;  
        }
        $payload=[
                'status' => $success,
                'message' => $message,
                'data'=>$data   
             ];
        if(isset($nextUrl) && $nextUrl != '')
          $payload['next_page_url'] = $nextUrl;     
      
        return Response::json($payload,$status);
    }
}
