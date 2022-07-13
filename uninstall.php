<?php

/**
 * Trigger this file on plugin uninstall
 * 
 * @package BloodDonPlugin
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Clear database method 1
// $books = get_posts( array( 'post_type' => 'books', 'numberposts' => -1 ) ); 

// foreach ( $books as $book ) {
//     wp_delete_post( $book->ID, true ); 
// }

// Clear database method 2 (SQL)

global $wpdb;
//$wpdb->query( "DELETE FROM wp-posts WHERE post_type = 'book'" );
//$wpdb->query( "DELETE FROM wp_postsmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
//$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM " .$wpdb->prefix. "posts WHERE post_type = 'book'" );
$wpdb->query( "DELETE FROM " .$wpdb->prefix. "postsmeta WHERE post_id NOT IN (SELECT id FROM " .$wpdb->prefix. "posts)" );
$wpdb->query( "DELETE FROM " .$wpdb->prefix. "term_relationships WHERE object_id NOT IN (SELECT id FROM " .$wpdb->prefix. "posts)" );