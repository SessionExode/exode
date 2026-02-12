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
            [$this, "settings_page"]
        );
    }

    public function settings_page(): void {
        if (!current_user_can("manage_options")) {
            return;
        }

        /** @var Announcement[] $announcements */
        $announcements = get_option("announcements_list", []);

        // Deletion
        if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
            check_admin_referer("delete_announcement_" . $_GET["id"]);
            $announcements = array_filter($announcements, fn($a) => $a->id !== $_GET["id"]);
            update_option("announcements_list", $announcements);
            echo ("<div class='updated'><p>" . __("Announcement deleted", "exode") . "</p></div>");
        }

        // Creation
        if (wp_verify_nonce($_POST["announcements_nonce"] ?? "", "add_announcement_action")) {
            $raw_date = $_POST["a_date"] ?? "";
            $unix_date = $raw_date ? strtotime($raw_date) : time();

            $new_announcement = new Announcement(
                sanitize_text_field($_POST["a_title"]),
                sanitize_textarea_field($_POST["a_content"]),
                $unix_date
            );

            $announcements[] = $new_announcement;

            // sort by decreasing date (newest first)
            usort($announcements, fn($a, $b) => $b->date <=> $a->date);
            update_option("announcements_list", $announcements);
            echo "<div class='updated'><p>" . __("Announcement added and sorted !", "exode") . "</p></div>";
        }

        require_once __DIR__ . "/announcements-form.php";
        render_announcements_form($announcements);
    }
}
