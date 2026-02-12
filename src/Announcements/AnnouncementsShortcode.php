<?php

namespace Exode\Announcements;

class AnnouncementsShortcode {
    public function __construct() {
        add_shortcode("announcements", [$this, "render_shortcode"]);
    }

    public function render_shortcode(): string {
        /** @var Announcement[] $announcements */
        $announcements = get_option("announcements", []);

        if (empty($announcements)) {
            return "";
        }

        return '<span id="announcements">' . esc_html($announcements) . "</span>";
    }
}
