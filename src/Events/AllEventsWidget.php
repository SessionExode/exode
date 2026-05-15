<?php

namespace Exode\Events;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Shows All the events starting on the current day. To view a selected day, load page with url parameter date=Y-m-d.
 */
class AllEventsWidget extends Widget_Base {
    public function get_name() {
        return "exode_all_events";
    }
    public function get_title() {
        return __("All Events", "exode");
    }
    public function get_icon(): string {
        return "eicon-calendar";
    }
    public function get_categories(): array {
        return ["exode"];
    }

    protected function register_controls(): void {
        $this->start_controls_section('global_section', [
            'label' => __('Global', 'exode'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('no_events_text', [
            'label'   => __('No Events Text', 'exode'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('No events scheduled for today.', 'exode'),
        ]);

        $this->add_control('time_format', [
            'label'       => __('Time Format', 'exode'),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'H:i',
            'description' => __('PHP time format (e.g. "H:i" or "g:i a")', 'exode'),
        ]);

        $this->end_controls_section();
    }

    private function get_events() {
        /** @var Event[] $events */
        $events = get_option("events_list", []);
        $today = $_GET["date"] ?? wp_date("Y-m-d");
        $todays_events = array_filter(
            $events,
            fn($e) => wp_date("Y-m-d", $e->getStart()->getTimestamp()) === $today
        );
        return $todays_events;
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();

        $events = $this->get_events();

        if (empty($events)) { // no events today 
?>
            <p class="exode-all-events-none"><?= esc_html($settings["no_events_text"]) ?></p>
        <?php return;
        }

        foreach ($events as $e) {
            $time_format = $settings["time_format"] ?: "H:i";
            $start_time = wp_date($time_format, $e->getStart()->getTimestamp());
            $end_time = $e->getEnd() ? wp_date($time_format, $e->getEnd()->getTimestamp()) : "";
        ?>
            <div class="exode-event-item">
                <h4 class="exode-event-title"><?= esc_html($e->getTitle()) ?></h4>
                <div class="exode-event-time">
                    <span class="exode-meta-icon dashicons dashicons-clock" aria-hidden="true"></span>
                    <?php if ($end_time) {
                        echo esc_html($start_time . " - " . $end_time);
                    } else {
                        echo esc_html($start_time);
                    } ?>
                </div>
                <?php if (!empty($e->getLocation())): ?>
                    <div class="exode-event-location">
                        <span class="exode-meta-icon dashicons dashicons-location" aria-hidden="true"></span>
                        <?= esc_html($e->getLocation()) ?>
                    </div>
                <?php endif; ?>
            </div>
<?php }
    }
}
