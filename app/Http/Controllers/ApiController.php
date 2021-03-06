<?php

namespace App\Http\Controllers;

use Response;
use \Illuminate\Http\Response as Res;
use Log;

class ApiController extends Controller {

    public function __construct() {
        
    }

    /**
     * @var int
     */
    protected $statusCode = Res::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @param $message
     * @return json response
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondCreated($message, $data = null) {

        return $this->respond([
                    'status' => 'success',
                    'status_code' => Res::HTTP_CREATED,
                    'message' => $message,
                    'data' => $data
        ]);
    }

    public function respondNotFound($message = 'Not Found!') {

        return $this->respond([
                    'status' => 'error',
                    'status_code' => Res::HTTP_NOT_FOUND,
                    'message' => $message,
        ]);
    }

    public function respondInternalError() {

        return $this->respond([
                    'status' => 'error',
                    'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => 'Something Went Wrong Please Try Again Later!',
        ]);
    }

    public function respondValidationError($message, $errors) {

        return $this->respond([
                    'status' => 'error',
                    'status_code' => Res::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => $message,
                    'data' => $errors
        ]);
    }

    public function respond($data, $headers = []) {

        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function respondgetall($data, $headers) {

        return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithError($message) {
        return $this->respond([
                    'status' => 'error',
                    'status_code' => Res::HTTP_UNAUTHORIZED,
                    'message' => $message,
        ]);
    }

    public function respondInternalErrors($message = "Something Went Wrong Please Try Again Later !") {

        return $this->respond([
                    'status' => 'error',
                    'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => $message,
        ]);
    }

    public function respondSuccessMessage($message = "Success !") {
        return $this->respond([
                    'status' => 'error',
                    'status_code' => Res::HTTP_OK,
                    'message' => $message,
        ]);
    }

}
