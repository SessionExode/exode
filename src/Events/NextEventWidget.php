<?php

namespace Exode\Events;

use Elementor\Widget_Base;

/**
 * Shows the next event happening after the current time
 */
class NextEventWidget extends Widget_Base {
    public function get_name() {
        return "exode_next_event";
    }
    public function get_title() {
        return __("Next Event", "exode");
    }
    public function get_icon(): string {
        return "eicon-calendar";
    }
    public function get_categories(): array {
        return ["exode"];
    }

    protected function render() {
        $events = get_option("events_list", []);
        $now = time();
    }
}
