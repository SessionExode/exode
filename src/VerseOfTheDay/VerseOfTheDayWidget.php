<?php

namespace Exode\VerseOfTheDay;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Shows the Verse of the day (according to AELF).
 */
class VerseOfTheDayWidget extends Widget_Base {
    public function get_name() {
        return "exode_verse_of_the_day";
    }
    public function get_title() {
        return __("Verse of the Day", "exode");
    }
    public function get_icon(): string {
        return "eicon-blockquote";
    }
    public function get_categories(): array {
        return ["exode"];
    }

    protected function register_controls() {
        $this->start_controls_section('global_section', [
            'label' => __('Global', 'exode'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('title', [
            'label'   => __('Verse of the Day Title', 'exode'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Verse of the Day', 'exode'),
        ]);

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'elementor'),
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

        // --- SECTION: CONTAINER STYLE ---
        $this->start_controls_section(
            'section_container_style',
            ['label' => __('Container', 'exode'), 'tab' => Controls_Manager::TAB_STYLE]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            ['name' => 'container_background', 'selector' => '{{WRAPPER}} .exode-verse-container']
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label'      => __('Padding', 'exode'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exode-verse-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            ['name' => 'container_border', 'selector' => '{{WRAPPER}} .exode-verse-container']
        );

        $this->add_control(
            'container_border_radius',
            [
                'label'      => __('Border Radius', 'exode'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors'  => ['{{WRAPPER}} .exode-verse-container' => 'border-radius: {{SIZE}}{{UNIT}};'],
            ]
        );

        $this->end_controls_section();
    }

    private function get_verse() {
        $verse = null;
        $ref = null;
        $error = null;

        $date = date("Y-m-d");
        $url = "https://api.aelf.org/v1/messes/$date/romain";
        $json = file_get_contents($url);
        if ($json === false) {
            $error = __("Unable to load the verse.", "exode");
            return ["verse" => $verse, "ref" => $ref, "error" => $error];
        }

        $data = json_decode($json, true);

        if (!isset($data["messes"])) {
            $error = __("No mass data found for today", "exode");
            return ["verse" => $verse, "ref" => $ref, "error" => $error];
        }

        foreach ($data["messes"] as $messe) {
            if (!isset($messe["lectures"])) {
                continue;
            }

            foreach ($messe["lectures"] as $lecture) {
                if (($lecture["type"] ?? "") !== "evangile") {
                    continue;
                }

                // found it
                $verse = $lecture["verset_evangile"] ?? null;
                $ref = $lecture["ref_verset"] ?? null;
                break 2;
            }
        }
        return ["verse" => $verse, "ref" => $ref, "error" => $error];
    }

    protected function render() {
        ["verse" => $verse, "ref" => $ref, "error" => $error] = $this->get_verse();

        $settings = $this->get_settings_for_display();

        $title_tag = esc_attr($settings["title_tag"] ?: "h5");
        $title = $settings["title"];

        if ($verse) : ?>
            <div class="exode-verse-container">
                <?php if ($title): ?>
                    <<?= $title_tag ?>>
                        <?= esc_html($title) ?>
                    </<?= $title_tag ?>>
                <?php endif; ?>

                <?= wp_kses_post($verse); ?>

                <?php if ($ref): ?>
                    <span class="exode-verse-ref">
                        <p>(<?= esc_html($ref); ?>)</p>
                    </span>
                <?php endif; ?>

            </div>
        <?php else: ?>
            <p><?= __("No verse available for today.", "exode") ?></p>
<?php endif;
    }
}
