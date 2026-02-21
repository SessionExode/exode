<?php

namespace Exode\Core;

function render_core_form(string $google_maps_api_key) {
?>
    <div class="wrap">
        <h1><?php _e("Welcome to the Exode plugin", "exode"); ?></h1>
        <h2><?php _e("Settings", "exode"); ?></h2>
        <form method="post">
            <label>
                <p>Google Maps API Key</p>
                <input type="text" name="google_maps_api_key"
                    class="regular-text"
                    value="<?= esc_attr($google_maps_api_key); ?>">
            </label>
            <?php submit_button(__("Save", "exode"));; ?>
        </form>

    </div>
<?php
}
