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

add_option( 'donations_db_version', 2 );
//update_option( 'donations_db_version', 1 );
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}

register_activation_hook( __FILE__, array( 'Inc\Base\Activate', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Inc\Base\Deactivate', 'deactivate' ) );

