<?php

namespace Exode\Views;

function render_buvette_form(bool $opened): void {
    ?>
<div class="wrap">
    <h1>Paramètres de la Buvette</h1>
    <form method="post">
        <?php wp_nonce_field("buvette_opened_update", "buvette_opened_nonce"); ?>
        <label>
            <input type="radio" name="buvette_opened" value="1" <?php checked($opened); ?>>
            Ouverte
        </label>
        <label>
            <input type="radio" name="buvette_opened" value="0" <?php checked(!$opened); ?>>
            Fermée
        </label>
        <?php submit_button("Enregistrer"); ?>
    </form>
</div>
    <?php
}
