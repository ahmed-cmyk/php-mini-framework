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

    public function header(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function json($data, int $status = 200): self
    {
        $this->content = json_encode($data);
        $this->status = $status;
        $this->header('Content-Type', 'application/json');

        return $this;
    }

    public function send(): void
    {
        http_response_code($this->status);

        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }

        echo $this->content;
    }

    public function view(string $file, mixed $data, int $status): self
    {
    $path = base_path('views/' . $file . '.view.php');

        if (!file_exists($path)) {
            throw new \Exception("View not found: {$path}");
        }

        extract($data);

    ob_start();
    require $path;
    $this->content = ob_get_clean();

        $this->status = $status;

        return $this;
    }
}