<?php

namespace Exode\Buvette;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

class BuvetteWidget extends Widget_Base {
    public function get_name(): string {
        return "exode_buvette";
    }
    public function get_title(): string {
        return __("Buvette Status", "exode");
    }
    public function get_icon(): string {
        return "eicon-info-circle";
    }
    public function get_categories(): array {
        return ["exode"];
    }

    protected function register_controls(): void {

        // --- SECTION: CONTENT ---
        $this->start_controls_section('global_section', [
            'label' => __('Global', 'exode'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control("layout_type", [
            "label" => __("Layout", "exode"),
            "type" => Controls_Manager::CHOOSE,
            'options' => [
                'row' => ['title' => __('Horizontal', 'exode'), 'icon' => 'eicon-arrow-right'],
                'column' => ['title' => __('Vertical', 'exode'), 'icon' => 'eicon-arrow-down',]
            ],
            "default" => "row",
            "selectors" => [
                "{{WRAPPER}} .buvette-status-container" => "display: flex; flex-direction: {{VALUE}}; align-items: center;"
            ]
        ]);
        $this->end_controls_section();

        $this->start_controls_section('text_section', [
            'label' => __('Text', 'exode'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('text_open', [
            'label' => __('Open Text', 'exode'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Buvette open', 'exode'),
        ]);
        $this->add_control('text_closed', [
            'label' => __('Closed Text', 'exode'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Buvette closed', 'exode'),
        ]);
        $this->end_controls_section();

        $this->start_controls_section('icon_section', [
            'label' => __('Icon', 'exode'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('selected_icon', [
            'label' => __('Icon', 'exode'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-beer',
                'library' => 'fa-solid',
            ],
        ]);
        $this->add_control(
            "icon_size",
            [
                'label' => __('Icon Size', 'exode'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => ['px' => ['min' => 6, 'max' => 300]],
                'selectors' => ['{{WRAPPER}} .buvette-status-container svg' => 'height: {{SIZE}}{{UNIT}}; width: auto;'],
            ]
        );

        $this->end_controls_section();

        // --- SECTION: STYLE (Common) ---
        $this->start_controls_section('style_common', [
            'label' => __('Global Style', 'exode'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .buvette-status-container',
        ]);
        $this->add_control('icon_spacing', [
            'label' => __('Icon Spacing', 'exode'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .buvette-status-container i' => 'margin-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .buvette-status-container svg' => 'margin-right: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_section();

        // --- SECTION: STATE STYLES (Open) ---
        $this->start_controls_section('style_open', [
            'label' => __('Open State', 'exode'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('color_open', [
            'label' => __('Color (Text & Icon)', 'exode'),
            'type' => Controls_Manager::COLOR,
            'default' => '#27ae60',
            'selectors' => ['{{WRAPPER}} .status-is-open' => 'color: {{VALUE}}; fill: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'bg_open',
            'selector' => '{{WRAPPER}} .status-is-open',
        ]);
        $this->end_controls_section();

        // --- SECTION: STATE STYLES (Closed) ---
        $this->start_controls_section('style_closed', [
            'label' => __('Closed State', 'exode'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('color_closed', [
            'label' => __('Color (Text & Icon)', 'exode'),
            'type' => Controls_Manager::COLOR,
            'default' => '#c0392b',
            'selectors' => ['{{WRAPPER}} .status-is-closed' => 'color: {{VALUE}}; fill: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'bg_closed',
            'selector' => '{{WRAPPER}} .status-is-closed',
        ]);

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();

        // Fetch status from WP options
        $is_open = intval(get_option("buvette_open", 0)) === 1;

        // Logic handled purely in PHP
        $state_class = $is_open ? 'status-is-open' : 'status-is-closed';
        $display_text = $is_open ? $settings['text_open'] : $settings['text_closed'];

        echo '<div class="buvette-status-container ' . esc_attr($state_class) . '">';

        if (!empty($settings['selected_icon']['value'])) {
            // Icons_Manager automatically handles SVG or Font Icon
            Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
        }

        echo '<span class="status-text">' . esc_html($display_text) . '</span>';
        echo '</div>';
    }
}
