<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;

class SettingsLink
{
	public function register() 
	{
		add_filter( 'plugin_action_links_'.BD_PLUGIN_NAME, array( $this, 'settings_link' ) );
	}
	
    function settings_link( $links ) 
	{
        $settings_link = '<a href="admin.php?page=blood_donation_plugin">Settings</a>';
        array_push( $links, $settings_link);
        echo 'test';
        return $links;
    }
}