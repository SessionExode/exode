<?php

namespace Exode\Core;

class CoreAdmin {
    public function __construct() {
        add_action("admin_menu", [$this, "create_menu"]);
    }

    public function create_menu(): void {
        add_menu_page(
            "Exode",
            "Exode",
            "manage_options",
            "exode",
            [$this, "settings_page"],
            plugins_url(
                "assets/icon.svg",
                dirname(__DIR__, 1)
            ),
            67
        );
    }

    public function settings_page(): void {
        require_once __DIR__ . "/core-form.php";
        render_core_form();
    }
}
