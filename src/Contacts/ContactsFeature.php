<?php

namespace Exode\Contacts;

use Elementor\Widgets_Manager;

class ContactsFeature {
    public function __construct() {
        if (is_admin()) {
            new ContactsAdmin();
        }
        new ContactsShortcode();

        add_action("elementor/widgets/register", function (Widgets_Manager $widgets_manager): void {
            require_once __DIR__ . "/ContactsWidget.php";
            $widgets_manager->register(new ContactsWidget());
        });
    }
}
