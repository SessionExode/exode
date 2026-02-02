<?php

namespace Exode\Core;

use Exode\Annonces\AnnoncesFeature;
use Exode\Buvette\BuvetteFeature;

class Bootloader {
    public function __construct() {
        $this->load_features();
    }

    public static function load_features(): void {
        new CoreFeature();
        new AnnoncesFeature();
        new BuvetteFeature();
    }
}
