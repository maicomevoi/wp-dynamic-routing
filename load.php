<?php

if(!defined('ABSPATH'))
    exit;

foreach(glob(__DIR__ . '/classes/*.class.php') as $file) {
    require_once $file;
}

require_once __DIR__ . '/inc/functions.php';


