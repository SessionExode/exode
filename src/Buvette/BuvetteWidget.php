<?php

namespace Exode\Buvette;

use Elementor\Widget_Base;

class BuvetteWidget extends Widget_Base {
    public function get_name(): string {
        return "exode_buvette";
    }
    public function get_title(): string {
        return __("Buvette", "exode");
    }
    public function get_icon(): string {
        return "eicon-info-circle";
    }
    public function get_categories(): array {
        return ["exode"];
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $is_open = intval(get_option("buvette_open", 0));

        $status_text = $is_open ? "ouverte" : "fermée";
        $open_attr = $is_open ? "1" : "0";

        echo '<div class="buvette-widget-wrapper">';
        echo '<span class="dashicons-before dashicons-beer" data-open="' . $open_attr . '">';
        echo ' Buvette ' . esc_html($status_text);
        echo '</span>';
        echo '</div>';
    }
}
