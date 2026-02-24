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

        if (isset($_GET["msg"])) {
            $msg = $_GET["msg"] === "updated"
                ? __("Event updated and sorted !", "exode")
                : __("Event added and sorted !", "exode");
            echo "<div class='updated'><p>$msg</p></div>";
        }

        /** @var Event[] $events */
        $events = get_option("events_list", []);

        // deletion
        if (($_GET["action"] ?? "") == "delete" && isset($_GET["id"])) {
            check_admin_referer("delete_event_" . $_GET["id"]);
            $events = array_filter($events, fn($e) => $e->getId() !== $_GET["id"]);
            update_option("events_list", $events);
            echo "<div class='updated'><p>" . __("Event deleted", "exode") . "</p></div>";
        }

        // creation / edition
        if (wp_verify_nonce($_POST["events_nonce"] ?? "", "add_event_action")) {
            $is_update = !empty($_POST["e_id"]);

            $new_event = new Event(
                sanitize_text_field($_POST["e_title"]),
                sanitize_text_field($_POST["e_content"]),
                sanitize_text_field($_POST["e_location"]),
                $_POST["e_day"],
                $_POST["e_start_time"],
                $_POST["e_end_time"] ?: null,
                $is_update ? $_POST["e_id"] : ""
            );
            if ($is_update) {
                foreach ($events as &$e) {
                    if ($e->getId() === $new_event->getId()) {
                        $e = $new_event;
                        break;
                    }
                }
            } else {
                $events[] = $new_event;
            }

            // sort by increasing order
            usort($events, fn($a, $b) => $a->getStart()->getTimestamp() <=> $b->getStart()->getTimestamp());
            update_option("events_list", $events);

            $redirect_url = admin_url("admin.php?page=exode-events&msg=" . ($is_update ? "updated" : "created"));
            wp_safe_redirect($redirect_url);
            exit;
        }

        // all-deletion
        if (($_POST["action"] ?? "") == "delete_all" && wp_verify_nonce($_POST["delete_all_nonce"] ?? "", "delete_all_events_action")) {
            delete_option("events_list");
            echo "<div class='updated'><p>" . __("All events deleted", "exode") . "</p></div>";
            $events = get_option("events_list");
        }

        /** @var Event $edit_event */
        $edit_event = null;
        if (($_GET["action"] ?? "") == "edit" && isset($_GET["id"])) {
            foreach ($events as $e) {
                if ($e->getId() === $_GET["id"]) {
                    $edit_event = $e;
                    break;
                }
            }
        }

        require_once __DIR__ . "/events-form.php";
        render_events_form($events, $edit_event);
    }
}
