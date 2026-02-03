<?php

namespace Exode\Contacts;

class ContactsFeature {
    public function __construct() {
        if (is_admin()) {
            new ContactsAdmin();
        }
        new ContactsShortcode();

        add_action("elementor/widgets/register", function ($widgets_manager) {
            require_once __DIR__ . "/ContactsWidget.php";
            $widgets_manager->regsiter(new ContactsWidget());
        });
    }
}
