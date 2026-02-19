<?php

namespace Exode\Events;

class EventsAdmin {
    public function __construct() {
        if (is_admin()) {
            add_action("admin_menu", [$this, "create_menu"]);
        }
    }

    public function create_menu() {
        add_submenu_page(
            "exode",
            "Events",
            "Events",
            "manage_options",
            "exode-events",
            [$this, "settings_page"]
        );
    }
    public function settings_page(): void {
        if (!current_user_can("manage_options")) {
            return;
        }

        // all-deletion
        if (($_POST["action"] ?? "") == "delete_all" && wp_verify_nonce($_POST["delete_all_nonce"] ?? "", "delete_all_events_action")) {
            delete_option("events_list");
            echo "<div class='updated'><p>" . __("All events deleted", "exode") . "</p></div>";
        }

        /** @var Event[] $events */
        $events = get_option("events_list", []);



        // deletion
        if (($_GET["action"] ?? "") == "delete" && isset($_GET["id"])) {
            check_admin_referer("delete_event_" . $_GET["id"]);
            $events = array_filter($events, fn($e) => $e->id !== $_GET["id"]);
            update_option("events_list", $events);
            echo "<div class='updated'><p>" . __("Event deleted", "exode") . "</p></div>";
        }

        // creation
        if (wp_verify_nonce($_POST["events_nonce"] ?? "", "add_event_action")) {
            $new_event = new Event(
                sanitize_text_field($_POST["e_title"]),
                sanitize_text_field($_POST["e_content"]),
                $_POST["e_day"],
                $_POST["e_start_time"],
                $_POST["e_end_time"],
                sanitize_text_field($_POST["e_location"]),

            );
            $events[] = $new_event;

            // sort by increasing order
            usort($events, fn($a, $b) => $a->start->getTimestamp() <=> $b->start->getTimestamp());
            update_option("events_list", $events);
            echo "<div class='updated'><p>" . __("Event added and sorted !", "exode") . "</p></div>";
        }

        require_once __DIR__ . "/events-form.php";
        render_events_form($events);
    }
}
