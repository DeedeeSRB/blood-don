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

class BloodDonPlugin
{
    function __construct(){
        add_action( 'init', array( $this, 'custom_post_type' ) );
    }

    function register_admin_scripts(){
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }

    function register_wp_scripts(){
        add_action( 'wp_enqueue_scripts',array( $this, 'enqueue' ) );
    }

    function activate(){
        $this->custom_post_type();
        flush_rewrite_rules();
    }

    function deactivate(){
        flush_rewrite_rules();
    }

    function custom_post_type(){
        register_post_type( 'book', ['public' => true, 'label' => 'Books' ] );
    }

    function enqueue(){
        wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/mystyle.css', __FILE__ ) );
        wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/myscript.js', __FILE__ ) );
    }
}

if ( class_exists( 'BloodDonPlugin' ) ) {
    $bloodDonPlugin = new BloodDonPlugin();
    $bloodDonPlugin->register_admin_scripts();
}

register_activation_hook( __FILE__, array( $bloodDonPlugin, 'activate' ) );
register_deactivation_hook( __FILE__, array( $bloodDonPlugin, 'deactivate' ) );