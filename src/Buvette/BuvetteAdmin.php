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

        if (wp_verify_nonce($_POST["buvette_open_nonce"] ?? "", "buvette_open_update")) {
            if (isset($_POST["buvette_open"])) {
                update_option("buvette_open", intval($_POST["buvette_open"]));
                echo "<div class=\"updated\"><p>Compteur mis à jour !</p></div>";
            }
        }

        $open = intval(get_option("buvette_open", 0));
        require_once __DIR__ . "/buvette-form.php";
        \Exode\Buvette\render_buvette_form($open);
    }
}
