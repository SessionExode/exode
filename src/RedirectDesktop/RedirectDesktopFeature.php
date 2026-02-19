<?php


namespace Exode\RedirectDesktop;

use \Elementor\Plugin;

class RedirectDesktopFeature {
    public function __construct() {
        add_action("wp_head", [$this, "inject_desktop_redirect"]);
    }

    public function inject_desktop_redirect() {
        $url = home_url("/desktop-notice/");
        // alert if editing + desktop
        // redirect if non-editing + desktop
        $alert = isset($_GET["elementor-preview"])
            || Plugin::$instance->editor->is_edit_mode() // don't redirect if editing
            || is_admin() // don't redirect when admin
            || is_customize_preview()
            || is_page("desktop-notice"); // don't redirect if already on notice

?>
        <script type="text/javascript">
            (function() {
                const isDesktop = window.matchMedia("(pointer: fine)").matches;
                if (isDesktop) {
                    <?php if ($alert) { ?>
                        alert("<?php _e("Editing Page in Desktop view", "exode"); ?>");
                    <?php } else { ?>
                        window.location.href = "<?php echo esc_url($url); ?>";
                    <?php } ?>

                }
            })();
        </script>
<?php
    }
}
