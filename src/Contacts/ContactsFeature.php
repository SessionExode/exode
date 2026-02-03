<?php

namespace Exode\Contacts;

class ContactsFeature {
    public function __construct() {
        if (is_admin()) {
            new ContactsAdmin();
        }
        new ContactsShortcode();
    }
}
