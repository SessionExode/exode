<?php

namespace Exode\Contacts;

class ContactsWidget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'exode_contacts_list';
    }
    public function get_title() {
        return 'Liste des Contacts Exode';
    }
    public function get_icon() {
        return 'eicon-person';
    }
    public function get_categories() {
        return [ 'general' ];
    }

    protected function render() {
        $contacts = get_option("contacts_list", []);
        if (empty($contacts)) {
            echo "Aucun contact trouvé.";
        }

        echo "<ul class=exode-contacts-widget>";
        foreach ($contacts as $c) {
            echo "<li><strong>" . esc_html($c->first_name) . " ". esc_html($c->name) . "</strong> - " . esc_html($c->role) . "</li>";
        }
        echo "</ul>";
    }
}
