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

		add_action('wp_head', array( $this, 'add_js_css' ) );
		add_action('admin_head', array( $this, 'add_js_css_admin' ) );
	}
	
	function enqueue() 
	{
		wp_enqueue_style( 'mypluginstyle', BD_PLUGIN_URL . 'assets/mystyles.min.css' );
		wp_enqueue_script( 'mypluginscript', BD_PLUGIN_URL . 'assets/myscript.min.js' );

		//wp_enqueue_style( 'bootstrapstyle', BD_PLUGIN_URL . 'assets/bootstrap/css/bootstrap.min.css' );
		//wp_enqueue_script( 'bootstrapscript', BD_PLUGIN_URL . 'assets/bootstrap/js/bootstrap.min.js' );

		wp_localize_script( 'mypluginscript', 'admin_url_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	function add_js_css_admin()
	{	
		if ( $_REQUEST['page'] == 'blood_donation_plugin' ) { 
			?>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
				<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
				
				<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

				<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
				<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
			<?php
		}	
	}

	function add_js_css()
	{	
		?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
			
			<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

			<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
			<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<?php
	}
}