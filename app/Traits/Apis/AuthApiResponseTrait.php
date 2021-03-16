<?php

namespace App\Traits\Apis;


trait AuthApiResponseTrait
{
    public $status_code;
    public $response_data;
    public $route;
    public $api_access_token;

    public function setApiAccessToken(object $user)
    {
        $this->api_access_token = $user->createToken('access-token')->plainTextToken;

        return $this;
    }

    public function credintialsError()
    {
        return response()->json(
        [
            'status' => $this->status_code,
            'response' => $this->response_data
        ],
        $this->status_code);
    }

    public function logedinSuccessfully()
    {
        return response()->json(
        [
            'access_token' => $this->api_access_token,
            'status' => $this->status_code,
            'route' => $this->route
        ],
        $this->status_code);
    }

    /**
     * Set the value of statusCode
     *
     * @return  self
     */
    public function setStatusCode(int $status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }

    /**
     * Set the value of ResponseData
     *
     * @return  self
     */
    public function setResponseData(array $response_data)
    {
        $this->response_data = $response_data;

        return $this;
    }

    /**
     * Set the value of route
     *
     * @return  self
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }
}
