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
            0
        );
    }

    public function settings_page(): void {
        /** @var string $google_maps_api_key */
        $google_maps_api_key = get_option("google_maps_api_key");

        // Update Google Maps API key
        if (isset($_POST["google_maps_api_key"])) {
            $google_maps_api_key = $_POST["google_maps_api_key"];
            update_option("google_maps_api_key", $google_maps_api_key);
            echo '<div class="updated"><p>' . __("New API key: $google_maps_api_key") . '</p></div>';
        }

        require_once __DIR__ . "/core-form.php";
        render_core_form($google_maps_api_key);
    }
}
