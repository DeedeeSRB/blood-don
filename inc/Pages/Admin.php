<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Pages;

class Admin
{
	public function register() {
		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
	}

	function add_admin_page() {
        add_menu_page( 'Blood Donation Plugin', 'Blood Donations', 'manage_options', 'blood_donation_plugin',
            array( $this, 'admin_index'), 'dashicons-heart', 110 );
    }

    function admin_index() {
		require_once PLUGIN_PATH . 'templates/admin.php';
	}
}