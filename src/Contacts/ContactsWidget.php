<?php

namespace Exode\Contacts;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class ContactsWidget extends Widget_Base {
    public function get_name(): string {
        return "exode_contacts_list";
    }
    public function get_title(): string {
        return "Liste des Contacts Exode";
    }
    public function get_icon(): string {
        return "eicon-person";
    }
    public function get_categories(): array {
        return [ "general" ];
    }

    protected function register_controls(): void {

        // --- CONTENT SECTION ---
        $this->start_controls_section('content_section', [
            'label' => 'Contenu',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('show_role', [
            'label' => 'Afficher le rôle',
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);
        $this->end_controls_section();

        // --- CONTAINER STYLE ---
        $this->start_controls_section('style_container', [
            'label' => 'Conteneur (Liste)',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_responsive_control('container_padding', [
            'label' => 'Padding',
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [ '{{WRAPPER}} .exode-contacts-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'container_background',
            'selector' => '{{WRAPPER}} .exode-contacts-container',
        ]);
        $this->end_controls_section();

        // --- ITEMS STYLE ---
        $this->start_controls_section('style_items', [
            'label' => 'Contacts Individuels',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('item_color', [
            'label' => 'Couleur du texte',
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .exode-contact-item' => 'color: {{VALUE}};' ],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'item_typography',
            'selector' => '{{WRAPPER}} .exode-contact-item',
        ]);
        $this->add_responsive_control('item_margin', [
            'label' => 'Espacement entre contacts',
            'type' => Controls_Manager::SLIDER,
            'selectors' => [ '{{WRAPPER}} .exode-contact-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
        ]);
        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $contacts = get_option("contacts_list", []);

        if (empty($contacts)) {
            echo "Aucun contact trouvé.";
            return;
        }

        echo '<div class="exode-contacts-container">';
        foreach ($contacts as $c) {
            echo '<div class="exode-contact-item">';
            echo '<strong>' . esc_html($c->first_name) . ' ' . esc_html($c->name) . '</strong>';
            if ($settings['show_role'] === 'yes') {
                echo ' <span class="contact-role">- ' . esc_html($c->role) . '</span>';
            }
            echo '</div>';
        }
        echo '</div>';
    }
}
