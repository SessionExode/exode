<?php


namespace Exode\RedirectDesktop;

use \Elementor\Plugin;

class RedirectDesktopFeature {
    public function __construct() {
        add_action("wp_head", [$this, "inject_desktop_redirect"]);
    }

    public function inject_desktop_redirect() {
        if (
            isset($_GET["elementor-preview"])
            || Plugin::$instance->editor->is_edit_mode() // don't redirect if editing
            || is_admin() // don't redirect when admin
            || is_customize_preview()
            || is_page("desktop-notice") // don't redirect if already on notice
        ) {
            return;
        }

        $url = home_url("/desktop-notice/");
?>
        <script type="text/javascript">
            (function() {
                const isDesktop = window.matchMedia("(pointer: fine)").matches;
                if (isDesktop) {
                    window.location.href = "<?php echo esc_url($url); ?>";
                }
            })();
        </script>
<?php
    }
}
