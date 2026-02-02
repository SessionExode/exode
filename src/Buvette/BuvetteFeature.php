<?php

namespace Exode\Buvette;

class BuvetteFeature {
    public function __construct() {
        if (is_admin()) {
            new BuvetteAdmin();
        }
        new BuvetteShortcode();
    }
}
