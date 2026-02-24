<?php

namespace Exode\VerseOfTheDay;

use Elementor\Widgets_Manager;

class VerseOfTheDayFeature {
    public function __construct() {
        if (is_admin()) {
            new VerseOfTheDayAdmin();
        }
        add_action(
            "elementor/widgets/register",
            fn(Widgets_Manager $widgets_manager) =>
            $widgets_manager->register(new VerseOfTheDayWidget())
        );
    }
}
