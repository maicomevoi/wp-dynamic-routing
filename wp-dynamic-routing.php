<?php
/**
 * WP Dynamic Routing
 * Plugin Name: WP Dynamic Routing
 * Version: 0.0.1
 * Description: Add support for dynamic routing without creating page
 * Author: Cristiano De Luca
 * Text Domain: wp-dynamic-routing
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 */


if(!defined('ABSPATH'))
    exit;

require_once 'load.php';

wp_dynamic_routing_init();