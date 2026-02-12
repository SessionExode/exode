<?php

/*
 * Plugin Name: Exode
 * Plugin URI: https://github.com/SessionExode/exode
 * Text DOmain: exode
 * Domain Path: /lang
 *
 * Description: Main plugin of the Session Exode App
 * Author: Thibault Chourré & Vianney Hervy
 */

if (!defined("ABSPATH")) {
    exit;
}

add_action("init", fn() => load_plugin_textdomain("exode", false, dirname(plugin_basename(__FILE__)) . "/lang"));

// Load Composer Autoloader
if (file_exists(__DIR__ . "/vendor/autoload.php")) {
    require_once __DIR__ . "/vendor/autoload.php";
}

use Exode\Core\Bootloader;

$plugin = new Bootloader();
