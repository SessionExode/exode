<?php

namespace Exode\Contacts;

class ContactsAdmin {
    public function __construct() {
        add_action("admin_menu", [$this, "create_menu"]);
    }

    public function create_menu(): void {
        add_submenu_page(
            "exode",
            "Contacts",
            "Contacts",
            "manage_options",
            "exode-contacts",
            [$this, "settings_page"]
        );
    }

    public function settings_page(): void {
        if (!current_user_can("manage_options")) {
            return;
        }

        if (wp_verify_nonce($_POST["contact_nonce"] ?? "", "add_contact_action")) {
            $contacts = get_option("contacts_list", []);

            $new_contact = [
                "first_name" => sanitize_text_field($_POST["c_first_name"]),
                "name" => sanitize_text_field($_POST["c_name"]),
                "tel" => sanitize_text_field($_POST["c_tel"]),
                "role" => sanitize_text_field($_POST["c_role"]),
            ];

            if (!empty($new_contact["name"])) {
                $contacts[] = $new_contact;
                update_option("contacts_list", $contacts);
                echo "<div class='updated'<p>Contact added successfully!</p></div>";
            } else {
                echo "hmmm";
            }
        } else {
            echo "ayyy";
        }

        $contacts = get_option("contacts_list", []);
        require_once dirname(__DIR__) . "/Views/contacts-form.php";
        \Exode\Views\render_contacts_form($contacts);
    }
}
