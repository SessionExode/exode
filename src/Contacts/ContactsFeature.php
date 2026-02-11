<?php

namespace Exode\Contacts;

use Elementor\Widgets_Manager;
use Elementor\Elements_Manager;

class ContactsFeature {
    public function __construct() {
        if (is_admin()) {
            new ContactsAdmin();
        }
        new ContactsShortcode();

        add_action("elementor/elements/categories_registered", fn (Elements_Manager $elements_manager) =>
            $elements_manager->add_category("exode", [
                "title" => esc_html__("Exode"),
                "icon" => "fa fa-plug"
            ]));

        add_action("elementor/widgets/register", function (Widgets_Manager $widgets_manager): void {
            require_once __DIR__ . "/ContactsWidget.php";
            $widgets_manager->register(new ContactsWidget());
        });
    }
}
