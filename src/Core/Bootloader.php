<?php

namespace Exode\Core;

use Exode\Annonces\AnnoncesFeature;

class Bootloader {
    public function __construct() {
        $this->load_features();
    }

    public static function load_features(): void {
        new AnnoncesFeature();
    }
}
