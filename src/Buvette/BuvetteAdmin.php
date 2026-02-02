<?php

namespace Exode\Buvette;

class BuvetteAdmin {
    public function __construct() {
        add_action("admin_menu", [$this, "create_menu"]);
    }

    public function create_menu(): void {
        add_submenu_page(
            "exode",
            "Buvette",
            "Buvette",
            "manage_options",
            "exode-buvette",
            [$this,
"settings_page"]
        );
    }

    public function settings_page(): void {
        if (!current_user_can("manage_options")) {
            return;
        }

        if (wp_verify_nonce($_POST["buvette_opened_nonce"] ?? "", "buvette_opened_update")) {
            if (isset($_POST["buvette_opened"])) {
                update_option("buvette_opened", boolval($_POST["buvette_opened"]));
                echo "<div class=\"updated\"><p>Compteur mis à jour !</p></div>";
            }
        }

        $current_val = get_option("buvette_opened", 0);
        require_once dirname(__DIR__) . "/Views/buvette-form.php";
        \Exode\Views\render_buvette_form($current_val);
    }
}
