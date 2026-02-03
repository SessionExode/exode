<?php

namespace Exode\Buvette;

class BuvetteShortcode {
    public function __construct() {
        add_shortcode("buvette_open", [$this, "render_shortcode"]);
    }

    public function render_shortcode(): string {
        $open = intval(get_option("buvette_open", 0));
        $class = $open ? "buvette-open" : "buvette-closed";
        $text = " Buvette " . ($open ? "ouverte" : "fermée");
        return "<span class='dashicons-before dashicons-beer' data-open='$open'>$text</span>";
    }
}
