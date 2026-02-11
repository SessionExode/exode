<?php

namespace Exode\Contacts;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class ContactsWidget extends Widget_Base {
    public function get_name(): string {
        return "exode_contacts_list";
    }
    public function get_title(): string {
        return __("Contact List", "exode");
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
            'label' => __('Content', "exode"),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control("separator_char", [
            "label" => __("Separator Character", "exode"),
            "type" => Controls_Manager::TEXT,
            "default" => "-",
            "placeholder" => __("ex: - or |", "exode"),
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE CONTAINER (Bounding Box) ---
        $this->start_controls_section('style_container', [
            'label' => __('Container', "exode"),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_responsive_control('container_margin', [
            'label' => __('Margin', "exode"),
            'type' => Controls_Manager::DIMENSIONS,
            "size_units" => ["px", "em", "%"],
            'selectors' => [ '{{WRAPPER}} .exode-contacts-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);
        $this->add_responsive_control('container_padding', [
            'label' => __('Padding', "exode"),
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
            'label' => __('Border Radius', "exode"),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [ '{{WRAPPER}} .exode-contacts-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE INIDIVDUAL ITEMS ---
        $this->start_controls_section('style_items', [
            'label' => __('Individual Contacts', "exode"),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        // Box Model for Items
        $this->add_responsive_control('item_margin', [
            'label' => __('Margin', "exode"),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [ '{{WRAPPER}} .exode-contact-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control('item_padding', [
            'label' => __('Padding', "exode"),
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
            'label' => __('Border Radius', "exode"),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [ '{{WRAPPER}} .exode-contact-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        // Typography & Colors
        $this->add_control('name_style_heading', [
            'label' => __('Names', "exode"),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control('item_color', [
            'label' => __('Color', "exode"),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .contact-name' => 'color: {{VALUE}};' ],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'item_typography',
            "label" => __("Typography", "exode"),
            'selector' => '{{WRAPPER}} .contact-name',
        ]);

        $this->add_control('role_style_heading', [
            'label' => __('Roles', "exode"),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control('role_color', [
            'label' => __('Color', "exode"),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .contact-role' => 'color: {{VALUE}};' ],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'role_typography',
            'label' => __('Typography', "exode"),
            'selector' => '{{WRAPPER}} .contact-role',
        ]);

        $this->add_control('tel_style_heading', [
            'label' => __('Phones', "exode"),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control('tel_color', [
            'label' => __('Color', "exode"),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .contact-tel' => 'color: {{VALUE}};' ],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'tel_typography',
            'label' => __('Typography', "exode"),
            'selector' => '{{WRAPPER}} .contact-tel',
        ]);

        $this->add_control('separator_style_heading', [
            'label' => __('Separators', "exode"),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control('separator_color', [
            'label' => __('Color', "exode"),
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .contact-sep' => 'color: {{VALUE}};' ],
        ]);
        $this->add_responsive_control('separator_spacing', [
            'label' => __('Spacing (Left/right)', "exode"),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'selectors' => [
                '{{WRAPPER}} .contact-sep' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};'
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        /** @var Contact[] $contacts */
        $contacts = get_option("contacts_list", []);

        if (empty($contacts)) {
            echo esc_html__("No contacts found", "exode");
            return;
        }

        $sep_char = esc_html($settings["separator_char"]);
        $sep_html = empty($sep_char) ? "" : '<span class="contact-sep">' . $sep_char . '</span>';

        echo '<div class="exode-contacts-container">';
        foreach ($contacts as $c) {
            echo '<div class="exode-contact-item">';
            echo '<span class="contact-name">' . esc_html($c->first_name) . ' ' . esc_html($c->name) . '</span>';
            echo $sep_html;
            echo ' <span class="contact-role">' . esc_html($c->role) . '</span>';
            echo $sep_html;
            echo ' <a href="tel:' . esc_attr($c->tel) . '" class="contact-tel">' . esc_html($c->tel) . '</a>';
            echo '</div>';
        }
        echo '</div>';
    }
}
