<?php

namespace Exode\Contacts;

class ContactsWidget extends \Elementor\Widget_Base {
    public function get_name(): string {
        return 'exode_contacts_list';
    }
    public function get_title(): string {
        return 'Liste des Contacts Exode';
    }
    public function get_icon(): string {
        return 'eicon-person';
    }
    public function get_categories(): array {
        return [ 'general' ];
    }

    protected function render(): void {
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
