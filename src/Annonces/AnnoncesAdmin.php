<?php

namespace Exode\Annonces;

class AnnoncesAdmin {
    public function __construct() {
        add_action("admin_menu", [$this, "create_menu"]);
    }

    public function create_menu(): void {
        add_submenu_page(
            "exode",
            "Annonces",
            "Annonces",
            "manage_options",
            "exode-annonces",
            [$this,
"settings_page"]
        );
    }

    public function settings_page(): void {
        if (!current_user_can("manage_options")) {
            return;
        }

        if (wp_verify_nonce($_POST["annonces_nonce"] ?? "", "annonces_update")) {
            if (isset($_POST["annonces"])) {
                update_option("annonces", intval($_POST["annonces"]));
                echo "<div class=\"updated\"><p>Compteur mis à jour !</p></div>";
            }
        }

        $current_val = get_option("annonces", 0);
        require_once __DIR__ . "/annonces-form.php";
        \Exode\Annonces\render_annonces_form($current_val);
    }
}
