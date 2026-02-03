<?php

namespace Exode\Views;

function render_contacts_form(array $contacts): void {
    ?>
<div class="wrap">
    <h1>Contacts</h1>
    <form method="post">
        <?php wp_nonce_field("add_contact_action", "contact_nonce"); ?>
        <h3>Nouveau contact</h3>
        <p><input type="text" name="c_first_name" placeholder="Prénom" required></p>
        <p><input type="text" name="c_name" placeholder="Nom" required></p>
        <p><input type="tel" name="c_tel" placeholder="Tel" required></p>
        <p><input type="text" name="c_role" placeholder="Role" required></p>
        <?php submit_button("Ajouter le contact"); ?>
    </form>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Tel</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($contacts)): ?>
                <tr><td colspan="3">Aucun contact trouvé.</td></tr>
            <?php else: ?>
                <?php foreach ($contacts as ["first_name" => $first_name,"name" => $name,"tel" => $tel,"role" => $role]): ?>
                    <tr>
                        <td><?php echo esc_html($first_name); ?></td>
                        <td><?php echo esc_html($name); ?></td>
                        <td><a href="tel:<?php echo esc_html($tel); ?>"><?php echo esc_html($tel); ?></a></td>
                        <td><?php echo esc_html($role); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
    <?php
}
