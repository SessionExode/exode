<?php

namespace Exode\Events;

use Elementor\Widgets_Manager;

class EventsFeature {
    public function __construct() {
        if (is_admin()) {
            new EventsAdmin();
        }
        add_action(
            "elementor/widgets/register",
            fn(Widgets_Manager $widgets_manager) =>
            $widgets_manager->register(new NextEventWidget())
        );
    }
}
