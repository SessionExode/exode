<?php

namespace Exode\Contacts;

use Elementor\Widgets_Manager;

class ContactsFeature {
    public function __construct() {
        if (is_admin()) {
            new ContactsAdmin();
        }
        new ContactsShortcode();

        add_action(
            "elementor/widgets/register",
            fn (Widgets_Manager $widgets_manager) =>
                $widgets_manager->register(new ContactsWidget())
        );
    }
}
