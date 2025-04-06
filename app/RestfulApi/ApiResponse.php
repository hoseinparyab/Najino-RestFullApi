<?php

namespace App\RestfullApi;

class ApiResponse
{
    private ?string $message = null;
    private mixed $data = null;
    private int $status = 200;
    private array $appends = [];

    public function setMessage(string $message) : self {
        $this->message = $message;
        return $this;
    }
    public function setData(mixed $data) : self {
        $this->data = $data;
        return $this;
    }

    public function setAppend(array $appends) : void {
        $this->appends = $appends;
    }

        public function response()
    {
        $body = [];
        !is_null($this->message) && $body['message'] = $this->message;
        !is_null($this->data) && $body['data'] = $this->data;
        $body =$body + $this->appends;
        return response()->json($body, $this->status);
    }
}