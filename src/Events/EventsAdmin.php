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

        /** @var Event[] $events */
        $events = get_option("events_list", []);
        $success_msg = "";


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
                $_POST["e_page_id"] ?: null,
                $is_update ? $_POST["e_id"] : ""
            );
            if ($is_update) {
                $success_msg = __("Event updated and sorted !", "exode");
                foreach ($events as &$e) {
                    if ($e->getId() === $new_event->getId()) {
                        $e = $new_event;
                        break;
                    }
                }
            } else {
                $success_msg = __("Event added and sorted !", "exode");
                $events[] = $new_event;
            }

            // sort by increasing order
            usort($events, fn($a, $b) => $a->getStart()->getTimestamp() <=> $b->getStart()->getTimestamp());
            update_option("events_list", $events);

            // clear url variables to avoid $edit_event setting $edit_event after
            $_GET["action"] = "";
            $_GET["id"] = "";
        }

        // deletion
        if (($_GET["action"] ?? "") == "delete" && isset($_GET["id"])) {
            check_admin_referer("delete_event_" . $_GET["id"]);
            $events = array_filter($events, fn($e) => $e->getId() !== $_GET["id"]);
            update_option("events_list", $events);
            $success_msg = __("Event deleted", "exode");
            $events = get_option("events_list");
        }

        // all-deletion
        if (($_POST["action"] ?? "") == "delete_all" && wp_verify_nonce($_POST["delete_all_nonce"] ?? "", "delete_all_events_action")) {
            delete_option("events_list");
            $success_msg = __("All events deleted", "exode");
            $events = get_option("events_list");
        }

        if ($success_msg) {
            echo "<div class='updated'><p>$success_msg</p></div>";
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
