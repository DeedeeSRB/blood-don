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
}