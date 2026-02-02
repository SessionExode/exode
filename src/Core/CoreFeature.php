<?php

namespace Exode\Core;

class CoreFeature {
    public function __construct() {
        if (is_admin()) {
            new CoreAdmin();
        }
    }
}
