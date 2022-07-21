<?php

if( !is_user_logged_in() ) {
    wp_safe_redirect( 'http://localhost/wordpress/register' );
    exit;
}
else {
    wp_logout();
    wp_safe_redirect( 'http://localhost/wordpress/login' );
    exit;
}