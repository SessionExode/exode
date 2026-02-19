<?php

namespace Exode\Events;

/** @param Event[] $events */
function render_events_form(array $events) {
    $event_days = [
        "2026-03-06",
        "2026-03-07",
        "2026-03-08",
    ];
?>
    <div class="wrap">
        <h1><?php _e("Manage Events", "exode"); ?> (<?php echo count($events); ?>)</h1>

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
                        <textarea name="e_content" placeholder="<?php _e("Event content", "exode"); ?>" rows="3" class="large-text"></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label><?php _e("Time", "exode"); ?></label>
                    </th>
                    <td>
                        <select name="e_day" required>
                            <option value="">Select Day</option>
                            <?php foreach ($event_days as $day): ?>
                                <option value="<?php echo esc_attr($day); ?>" <?php selected($day); ?>>
                                    <?php echo date("d/m/Y", strtotime($day)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="time" name="e_start_time" required>
                        <input type="time" name="e_end_time" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="e_location"><?php _e("Location", "exode"); ?></label>
                    </th>
                    <td>
                        <input type="text" id="e_location" name="e_location" class="regular-text" required>
                        <input type="hidden" id="e_lat" name="e_lat">
                        <input type="hidden" id="e_lng" name="e_lng">
                        <div id="map-preview"></div>
                    </td>
                </tr>
            </table>

            <?php submit_button(__("Create", "exode")); ?>
        </form>
        <form method="post"
            onsubmit="<?php echo "return confirm('" . __("Delete all events", "exode") . "?');"; ?>">
            <?php wp_nonce_field("delete_all_events_action", "delete_all_nonce"); ?>
            <input type="hidden" name="action" value="delete_all">
            <?php submit_button(__("Delete all events", "exode"), 'delete', 'delete_all_button', false); ?>
        </form>

        <table class="wp-list widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e("Time", "exode"); ?></th>
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
                        $day = esc_html(wp_date("D", $e->start->getTimestamp()));
                        $startTime = esc_html(wp_date("H:i", $e->start->getTimestamp()));
                        $endTime = esc_html(wp_date("H:i", $e->end->getTimestamp())); ?>
                        <tr>
                            <td><?php echo $day . " " . $startTime . " - " . $endTime; ?></td>
                            <td><strong><?php echo esc_html($e->title); ?></strong></td>
                            <td><?php echo nl2br(esc_html($e->content)); ?></td>
                            <td><?php echo esc_html($e->location); ?></td>
                            <td>
                                <a
                                    href="<?php echo wp_nonce_url(admin_url('admin.php?page=exode-events&action=delete&id=' . $e->id), 'delete_event_' . $e->id); ?>"
                                    style="color:red"
                                    onclick="<?php echo "return confirm('" . __("Delete", "exode") . " " . $e->title . "?')"; ?>">
                                    <?php _e("Delete", "exode"); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
    <script>
        function initMap() {
            const input = document.getElementById("e_location");
            const autocomplete = new google.maps.places.Autocomplete(input);
            const map = new google.maps.Map(document.getElementById("map-preview"), {
                zoom: 13,
                center: { // Lourdes sanctuary
                    lat: 43.097419,
                    lng: -0.0608617
                }
            });
            autocomplete.addListener("place_changed", function() {
                const place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                document.getElementById("e_lat").value = place.geometry.location.lat();
                document.getElementById("e_lng").value = place.geometry.location.lng();
                map.setCenter(place.geometry.location);
                marker.setPosition(place.geometry.location);
                console.log("updated");
            });
            console.log("bam");
        }
        google.maps.event.addDomListener(window, "load", initMap);
    </script>

<?php
}
