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

use Inc\Activate;
use Inc\Deactivate;

if ( !class_exists( 'BloodDonPlugin' ) ) {
    class BloodDonPlugin
    {
        static $PLUGIN_NAME;
    
        function __construct() {
            $this->PLUGIN_NAME = plugin_basename( __FILE__ );
        }
    
        function register_admin() {
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    
            add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
    
            add_filter( "plugin_action_links_$this->PLUGIN_NAME", array( $this, 'settings_link' ) );
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
            require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
        }
    
        function enqueue(){
            wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/mystyle.css', __FILE__ ) );
            wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/myscript.js', __FILE__ ) );
        }
    }
    
    $bloodDonPlugin = new BloodDonPlugin();
    $bloodDonPlugin->register_admin();
    
    register_activation_hook( __FILE__, array( 'Inc\Activate', 'activate' ) );
    
    register_deactivation_hook( __FILE__, array( 'Inc\Deactivate', 'deactivate' ) );
}
