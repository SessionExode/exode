<?php

namespace Exode\Events;


/** @param Event[] $events */
function render_events_form(array $events, ?Event $edit_event) {
    $event_days = [
        "2026-03-06",
        "2026-03-07",
        "2026-03-08",
    ];

?>
    <div class="wrap">
        <h1><?= __("Manage Events", "exode") ?> (<?= count($events) ?>)</h1>

        <form method="post">
            <?php wp_nonce_field("add_event_action", "events_nonce"); ?>

            <?php if ($edit_event): ?>
                <h3><?= __("Edit Event", "exode") ?></h3>
                <input type="hidden" name="e_id" value="<?= esc_attr($edit_event->getId()) ?>">
            <?php else: ?>
                <h3><?= __("New Event", "exode") ?></h3>
            <?php endif; ?>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="e_title"><?= __("Title", "exode") ?></label>
                    </th>
                    <td>
                        <input type="text" name="e_title" class="regular-text" required
                            value="<?= esc_attr($edit_event?->getTitle()) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="e_content"><?= __("Content", "exode") ?></label>
                    </th>
                    <td>
                        <textarea name="e_content" placeholder="<?= __("Event content", "exode") ?>" rows="3"
                            class="large-text"><?= esc_textarea($edit_event?->getContent()) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?= __("Time", "exode") ?></label>
                    </th>
                    <td>
                        <?php $current_day = $edit_event ? wp_date('Y-m-d', $edit_event->getStart()->getTimestamp()) : ''; ?>
                        <select name="e_day" required>
                            <option value="">Select Day</option>
                            <?php foreach ($event_days as $day): ?>
                                <option value="<?= esc_attr($day) ?>" <?php selected($day, $current_day) ?>>
                                    <?= date("d/m/Y", strtotime($day)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="time" name="e_start_time" required
                            value="<?= $edit_event ? esc_attr(wp_date('H:i', $edit_event->getStart()->getTimestamp())) : '' ?>">
                        <input type="time" name="e_end_time"
                            value="<?= $edit_event && $edit_event->getEnd() ? esc_attr(wp_date('H:i', $edit_event->getEnd()->getTimestamp())) : '' ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="e_location"><?= __("Location", "exode") ?></label>
                    </th>
                    <td>
                        <input type="text" id="e_location" name="e_location" class="regular-text" required
                            value="<?= esc_attr($edit_event?->getLocation()) ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="e_page_id"><?= __("Linked Page", "exode") ?></label>
                    </th>
                    <td>
                        <?php wp_dropdown_pages([
                            "name" => "e_page_id",
                            "show_option_none" => __("No linked page", "exode"),
                            "option_none_value" => "0",
                            "selected" => $edit_event ? $edit_event->getPageId() : 0
                        ]); ?>
                    </td>
                </tr>
            </table>

            <?php submit_button($edit_event ? __("Update", "exode") : __("Create", "exode")); ?>
        </form>
        <form method="post"
            onsubmit="<?= "return confirm('" . __("Delete all events", "exode") . "?');" ?>">
            <?php wp_nonce_field("delete_all_events_action", "delete_all_nonce"); ?>
            <input type="hidden" name="action" value="delete_all">
            <?php submit_button(__("Delete all events", "exode"), 'delete', 'delete_all_button', false); ?>
        </form>

        <table class="wp-list widefat fixed striped">
            <thead>
                <tr>
                    <th><?= __("Time", "exode") ?></th>
                    <th><?= __("Title", "exode") ?></th>
                    <th><?= __("Content", "exode") ?></th>
                    <th><?= __("Location", "exode") ?></th>
                    <th><?= __("Linked Page", "exode") ?></th>
                    <th><?= __("Actions", "exode") ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($events)): ?>
                    <tr>
                        <td colspan="6"><?= __("No event found.", "exode") ?></td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($events as $e):
                        $day = esc_html(wp_date("D", $e->getStart()->getTimestamp()));
                        $startTime = esc_html(wp_date("H:i", $e->getStart()->getTimestamp()));
                        $endTime = $e->getEnd() ? esc_html(wp_date("H:i", $e->getEnd()->getTimestamp())) : ""; ?>
                        <tr>
                            <td>
                                <?= $day . " " . $startTime ?>
                                <?= $endTime ? " - " . $endTime : "" ?>
                            </td>
                            <td><strong><?= esc_html($e->getTitle()) ?></strong></td>
                            <td><?= nl2br(esc_html($e->getContent())) ?></td>
                            <td><?= esc_html($e->getLocation()) ?></td>
                            <td>
                                <?php if ($e->getPageId()): ?>
                                    <a href="<?= get_permalink($e->getPageId()) ?>">
                                        <?= esc_html(get_the_title($e->getPageId())) ?>
                                    </a>
                                <?php else: ?>
                                    <p><?= esc_html(__("No linked page", "exode")) ?></p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a
                                    href="<?= wp_nonce_url(admin_url('admin.php?page=exode-events&action=edit&id=' . $e->getId())) ?>">
                                    <?= __("Edit", "exode") ?>
                                </a> |
                                <a
                                    href="<?= wp_nonce_url(admin_url('admin.php?page=exode-events&action=delete&id=' . $e->getId()), 'delete_event_' . $e->getId()) ?>"
                                    style="color:red"
                                    onclick="<?= "return confirm('" . __("Delete", "exode") . " " . $e->getTitle() . "?')" ?>">
                                    <?= __("Delete", "exode") ?>
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
