<?php

namespace Exode\Core;

use Exode\Annonces\AnnoncesFeature;
use Exode\Buvette\BuvetteFeature;

class Bootloader {
    public function __construct() {
        $this->load_scripts();
        $this->load_features();
    }

    private function load_scripts(): void {
        add_action("wp_enqueue_scripts", function () {
            wp_enqueue_style("dashicons");
        });
    }

    private function load_features(): void {
        new CoreFeature();
        new AnnoncesFeature();
        new BuvetteFeature();
    }
}
