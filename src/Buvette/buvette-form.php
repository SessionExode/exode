<?php

namespace Exode\Buvette;

function render_buvette_form(bool $open): void {
?>
    <div class="wrap">
        <h1><?php _e("Buvette Settings", "exode"); ?></h1>
        <form method="post">
            <?php wp_nonce_field("buvette_open_update", "buvette_open_nonce"); ?>
            <label>
                <input type="radio" name="buvette_open" value="1" <?php checked($open); ?>>
                <?php __("Open", "exode"); ?>
            </label>
            <label>
                <input type="radio" name="buvette_open" value="0" <?php checked(!$open); ?>>
                <?php __("Closed", "exode"); ?>
            </label>
            <?php submit_button(__("Save", "exode")); ?>
        </form>
    </div>
<?php
}
