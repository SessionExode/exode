<?php

namespace Exode\Buvette;

use Elementor\Widgets_Manager;

class BuvetteFeature {
    public function __construct() {
        if (is_admin()) {
            new BuvetteAdmin();
        }
        new BuvetteShortcode();

        add_action(
            "elementor/widgets/register",
            fn (Widgets_Manager $widgets_manager) =>
            $widgets_manager->register(new BuvetteWidget())
        );
    }
}
