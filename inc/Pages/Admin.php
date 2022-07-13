<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Pages;

class Admin
{
	public function register() {
        $this->PLUGIN_NAME = plugin_basename( __FILE__ );

		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
        
        add_filter( 'plugin_action_links_'.PLUGIN_NAME, array( $this, 'settings_link' ) );
	}

    function settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=blood_donation_plugin">Settings</a>';
        array_push( $links, $settings_link);
        return $links;
    }

	function add_admin_page() {
        add_menu_page( 'Blood Donation Plugin', 'Blood Donations', 'manage_options', 'blood_donation_plugin',
            array( $this, 'admin_index'), 'dashicons-heart', 110 );
    }

    function admin_index() {
		require_once PLUGIN_PATH . 'templates/admin.php';
	}
}