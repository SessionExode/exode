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

// Load COmposer Autoloader
if (file_exists(__DIR__ . "/vendor/autoload.php")) {
    require_once __DIR__ . "/vendor/autoload.php";
}

use Exode\Core\Bootloader;

$plugin = new Bootloader();
