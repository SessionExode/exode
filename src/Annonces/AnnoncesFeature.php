<?php

namespace Exode\Annonces;

class AnnoncesFeature {
    public function __construct() {
        if (is_admin()) {
            new AnnoncesAdmin();
        }
        new AnnoncesShortcode();
    }
}
