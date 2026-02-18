<?php

namespace Exode\Events;

class EventsFeature {
    public function __construct() {
        if (is_admin()) {
            new EventsAdmin();
        }
    }
}
