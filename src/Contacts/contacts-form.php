<?php

namespace Exode\Contacts;

/** @param Contact[] $contacts */
function render_contacts_form(array $contacts): void {
?>
    <div class="wrap">
        <h1>Contacts (<?php echo count($contacts); ?>)</h1>
        <form method="post">
            <?php wp_nonce_field("add_contact_action", "contact_nonce"); ?>
            <h3><?php _e("New Contact"); ?></h3>
            <p><input type="text" name="c_first_name" placeholder="<?php _e("First name", "exode"); ?>" required></p>
            <p><input type="text" name="c_name" placeholder="<?php _e("Name", "exode"); ?>" required></p>
            <p><input type="tel" name="c_tel" placeholder="Tel" required></p>
            <p><input type="text" name="c_role" placeholder="Role" required></p>
            <?php submit_button(__("Create", "exode")); ?>
        </form>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e("First name", "exode"); ?></th>
                    <th><?php _e("Name", "exode"); ?></th>
                    <th><?php _e("Phone Number", "exode"); ?></th>
                    <th><?php _e("Role", "exode"); ?></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="5"><?php _e("No contact found.", "exode"); ?></td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $c): ?>
                        <tr>
                            <td><?php echo esc_html($c->first_name); ?></td>
                            <td><?php echo esc_html($c->name); ?></td>
                            <td><a href="tel:<?php echo esc_html($c->tel); ?>"><?php echo esc_html($c->tel); ?></a></td>
                            <td><?php echo esc_html($c->role); ?></td>
                            <td>
                                <a
                                    href="<?php echo wp_nonce_url(admin_url('admin.php?page=exode-contacts&action=delete&id=' . $c->id), 'delete_contact_' . $c->id); ?>"
                                    style="color:red"
                                    onclick="<?php echo "return confirm ('" . __('Delete', 'exode') . " "  . $c->first_name . " " . $c->name . "?')"; ?>">
                                    <?php _e("Delete", "exode"); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php
}
