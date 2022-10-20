<?php
// quick_edit_custom_box allows to add HTML in Quick Edit
add_action( 'quick_edit_custom_box',  'website_quick_edit_fields', 10, 2 );

function website_quick_edit_fields( $column_name, $post_type ) {
	if($post_type=='website'){
		switch( $column_name ) {
			case 'amount': {
				?>
				<fieldset class="inline-edit-col-left">
					<div class="inline-edit-col">
						<label>
							<span class="title">Amount</span>
							<input type="text" name="amount">
						</label>
					</div>
				</fieldset>
				<?php
				break;
			}
			case 'end_date': {
				?>
					<fieldset class="inline-edit-col-left">
						<div class="inline-edit-col">
							<label>
								<span class="title">End Date</span>
								<input type="date" name="end_date">
							</label>
						</div>
					</fieldset>
					<?php
				break;
			}
			case 'start_date': {
				?>
				<fieldset class="inline-edit-col-left">
					<div class="inline-edit-col">
						<label>
							<span class="title">Start Date</span>
							<input type="date" name="start_date">
						</label>
					</div>
				</fieldset>
				<?php
				break;
			}
		}
	}
}

// save fields after quick edit
add_action( 'save_post', function( $post_id ){

	// check inlint edit nonce
	if ( ! wp_verify_nonce( $_POST[ '_inline_edit' ], 'inlineeditnonce' ) ) {
		return;
	}
	if (get_post_type( $post_id ) == 'website') {
	 	update_post_meta( $post_id, 'start_date', $_POST["start_date"] );
	 	update_post_meta( $post_id, 'end_date', $_POST["end_date"] );
	 	update_post_meta( $post_id, 'amount', $_POST["amount"] );
	}

});

add_action('admin_footer',function(){
	if (isset($_GET["post_type"])) {
		if ($_GET["post_type"]=='website') {
			?>
			<script type="text/javascript">
				jQuery( function( $ ){

					const wp_inline_edit_function = inlineEditPost.edit;

					// we overwrite the it with our own
					inlineEditPost.edit = function( post_id ) {

						// let's merge arguments of the original function
						wp_inline_edit_function.apply( this, arguments );

						// get the post ID from the argument
						if ( typeof( post_id ) == 'object' ) { // if it is object, get the ID number
							post_id = parseInt( this.getId( post_id ) );
						}

						// add rows to variables
						const edit_row = $( '#edit-' + post_id )
						const post_row = $( '#post-' + post_id )

						const start_date = $( '.column-start_date', post_row ).text()
						const end_date = $( '.column-end_date', post_row ).text()
						const amount = $( '.column-amount', post_row ).text()

						// populate the inputs with column data
						$( ':input[name="start_date"]', edit_row ).val( start_date );
						$( ':input[name="end_date"]', edit_row ).val( end_date );
						$( ':input[name="amount"]', edit_row ).val( amount );
						
					}
				});
			</script>
			<?php
		}
	}
});