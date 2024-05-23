<?php

namespace WP_Dynamic_Routing;

if(!defined('ABSPATH'))
    exit;

class WP_Dynamic_Route {

    private $method;
    private $path;
    private $callback;

    public function __construct(string $method, string $path, mixed $callback) {

        $this->method = strtoupper($method);
        $this->path = self::normalize_path($path);
        $this->callback = $callback;

        return $this;
    }

    public function getPath() {
        return $this->path;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getCallback() {
        return $this->callback;
    }

    private static function normalize_path(string $path) : string {

        $path = str_replace(' ', '', trim(strtolower($path)));

        if(mb_substr($path, 0, 1) != '/')
            $path = '/' . $path;

        return $path;
    }

}

