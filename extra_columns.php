<?php
/* -- You can change custom post_type to page, product, course etc. -- */

$post_type = "website";
add_filter('manage_'.$post_type.'_posts_columns', function($columns) {
    return array_merge($columns, [
        "amount" => __("amount", "textdomain"),
        "start_date" => __("start_date", "textdomain"),
        "end_date" => __("end_date", "textdomain"),
    ]);
});
add_action('manage_'.$post_type.'_posts_custom_column', function($column_key, $post_id) {
    if ($column_key == "amount") {
        echo get_post_meta($post_id, "amount", true);
    }
    if ($column_key == "start_date") {
        echo get_post_meta($post_id, "start_date", true);
    }
    if ($column_key == "end_date") {
        echo get_post_meta($post_id, "end_date", true);
    }
}, 10, 2);

?>
<?php
/* Powered By Haysky Code Generator: KEY
[["text","amount"],["date","start_date"],["date","end_date"],["submit","Extra Post Columns"]]
*/
?>