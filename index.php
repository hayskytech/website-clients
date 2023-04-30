<?php
/**
 * Plugin Name: Website Clients
 * Plugin URI: https://haysky.com/
 * Description: List of hosting customers. Client website name, hosting plan price, start and end dates. Add custom REST API for Haysky Portfolio.
 * Version: 1.1.0
 * Author: Haysky
 * Author URI: https://haysky.com/
 * License: GPLv2 or later
 */
//$wpdb->show_errors(); $wpdb->print_error();

add_shortcode('website_portfolio',function(){ include 'portfolio.php'; });

add_action('admin_menu' , function(){
    add_menu_page('Hs Hostings','Hs Hostings','manage_options', 'hs_hostings', 'hs_hostings_tah', 'dashicons-admin-users','2');
});

function hs_hostings_tah(){ include 'hostings_new.php'; }

add_shortcode('website_poster',function($args){ include 'website_poster.php'; });