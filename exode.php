<?php

/*
 * Plugin Name: Exode
 * Description: Main PLugin of the Session Exode App
 * Author: Vianney Hervy
 */

if (!defined("ABSPATH")) {
    exit;
}

class Exode {
    public function __construct() {
        add_action("admin_menu", [$this, "create_menu"]);
        add_shortcode("annonces", [$this, "render_shortcode"]);
    }

    public static function activate(): void {
        if (get_option("annonces") === false) {
            update_option("annonces", 0) ;
        }
    }

    public function create_menu(): void {
        add_menu_page(
            "Exode", // page_title
            "Exode", // menu_title (visible in sidebar)
            "manage_options", // capability
            "exode", // menu_slug
            [$this, "settings_page"], // callback
            plugins_url("assets/icon.svg", __FILE__)
        );

        add_submenu_page(
            "exode", // parent_slug // match above
            "Annonces", // page_title
            "Annonces", // menu_title
            "manage_options", // capability
            "exode-annonces", // menu_slug
            [$this, "annonces_settings_page"] // calback
        );
    }

    public function settings_page(): void {
        ?><h1>Bienvenue sur le plugin de la Session Exode</h1><?php
    }

    public function annonces_settings_page(): void {
        if (!current_user_can("manage_options")) {
            return;
        }

        if (wp_verify_nonce($_POST["annonces_nonce"] ?? "", "annonces_update")) {
            if (isset($_POST["annonces"])) {
                $val = intval($_POST["annonces"]);
                update_option("annonces", $val);
                echo "<div>Compteur mis à jour !</div>";
            }
        }

        $current_val = get_option("annonces", 0);
        ?>
    <div class="wrap">
        <h1>Annonces</h1>
        <form method="post">
            <?php wp_nonce_field("annonces_update", "annonces_nonce"); ?>
            <input type="number" name="annonces" id="annonces" value="<?php echo esc_attr($current_val); ?>">
            <?php submit_button("Enregistrer la valeur"); ?>
        </form>
    </div>
    <?php
    }

    public function render_shortcode(): string {
        $val = get_option("annonces", 0);
        return "<span id=\"annonces\">" . esc_html($val) . "</span>";
    }
}
/* Execution */
register_activation_hook(__FILE__, ['Exode', 'activate']);
new Exode();
