<?php

use PhpCsFixer\Config;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        "@PSR12" => true,
        "phpdoc_to_return_type" => true,
        "strict_param" => true,
        "whitespace_after_comma_in_array" => true,
        "braces_position" => [
            "functions_opening_brace" => "same_line",
            "classes_opening_brace" => "same_line",
        ]
    ]);
