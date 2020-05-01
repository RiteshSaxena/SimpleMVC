<?php
namespace Core;

class Request {
    public string $route = "/";
    public array $query = [];
    public array $params = [];
    public array $body = [];

    public function header(string $name, string $default = ""): string {
        $header_name = "HTTP_" . strtoupper(str_replace("-", "_", $name));
        return $_SERVER[$header_name] ?? $default;
    }
}
