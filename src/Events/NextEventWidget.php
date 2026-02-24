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
        $this->start_controls_section('global_section', [
            'label' => __('Global', 'exode'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('next_event_text', [
            'label'   => __('Next Event Text', 'exode'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Next event', 'exode'),
        ]);

        $this->add_control('no_event_text', [
            'label'   => __('No Upcoming Event Text', 'exode'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('No upcoming event.', 'exode'),
        ]);

        $this->end_controls_section();

        $this->start_controls_section('title_section', [
            'label' => __('Title', 'exode'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control(
            'title_size',
            [
                'label' => esc_html__('HTML Tag', 'elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h5',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('date_section', [
            'label' => __('Date', 'exode'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('date_format', [
            'label'       => __('Date Format', 'exode'),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'l j F Y',
            'description' => __('PHP date format for the day (e.g. "l j F Y")', 'exode'),
        ]);

        $this->add_control('time_format', [
            'label'       => __('Time Format', 'exode'),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'H:i',
            'description' => __('PHP time format (e.g. "H:i" or "g:i a")', 'exode'),
        ]);

        $this->end_controls_section();

        $this->start_controls_section('description_section', [
            'label' => __('Description', 'exode'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);


        $this->add_control('show_content', [
            'label'        => __('Show Description', 'exode'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Yes', 'exode'),
            'label_off'    => __('No', 'exode'),
            'return_value' => 'yes',
            'default'      => 'yes',
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
            'selectors'  => [
                '{{WRAPPER}} .exode-next-event-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .exode-next-event-card',
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE — TEXT ELEMENTS ---
        // (Title Style Section)
        $this->start_controls_section('style_title', [
            'label'     => __('Title', 'exode'),
            'tab'       => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label'     => __('Color', 'exode'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .exode-next-event-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .exode-next-event-title',
        ]);

        $this->end_controls_section();

        // (Date/Time Style Section)
        $this->start_controls_section('style_date', [
            'label'     => __('Date & Time', 'exode'),
            'tab'       => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('date_color', [
            'label'     => __('Color', 'exode'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .exode-next-event-date' => 'color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'date_typography',
            'selector' => '{{WRAPPER}} .exode-next-event-date',
        ]);

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();

        /** @var Event[] $events */
        $events = get_option("events_list", []);
        $now    = time();

        $next_event = null;
        foreach ($events as $event) {
            if ($event->getStart()->getTimestamp() >= $now) {
                $next_event = $event;
                break;
            }
        }

        if ($next_event === null) {
            echo '<p class="exode-next-event-none">' . esc_html($settings['no_event_text']) . '</p>';
            return;
        }

        $title_size = $settings["title_size"] ?: "h5";
        $date_format = $settings['date_format'] ?: 'l j F Y';
        $time_format = $settings['time_format'] ?: 'H:i';

        $day_label   = wp_date($date_format, $next_event->getStart()->getTimestamp());
        $start_time  = wp_date($time_format, $next_event->getStart()->getTimestamp());
        $end_time    = $next_event->getEnd() ? wp_date($time_format, $next_event->getEnd()->getTimestamp()) : "";

        echo '<div class="exode-next-event-card">';
        echo '<p>' . esc_html($settings["next_event_text"]) . '</p>';

        echo '<' . $title_size . ' class="exode-next-event-title">' . esc_html($next_event->getTitle()) . '</' . $title_size . '>';

        echo '<p class="exode-next-event-date">';
        echo '<span class="exode-meta-icon dashicons dashicons-calendar-alt" aria-hidden="true"></span>';
        if ($end_time) {
            echo esc_html($day_label) . ' | ' . esc_html($start_time) . ' – ' . esc_html($end_time);
        } else {
            echo esc_html($day_label) . ' | ' . esc_html($start_time);
        }
        echo '</p>';

        // Location is now mandatory (checks if empty just in case)
        if (!empty($next_event->getLocation())) {
            echo '<p class="exode-next-event-location">';
            echo '<span class="exode-meta-icon dashicons dashicons-location" aria-hidden="true"></span>';
            echo esc_html($next_event->getLocation());
            echo '</p>';
        }

        // Description remains optional via switcher
        if ($settings['show_content'] === 'yes') {
            echo '<div class="exode-next-event-content">' . nl2br(esc_html($next_event->getContent())) . '</div>';
        }

        echo '</div>';
    }
}
