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

        /** @var Contact[] $contacts */
        $contacts = get_option("contacts_list", []);

        // Deletion
        if ($_GET["action"] ?? "" === "delete" && isset($_GET["id"])) {
            check_admin_referer("delete_contact_" . $_GET["id"]);
            $contacts = array_filter($contacts, fn ($c) => $c->id !== $_GET["id"]);
            update_option("contacts_list", $contacts);
            echo "<div class='updated'><p>Contact supprimé.</p></div>";
        }

        // Creation
        if (wp_verify_nonce($_POST["contact_nonce"] ?? "", "add_contact_action")) {
            $new_contact = new Contact(
                sanitize_text_field($_POST["c_first_name"]),
                sanitize_text_field($_POST["c_name"]),
                sanitize_text_field($_POST["c_tel"]),
                sanitize_text_field($_POST["c_role"])
            );
            $contacts[] = $new_contact; // append $new_contact
            update_option("contacts_list", $contacts);
        }

        require_once __DIR__ . "/contacts-form.php";
        \Exode\Contacts\render_contacts_form($contacts);
    }
}
