<?php

namespace Exode\Announcements;

/** @param Announcement[] $announcements */
function render_announcements_form(array $announcements): void {
    ?>
<div class="wrap">
    <h1>Gestion des Annonces</h1>

    <form method="post">
        <?php wp_nonce_field("add_announcement_action", "announcements_nonce"); ?>
        <h3>Nouvelle Annonce</h3>
        <p><input type="text" name="a_title" placeholder="Titre" class="regular-text" required></p>
        <p><textarea name="a_content" placeholder="Contenu du l'annonce" rows="3" class="large-text" required></textarea></p>
        <p>
            <label for="a_date">Date (Optionnel) : </label><br>
            <input type="datetime-local" name="a_date" value="<?php echo date('Y-m-d\TH:i'); ?>">
        </p>
        <?php submit_button("Ajouter l'annonce"); ?>
    </form>

    <table class="wp-list widefat fixed striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($announcements)): ?>
                <tr><td colspan="4"> Aucune annonce trouvée.</td></tr>
            <?php else: ?>
                <?php foreach ($announcements as $a): ?>
                    <tr>
                        <td><?php echo esc_html(wp_date("l j F Y H:i", $a->date)); ?></td>
                        <td><strong><?php echo esc_html($a->title); ?></strong></td>
                        <td><?php echo nl2br(esc_html($a->content)); ?></td>
                        <td>
                            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=exode-announcements&action=delete&id=' . $a->id), 'delete_announcement_' . $a->id); ?>">
                                Supprimer
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
