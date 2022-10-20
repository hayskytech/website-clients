<?php
add_action( "add_meta_boxes",function(){
	add_meta_box(
	    "diwp-post-read-timer",
	    "Post Meta Fields", 
// Creates Metabox Callback Function
function(){
    global $post;
    wp_enqueue_script("jquery");
    $meta = get_post_meta($post->ID);
    $data["amount"] = $meta["amount"][0];
    $data["start_date"] = $meta["start_date"][0];
    $data["end_date"] = $meta["end_date"][0];
    ?>
    <table>
        <tr>
            <td>Amount</td>
            <td><input type="text" name="amount">
            </td>
        </tr>
        <tr>
            <td>Start Date</td>
            <td><input type="date" name="start_date">
            </td>
        </tr>
        <tr>
            <td>End Date</td>
            <td><input type="date" name="end_date">
            </td>
        </tr>
	</table>
    <script type="text/javascript">
        jQuery('input[name=amount]').val('<?php echo $data["amount"]; ?>');
        jQuery('input[name=start_date]').val('<?php echo $data["start_date"]; ?>');
        jQuery('input[name=end_date]').val('<?php echo $data["end_date"]; ?>');
    </script>
	<?php
},
	    "website",
	    "side",
	    "high"
	);
});

add_action( "save_post",function(){
    if("website" == $_POST["post_type"]){
        global $post;
        update_post_meta($post->ID, "amount", $_POST["amount"]);
        update_post_meta($post->ID, "start_date", $_POST["start_date"]);
        update_post_meta($post->ID, "end_date", $_POST["end_date"]);
    }
});
?>