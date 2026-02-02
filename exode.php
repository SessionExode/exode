<?php

/*
 * Plugin Name: Exode
 * Plugin URI: https://github.com/SessionExode/exode
 * Description: Main Plugin of the Session Exode App
 * Author: Thibault Chourré & Vianney Hervy
 */

if (!defined("ABSPATH")) {
    exit;
}

// Custom autoloader
spl_autoload_register(function ($class) {
    $prefix = "Exode\\";
    $base_dir = __DIR__ . "/src/";

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) { // check if class uses prefix
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace("\\", "/", $relative_class) . ".php";

    if (file_exists($file)) {
        require_once $file;
    }
});

use Exode\Core\Bootloader;

$plugin = new Bootloader();
