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

add_action( "init",function(){
	// Set labels for website
	$labels = array(
		"name" => "Websites",
		"singular_name" => "Website",
		"add_new"	=> "Add Website",
		"add_new_item" => "Add New Website",
		"all_items" => "All Websites",
		"edit_item" => "Edit Website",
		"new_item" => "New Website",
		"view_item" => "View Website",
		"search_items" => "Search Websites",
	);
	// Set Options for website
	$args = array(	
		"public" => true,
		"label"		 => "Websites",
		"labels"		=> $labels,
		"description" => "Websites custom post type.",
		"menu_icon"		=> "dashicons-admin-site-alt3",	
		"supports"	 => array( "title", "editor", "thumbnail"),
		"capability_type" => "post",
		"publicly_queryable"	=> true,
		"exclude_from_search" => false
	);
	register_post_type("website", $args);
	
});

include 'extra_columns.php';
include 'meta_boxes.php';
include 'quick_edit_fields.php';

add_shortcode('website_portfolio',function(){ include 'portfolio.php'; });