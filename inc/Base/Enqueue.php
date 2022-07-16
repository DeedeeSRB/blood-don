<?php 
/**
 * @package  BloodDonPlugin
 */
namespace Inc\Base;

class Enqueue
{
	public function register() 
	{
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue() 
	{
		wp_enqueue_style( 'mypluginstyle', BD_PLUGIN_URL . 'assets/mystyles.min.css' );
		wp_enqueue_script( 'mypluginscript', BD_PLUGIN_URL . 'assets/myscript.min.js' );
	}
}