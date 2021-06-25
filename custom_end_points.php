<?php
function our_websites( WP_REST_Request $request ){
	global $wpdb;
	$result = $wpdb->get_results("SELECT portfolio,domain,start_date,info FROM hostings WHERE portfolio != ''");
	return $result;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'haysky/v1', '/portfolio/', array(
    'methods' => 'GET',
    'callback' => 'our_websites',
  ) );

} );

?>