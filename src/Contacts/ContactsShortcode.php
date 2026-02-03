<?php

namespace Exode\Contacts;

class ContactsShortcode {
    public function __construct() {
        add_shortcode("contacts", [$this, "render_shortcode"]);
    }

    public function render_shortcode(): string {
        $contacts = get_option("contacts_list", []);
        $count = is_array($count) ? ($contacts) : 0;
        return "<span id=\"contacts\">$count</span>";
    }
}
