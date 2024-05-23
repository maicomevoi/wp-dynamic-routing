<?php

if(!defined('ABSPATH'))
    exit;

use WP_Dynamic_Routing\WP_Dynamic_Routing;

function wp_dynamic_routing_init() {
    global $WP_Dynamic_Routing;
    $WP_Dynamic_Routing = WP_Dynamic_Routing::get_instance();
}

function add_route(string $method, string $path, mixed $callback) {
    global $WP_Dynamic_Routing;

    return $WP_Dynamic_Routing->add_route($method, $path, $callback);
}