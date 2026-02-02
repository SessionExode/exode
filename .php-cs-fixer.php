<?php

use PhpCsFixer\Config;

return (new Config())
    ->setRules([
        "@PSR12" => true,
        "braces_position" => [
            "functions_opening_brace" => "same_line",
            "classes_opening_brace" => "same_line",
        ]
    ]);
