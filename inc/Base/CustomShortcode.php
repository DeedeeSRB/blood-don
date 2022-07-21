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

        add_shortcode( 'donors-table', array( 'Inc\Base\CustomShortcode', 'donorsTableShortcode' ) );
        add_shortcode( 'add-donor', array( 'Inc\Base\CustomShortcode', 'addDonorShortcode' ) );
        add_shortcode( 'update-donor', array( 'Inc\Base\CustomShortcode', 'updateDonorShortcode' ) );
        add_shortcode( 'donations-table', array( 'Inc\Base\CustomShortcode', 'donationsTableShortcode' ) );
        add_shortcode( 'add-donation', array( 'Inc\Base\CustomShortcode', 'addDonationsShortcode' ) );
        add_shortcode( 'update-donation', array( 'Inc\Base\CustomShortcode', 'updateDonationsShortcode' ) );
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

    public static function donorsTableShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/donors-table.php';
    }

    public static function addDonorShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/add-donor.php';
    }

    public static function updateDonorShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/update-donor.php';
    }

    public static function donationsTableShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/donations-table.php';
    }

    public static function addDonationsShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/add-donation.php';
    }

    public static function updateDonationsShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/update-donation.php';
    }
}