<?php
/*
Plugin Name: Haysky Hosting
*/
//$wpdb->show_errors(); $wpdb->print_error();
date_default_timezone_set('Asia/Kolkata');
add_filter( 'register_url', 'custom_register_url' );
function custom_register_url( $register_url )
{
    $register_url = '/register';//get_permalink( $register_page_id = [REPLACE WITH YOUR PAGE ID HERE] );
    return $register_url;
}

add_action( 'init', 'wpabsolute_block_users_backend' );
function wpabsolute_block_users_backend() {
    if ( is_admin() && ! current_user_can( 'administrator' ) && is_user_logged_in() && ! wp_doing_ajax() ) {
        wp_redirect( home_url().'/account' );
        exit;
    }
    if($_GET["logout"]=='yes'){
        wp_logout();
        $url = '/account';
        if ( wp_redirect( $url ) ) {
            exit;
        }
    }
}

add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}

include (dirname(__FILE__).'/custom_end_points.php');

function hosting_admin_menu(){
    add_menu_page('Hostings','Hostings','manage_options','hs_hostings','hs_hostings','dashicons-admin-users','2');
}
add_action('admin_menu' , 'hosting_admin_menu');

function hs_hostings(){
	include (dirname(__FILE__).'/hostings_new.php');
}

function haysky_portfolio(){
    include (dirname(__FILE__).'/portfolio.php');
    return $result;
}
add_shortcode('haysky_portfolio','haysky_portfolio');

// add_action('admin_footer','add_notification_admin');


function htk_header_css(){
    ?>
    <style type="text/css">
        .login_user_menu, .logout_user_menu{ display: none !important; }
    <?php
    if (is_user_logged_in()) {
        ?>
        .login_user_menu{ display: block !important; }
        <?php
    } else {
        ?>
        .logout_user_menu{ display: block !important; }
        <?php
    }
    ?>
    </style>
    <?php
}
add_action('wp_head','htk_header_css');
