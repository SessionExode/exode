<?php

namespace Exode\Buvette;

class BuvetteShortcode {
    public function __construct() {
        add_shortcode("buvette_opened", [$this, "render_shortcode"]);
    }

    public function render_shortcode(): string {
        $val = get_option("buvette_opened", 0);
        return "<span id=\"buvette-opened\">" . esc_html($val) . "</span>";
    }
}
