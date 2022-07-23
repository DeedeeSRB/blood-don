<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;

class CustomShortcode
{
    public static function register() {
        add_shortcode( 'bd-page-restricted', array( 'Inc\Base\CustomShortcode', 'pageRestricted' ) );

        add_shortcode( 'bd-login-page', array( 'Inc\Base\CustomShortcode', 'loginPage' ) );
        add_shortcode( 'bd-register-page', array( 'Inc\Base\CustomShortcode', 'registerPage' ) );

        add_shortcode( 'bd-logout-page', array( 'Inc\Base\CustomShortcode', 'logoutPage' ) );

        add_shortcode( 'bd-home-page', array( 'Inc\Base\CustomShortcode', 'homePage' ) );
    }

    public static function pageRestricted() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-page-restricted.php';
    }

    public static function loginPage() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-login-page.php';
    }

    public static function registerPage() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-register-page.php';
    }

    public static function logoutPage() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-logout-page.php';
    }

    public static function homePage() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/bd-home-page.php';
    }
}