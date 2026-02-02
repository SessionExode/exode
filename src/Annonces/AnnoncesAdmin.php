<?php

namespace Exode\Annonces;

class AnnoncesAdmin {
    public function __construct() {
        add_action("admin_menu", [$this, "create_menu"]);
    }

    public function create_menu(): void {
        add_menu_page(
            "Exode",
            "Exode",
            "manage_options",
            "exode",
            [$this,
"settings_page"],
            plugins_url(
                "assets/icon.svg",
                dirname(__DIR__, 1)
            ),
            0
        );
        add_submenu_page(
            "exode",
            "Annonces",
            "Annonces",
            "manage_options",
            "exode-annonces",
            [$this,
"annonces_settings_page"]
        );
    }

    public function settings_page(): void {
        echo "<h1>Bienvenue sur le plugin de la Session Exode</h1>";
    }

    public function annonces_settings_page(): void {
        if (!current_user_can("manage_options")) {
            return;
        }

        if (wp_verify_nonce($_POST["annonces_nonce"] ?? "", "annonces_update")) {
            if (isset($_POST["annonces"])) {
                update_option("annonces", intval($_POST["annonces"]));
                echo "<div class='updated'><p>Compteur mis à jour !</p></div>";
            }
        }

        $current_val = get_option("annonces", 0);
        require_once dirname(__DIR__) . "/Views/annonces-form.php";
        \Exode\Views\render_annonces_form($current_val);
    }
}
