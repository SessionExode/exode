<?php

namespace Exode\Announcements;

function render_announcements_form(int $current_val): void {
    ?>
<div class="wrap">
    <h1>Paramètres des Announcements</h1>
    <form method="post" action="">
        <?php wp_nonce_field("announcements_update", "announcements_nonce"); ?>
        <input name="announcements" type="number" value="<?php echo esc_attr($current_val); ?>">
        <?php submit_button("Enregistrer"); ?>
    </form>
</div>
    <?php
}
