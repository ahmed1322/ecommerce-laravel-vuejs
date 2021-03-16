<?php

namespace App\Traits\Apis;
trait ApiResponseGenratorTrait
{

    public $status_code;

    public function createdMsg(string $success_msg)
    {
        return response()->json(
            [
                'msg'=> $success_msg
            ],
            $this->status_code
        );
    }

    public function created(array $data)
    {
        return response()->json(
            [
                'data'=> $data
            ],
            $this->status_code
        );
    }

    public function retrievData($data)
    {
        return response()->json( [ 'status' => $this->status_code, 'data'=> $data], $this->status_code );
    }

    protected function statusCode(int $status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }


}
