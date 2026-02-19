<?php

namespace Exode\Events;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Shows the next event happening after the current time
 */
class NextEventWidget extends Widget_Base {
    public function get_name() {
        return "exode_next_event";
    }
    public function get_title() {
        return __("Next Event", "exode");
    }
    public function get_icon(): string {
        return "eicon-calendar";
    }
    public function get_categories(): array {
        return ["exode"];
    }

    protected function register_controls(): void {

        // --- SECTION: CONTENT ---
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'exode'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('show_title', [
            'label'        => __('Show Title', 'exode'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'exode'),
            'label_off'    => __('No', 'exode'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('show_content', [
            'label'        => __('Show Description', 'exode'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'exode'),
            'label_off'    => __('No', 'exode'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('show_date', [
            'label'        => __('Show Date', 'exode'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'exode'),
            'label_off'    => __('No', 'exode'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('show_location', [
            'label'        => __('Show Location', 'exode'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'exode'),
            'label_off'    => __('No', 'exode'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        $this->add_control('date_format', [
            'label'       => __('Date Format', 'exode'),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'l j F Y · H:i',
            'description' => __('PHP date format string (e.g. "l j F Y · H:i")', 'exode'),
            'condition'   => ['show_date' => 'yes'],
        ]);

        $this->add_control('no_event_text', [
            'label'   => __('No Upcoming Event Text', 'exode'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('No upcoming event.', 'exode'),
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE — CARD ---
        $this->start_controls_section('style_card', [
            'label' => __('Card', 'exode'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('card_padding', [
            'label'      => __('Padding', 'exode'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'default'    => [
                'top'    => '24',
                'right'  => '28',
                'bottom' => '24',
                'left'   => '28',
                'unit'   => 'px',
                'isLinked' => false,
            ],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('card_margin', [
            'label'      => __('Margin', 'exode'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'card_background',
            'selector' => '{{WRAPPER}} .exode-next-event-card',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .exode-next-event-card',
        ]);

        $this->add_control('card_border_radius', [
            'label'      => __('Border Radius', 'exode'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .exode-next-event-card',
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE — TITLE ---
        $this->start_controls_section('style_title', [
            'label'     => __('Title', 'exode'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_title' => 'yes'],
        ]);

        $this->add_control('title_color', [
            'label'     => __('Color', 'exode'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .exode-next-event-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .exode-next-event-title',
        ]);

        $this->add_responsive_control('title_spacing', [
            'label'      => __('Bottom Spacing', 'exode'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range'      => ['px' => ['min' => 0, 'max' => 60]],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE — DATE ---
        $this->start_controls_section('style_date', [
            'label'     => __('Date', 'exode'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_date' => 'yes'],
        ]);

        $this->add_control('date_color', [
            'label'     => __('Color', 'exode'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .exode-next-event-date' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'date_typography',
            'selector' => '{{WRAPPER}} .exode-next-event-date',
        ]);

        $this->add_responsive_control('date_spacing', [
            'label'      => __('Bottom Spacing', 'exode'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range'      => ['px' => ['min' => 0, 'max' => 60]],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-date' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('date_icon_gap', [
            'label'      => __('Icon Gap', 'exode'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range'      => ['px' => ['min' => 0, 'max' => 20]],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-date .exode-meta-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE — LOCATION ---
        $this->start_controls_section('style_location', [
            'label'     => __('Location', 'exode'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_location' => 'yes'],
        ]);

        $this->add_control('location_color', [
            'label'     => __('Color', 'exode'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .exode-next-event-location' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'location_typography',
            'selector' => '{{WRAPPER}} .exode-next-event-location',
        ]);

        $this->add_responsive_control('location_spacing', [
            'label'      => __('Bottom Spacing', 'exode'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range'      => ['px' => ['min' => 0, 'max' => 60]],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-location' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('location_icon_gap', [
            'label'      => __('Icon Gap', 'exode'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range'      => ['px' => ['min' => 0, 'max' => 20]],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-location .exode-meta-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE — DESCRIPTION ---
        $this->start_controls_section('style_content', [
            'label'     => __('Description', 'exode'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['show_content' => 'yes'],
        ]);

        $this->add_control('content_color', [
            'label'     => __('Color', 'exode'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .exode-next-event-content' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'content_typography',
            'selector' => '{{WRAPPER}} .exode-next-event-content',
        ]);

        $this->add_responsive_control('content_spacing', [
            'label'      => __('Top Spacing', 'exode'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range'      => ['px' => ['min' => 0, 'max' => 60]],
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-content' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE — NO EVENT TEXT ---
        $this->start_controls_section('style_no_event', [
            'label' => __('No Event Text', 'exode'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('no_event_color', [
            'label'     => __('Color', 'exode'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .exode-next-event-none' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'no_event_typography',
            'selector' => '{{WRAPPER}} .exode-next-event-none',
        ]);

        $this->end_controls_section();
    }


    protected function render(): void {
        $settings = $this->get_settings_for_display();

        /** @var Event[] $events */
        $events = get_option("events_list", []);
        $now    = time();

        // Find the next event: the first whose endDate is in the future
        $next_event = null;
        foreach ($events as $event) {
            if ($event->endDate >= $now) {
                $next_event = $event;
                break;
            }
        }

        if ($next_event === null) {
            echo '<p class="exode-next-event-none">' . esc_html($settings['no_event_text']) . '</p>';
            return;
        }

        $date_format = !empty($settings['date_format']) ? $settings['date_format'] : 'l j F Y · H:i';
        $start_label = esc_html(wp_date($date_format, $next_event->startDate));
        $end_label   = esc_html(wp_date($date_format, $next_event->endDate));

        echo '<div class="exode-next-event-card">';

        if ($settings['show_title'] === 'yes') {
            echo '<h3 class="exode-next-event-title">' . esc_html($next_event->title) . '</h3>';
        }

        if ($settings['show_date'] === 'yes') {
            echo '<p class="exode-next-event-date">';
            echo '<span class="exode-meta-icon dashicons dashicons-calendar-alt" aria-hidden="true"></span>';
            echo $start_label . ' — ' . $end_label;
            echo '</p>';
        }

        if ($settings['show_location'] === 'yes' && !empty($next_event->location)) {
            echo '<p class="exode-next-event-location">';
            echo '<span class="exode-meta-icon dashicons dashicons-location" aria-hidden="true"></span>';
            echo esc_html($next_event->location);
            echo '</p>';
        }

        if ($settings['show_content'] === 'yes' && !empty($next_event->content)) {
            echo '<div class="exode-next-event-content">' . nl2br(esc_html($next_event->content)) . '</div>';
        }

        echo '</div>';
    }
}
