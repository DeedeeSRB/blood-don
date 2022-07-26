<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Manage;

class ShortcodeManager
{
    public function register() {
        add_shortcode( 'bd-page-restricted', array( $this, 'pageRestricted' ) );

        add_shortcode( 'bd-login-page', array( $this, 'loginPage' ) );
        add_shortcode( 'bd-register-page', array( $this, 'registerPage' ) );

        add_shortcode( 'bd-logout-page', array( $this, 'logoutPage' ) );

        add_shortcode( 'bd-home-page', array( $this, 'homePage' ) );
    }

    public function pageRestricted() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-page-restricted.php';
    }

    public function loginPage() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-login-page.php';
    }

    public function registerPage() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-register-page.php';
    }

    public function logoutPage() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-logout-page.php';
    }

    public function homePage() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-home-page.php';
    }
}