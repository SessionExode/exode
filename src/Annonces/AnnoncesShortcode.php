<?php

namespace Exode\Annonces;

class AnnoncesShortcode {
    public function __construct() {
        add_shortcode("annonces", [$this, "render_shortcode"]);
    }

    public function render_shortcode(): string {
        $val = get_option("annonces", 0);
        return "<span id=\"annonces\">" . esc_html($val) . "</span>";
    }
}
