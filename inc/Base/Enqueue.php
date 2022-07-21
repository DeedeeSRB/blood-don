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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue() 
	{
		wp_enqueue_style( 'mypluginstyle', BD_PLUGIN_URL . 'assets/mystyles.min.css' );
		wp_enqueue_script( 'mypluginscript', BD_PLUGIN_URL . 'assets/myscript.min.js' );

		//wp_enqueue_style( 'bootstrapstyle', BD_PLUGIN_URL . 'assets/bootstrap/css/bootstrap.min.css' );
		//wp_enqueue_script( 'bootstrapscript', BD_PLUGIN_URL . 'assets/bootstrap/js/bootstrap.min.js' );

		wp_localize_script( 'mypluginscript', 'admin_url_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
}