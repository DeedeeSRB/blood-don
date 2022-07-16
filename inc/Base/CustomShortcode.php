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
    }

    static function donorsTableShortcode() {
        include BD_PLUGIN_PATH . 'templates/donors-table.php';
    }

    static function addDonorShortcode() {
        include BD_PLUGIN_PATH . 'templates/add-donor.php';
    }
}