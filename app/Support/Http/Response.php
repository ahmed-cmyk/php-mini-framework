<?php

namespace App\Support\Http;

class Response
{
    protected string $content;
    protected int $status;
    protected array $headers = [];

    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }
        echo $this->content;
    }
}