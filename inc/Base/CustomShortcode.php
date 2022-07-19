<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;

class CustomShortcode
{
    public function register() {
        add_shortcode( 'donors-table', array( 'Inc\Base\CustomShortcode', 'donorsTableShortcode' ) );
        add_shortcode( 'add-donor', array( 'Inc\Base\CustomShortcode', 'addDonorShortcode' ) );
        add_shortcode( 'update-donor', array( 'Inc\Base\CustomShortcode', 'updateDonorShortcode' ) );
        add_shortcode( 'donations-table', array( 'Inc\Base\CustomShortcode', 'donationsTableShortcode' ) );
        add_shortcode( 'add-donation', array( 'Inc\Base\CustomShortcode', 'addDonationsShortcode' ) );
        add_shortcode( 'update-donation', array( 'Inc\Base\CustomShortcode', 'updateDonationsShortcode' ) );
    }

    static function donorsTableShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/donors-table.php';
    }

    static function addDonorShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/add-donor.php';
    }

    static function updateDonorShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/update-donor.php';
    }

    static function donationsTableShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/donations-table.php';
    }

    static function addDonationsShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/add-donation.php';
    }

    static function updateDonationsShortcode() {
        include BD_PLUGIN_PATH . 'templates/shortcodes/update-donation.php';
    }
}