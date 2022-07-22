<?php
/**
 * @package BloodDonPlugin
 */

 /*
 Plugin Name:  Blood Donation Manager Plugin
 Plugin URI: http://localhost/wordpress/plugin
 Description: First attempt to create my own wordpress plugin
 Version: 1.0.0
 Author: Sadik Besata
 Author URI: http://localhost/wordpress
 License: GPLv2 or later 
 Text Domain: blood-don
 
 Blood Donation Manager Plugin is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 2 of the License, or
 any later version.
  
 Blood Donation Manager Plugin is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.
*/

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

define( 'BD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BD_PLUGIN_NAME', plugin_basename( __FILE__ ));

if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}

register_activation_hook( __FILE__, array( 'Inc\Base\Activate', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Inc\Base\Deactivate', 'deactivate' ) );

function add_javascript()
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
add_action('wp_head','add_javascript');
add_action('admin_footer','add_javascript');
