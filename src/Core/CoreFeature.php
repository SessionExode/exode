<?php

namespace Exode\Core;

use Elementor\Elements_Manager;

class CoreFeature {
    public function __construct() {
        if (is_admin()) {
            new CoreAdmin();
        }

        add_action(
            "elementor/elements/categories_registered",
            fn (Elements_Manager $elements_manager) =>
                $elements_manager->add_category("exode", [
                    "title" => esc_html__("Exode"),
                    "icon" => "fa fa-plug"
                ])
        );
    }
}
