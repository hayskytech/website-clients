<?php
/**
 * Plugin Name: Web Hosting Clients
 * Plugin URI: https://haysky.com/
 * Description: List of hosting customers. Client website name, hosting plan price, start and end dates. Add custom REST API for Haysky Portfolio.
 * Version: 1.1.0
 * Author: Haysky
 * Author URI: https://haysky.com/
 * License: GPLv2 or later
 */
//$wpdb->show_errors(); $wpdb->print_error();

add_action('admin_menu' , function(){
	add_menu_page('Hostings','Hostings','manage_options','hs_hostings','hs_hostings','dashicons-admin-users','2');
});

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
// include 'meta_boxes.php';
// include 'quick_edit_fields.php';

add_action( "quick_edit_custom_box",	"website_quick_edit_fields0", 10, 2 );
function website_quick_edit_fields0( $column_name, $post_type ) {
	if($post_type=="website"){
		?>
			<tr>
				<td><?php echo $column_name; ?></td>
				<td><input type="text" name="<?php echo $column_name; ?>" >
				</td>
			</tr>
		<?php
	}
}

function hs_hostings(){
	include (dirname(__FILE__).'/hostings_new.php');
}
add_shortcode('website_portfolio',function(){ include 'portfolio.php'; });