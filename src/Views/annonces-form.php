<?php

namespace Exode\Views;

function render_annonces_form(int $current_val): void {
    ?>
<div class="wrap">
    <h1>Paramètres des Annonces</h1>
    <form method="post" action="">
        <?php wp_nonce_field("annonces_update", "annonces_nonce"); ?>
        <input name="annonces" type="number" value="<?php echo esc_attr($current_val); ?>">
        <?php submit_button(); ?>
    </form>
</div>
    <?php
}
