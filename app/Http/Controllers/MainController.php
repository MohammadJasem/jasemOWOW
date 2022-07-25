<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class MainController extends Controller
{
    //-------------------
    const SUCCESS = 200;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const VALIDATION_ERROR = 422;
    //-------------------
    protected Request $request;
    protected array $resData;
    protected array $errData;
    protected string $msg;
    protected User $user;

    public function __construct(Request $request){
        $this->request = $request;
        $this->resData = $this->errData = [];
        $this->msg = '';
        if(auth('sanctum')->user())
            $this->user = auth('sanctum')->user();
    }

    public function response(array $data, string $message='', int $code=self::SUCCESS): JsonResponse {
        $response = [
            'data'      => 	$data,
            'message'   =>  $message,
        ];

        return new JsonResponse($response, $code);
    }

    public function error(string $message, array $errors=[], int $code=self::BAD_REQUEST): JsonResponse{
        $response = [
            'message'   => 	$message,
            'errors'    =>  $errors,
        ];

        return new JsonResponse($response, $code);
    }
}
