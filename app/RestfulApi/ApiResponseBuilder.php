<?php

namespace App\RestfulApi;

class ApiResponseBuilder
{
    private ApiResponse $response;

    public function __construct()
    {
        $this->response = new ApiResponse;
    }

    public function withMessage(string $message): self
    {
        $this->response->setMessage($message);

        return $this;
    }

    public function withData(mixed $data): self
    {
        $this->response->setData($data);

        return $this;
    }

    public function withStatus(int $status): self
    {
        $this->response->setStatus($status);

        return $this;
    }

    public function withAppend(array $appends): self
    {
        $this->response->setAppend($appends);

        return $this;
    }

    public function build(): ApiResponse
    {
        return $this->response;
    }
}
