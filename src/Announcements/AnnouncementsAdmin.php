<?php

namespace Exode\Announcements;

class AnnouncementsAdmin {
    public function __construct() {
        add_action("admin_menu", [$this, "create_menu"]);
    }

    public function create_menu(): void {
        add_submenu_page(
            "exode",
            "Announcements",
            "Announcements",
            "manage_options",
            "exode-announcements",
            [$this,
"settings_page"]
        );
    }

    public function settings_page(): void {
        if (!current_user_can("manage_options")) {
            return;
        }

        if (wp_verify_nonce($_POST["announcements_nonce"] ?? "", "announcements_update")) {
            if (isset($_POST["announcements"])) {
                update_option("announcements", intval($_POST["announcements"]));
                echo "<div class=\"updated\"><p>Compteur mis à jour !</p></div>";
            }
        }

        $current_val = get_option("announcements", 0);
        require_once __DIR__ . "/announcements-form.php";
        \Exode\Announcements\render_announcements_form($current_val);
    }
}
