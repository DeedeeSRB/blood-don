<?php


if( !is_user_logged_in() ) {
    wp_safe_redirect( 'http://localhost/wordpress/login' );
    exit;
}


?>