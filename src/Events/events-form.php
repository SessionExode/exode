<?php

namespace Exode\Events;

/** @param Event[] $events */
function render_events_form(array $events) {
    $d = date("Y-m-d\TH:i");
?>
    <div class="wrap">
        <h1><?php _e("Manage Events", "exode"); ?></h1>

        <form method="post">
            <?php wp_nonce_field("add_event_action", "events_nonce"); ?>
            <h3><?php _e("New Event", "exode"); ?></h3>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="e_title"><?php _e("Title", "exode"); ?></label>
                    </th>
                    <td>
                        <input type="text" name="e_title" class="regular-text" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="e_content"><?php _e("Content", "exode"); ?></label>
                    </th>
                    <td>
                        <textarea name="e_content" placeholder="<?php _e("Event content", "exode"); ?>" rows="3" class="large-text" required></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label><?php _e("Start - End", "exode"); ?></label>
                    </th>
                    <td>
                        <input type="datetime-local" name="e_start_date" value="<?php echo $d; ?>" required>
                        <input type="datetime-local" name="e_end_date" value="<?php echo $d; ?>" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="e_location"><?php _e("Location", "exode"); ?></label>
                    </th>
                    <td>
                        <input type="text" name="e_location" class="regular-text" required>
                    </td>
                </tr>
            </table>

            <?php submit_button(__("Create", "exode")); ?>
        </form>

        <table class="wp-list widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e("Start - End", "exode"); ?></th>
                    <th><?php _e("Title", "exode"); ?></th>
                    <th><?php _e("Content", "exode"); ?></th>
                    <th><?php _e("Location", "exode"); ?></th>
                    <th><?php _e("Actions", "exode"); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($events)): ?>
                    <tr>
                        <td colspan="5"><?php _e("No event found.", "exode"); ?></td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($events as $e):
                        $startDate = esc_html(wp_date("j M H:i", $e->startDate));
                        $endDate = esc_html(wp_date("j M H:i", $e->endDate)); ?>
                        <tr>
                            <td><?php echo $startDate . " - " . $endDate; ?></td>
                            <td><strong><?php echo esc_html($e->title); ?></strong></td>
                            <td><?php echo nl2br(esc_html($e->content)); ?></td>
                            <td><?php echo esc_html($e->location); ?></td>
                            <td>
                                <a
                                    href="<?php echo wp_nonce_url(admin_url('admin.php?page=exode-events&action=delete&id=' . $e->id), 'delete_event_' . $e->id); ?>"
                                    style="color:red"
                                    onclick="<?php echo "return confirm ('" . __("Delete", "exode") . " " . $e->title . "?')"; ?>">
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
