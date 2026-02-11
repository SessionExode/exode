<?php

namespace Exode\Announcements;

class AnnouncementsFeature {
    public function __construct() {
        if (is_admin()) {
            new AnnouncementsAdmin();
        }
        new AnnouncementsShortcode();
    }
}
