<?php

namespace Exode\Contacts;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class ContactsWidget extends Widget_Base {
    public function get_name(): string {
        return "exode_contacts_list";
    }
    public function get_title(): string {
        return "Liste des Contacts";
    }
    public function get_icon(): string {
        return "eicon-person";
    }
    public function get_categories(): array {
        return [ "exode" ];
    }

    protected function register_controls(): void {

        // --- SECTION: CONTENT ---
        $this->start_controls_section('content_section', [
            'label' => 'Contenu',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE CONTAINER (Bounding Box) ---
        $this->start_controls_section('style_container', [
            'label' => 'Conteneur',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('container_padding', [
            'label' => 'Padding',
            'type' => Controls_Manager::DIMENSIONS,
            "size_units" => ["px", "em", "%"],
            'selectors' => [ '{{WRAPPER}} .exode-contacts-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'container_background',
            'selector' => '{{WRAPPER}} .exode-contacts-container',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
                    'name' => 'container_border',
                    'selector' => '{{WRAPPER}} .exode-contacts-container',
                ]);

        $this->add_control('container_border_radius', [
            'label' => 'Arrondi des angles',
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [ '{{WRAPPER}} .exode-contacts-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE INIDIVDUAL ITEMS ---
        $this->start_controls_section('style_items', [
            'label' => 'Contacts Individuels',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        // Box Model for Items
        $this->add_responsive_control('item_margin', [
            'label' => 'Marge (Espacement)',
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [ '{{WRAPPER}} .exode-contact-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control('item_padding', [
            'label' => 'Padding Interne',
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [ '{{WRAPPER}} .exode-contact-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'item_background',
            'selector' => '{{WRAPPER}} .exode-contact-item',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'item_border',
            'selector' => '{{WRAPPER}} .exode-contact-item',
        ]);

        $this->add_control('item_border_radius', [
            'label' => 'Arrondi des angles',
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [ '{{WRAPPER}} .exode-contact-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        // Typography & Colors
        $this->add_control('item_color', [
            'label' => 'Couleur du Nom',
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .exode-contact-item' => 'color: {{VALUE}};' ],
            "separator" => "before",
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'item_typography',
            "label" => "Typographie du Nom",
            'selector' => '{{WRAPPER}} .exode-contact-item strong',
        ]);

        $this->add_control('role_color', [
            'label' => 'Couleur du Rôle',
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .contact-role' => 'color: {{VALUE}};' ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'role_typography',
            'label' => 'Typographie du Rôle',
            'selector' => '{{WRAPPER}} .contact-role',
        ]);

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        /** @var Contact[] $contacts */
        $contacts = get_option("contacts_list", []);

        if (empty($contacts)) {
            echo "Aucun contact trouvé.";
            return;
        }

        echo '<div class="exode-contacts-container">';
        foreach ($contacts as $c) {
            echo '<div class="exode-contact-item">';
            echo '<strong>' . esc_html($c->first_name) . ' ' . esc_html($c->name) . '</strong>';
            echo ' <span class="contact-role">- ' . esc_html($c->role) . '</span>';
            echo ' <a href="tel:' . esc_attr($c->tel) . '" class="contact-tel">- ' . esc_html($c->tel) . '</a>';
            echo '</div>';
        }
        echo '</div>';
    }
}
