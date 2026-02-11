<?php

namespace Exode\Core;

use Exode\Announcements\AnnouncementsFeature;
use Exode\Buvette\BuvetteFeature;
use Exode\Contacts\ContactsFeature;

class Bootloader {
    public function __construct() {
        $this->load_scripts();
        $this->load_features();
    }

    private function load_scripts(): void {
        add_action("wp_enqueue_scripts", fn () => wp_enqueue_style("dashicons"));
    }

    private function load_features(): void {
        new CoreFeature();
        new AnnouncementsFeature();
        new BuvetteFeature();
        new ContactsFeature();
    }
}
