<?php

namespace Exode\Announcements;

class AnnouncementsShortcode {
    public function __construct() {
        add_shortcode("announcements", [$this, "render_shortcode"]);
    }

    public function render_shortcode(): string {
        $val = get_option("announcements", 0);
        return "<span id=\"announcements\">" . esc_html($val) . "</span>";
    }
}
