<?php
/* Add column to Users Table called "verified" */
function disputo_add_users_column( $column ) {
    $column['user_id'] =  esc_html__( 'User ID', 'disputo');
    $column['disputo_verified_user'] = '<img src="' . plugin_dir_url( __FILE__ ) . 'images/verified.png" title="' . esc_attr__( 'Verified', 'disputo') . '" />';
    return apply_filters('disputo_verified_col_name',$column);
}
add_filter( 'manage_users_columns', 'disputo_add_users_column', 99 );

/* Add the row value for verified column */
function disputo_add_verified_user_row( $val, $column_name, $user_id ) {    
    $user = get_userdata( $user_id );
	if ( 'user_id' == $column_name ) {
		return $user_id;
    }
    switch ( $column_name ) {
        case 'disputo_verified_user' :
            $is_verified_user = sanitize_text_field(get_user_meta( $user_id , 'disputo_verified_user' ,true ));

            if( $is_verified_user ) {
            	return '<img src="'. apply_filters('disputo_verified_user_img',
            		plugins_url( 'images/active_user.png', __FILE__ )) .'" class="disputo_verified_user" verified="yes" user-id="'. $user_id .'" >';
            }
            else {
            	return '<img src="'. apply_filters('disputo_not_verified_user_img',
            		plugins_url( 'images/inactive_user.png', __FILE__ )).'" class="disputo_verified_user" verified="no" user-id="'. $user_id .'" >';
            }            
            break;
        default:
    }
    
    return; 
}
add_action('manage_users_custom_column',  'disputo_add_verified_user_row', 10, 3);

/* user status description */
function disputo_toggle_verified_user_status() {
    if ( !current_user_can( 'edit_user', $user_id ) ) return false;

    check_ajax_referer( 'disputo_js_script_ajax_nonce', 'disputo_js_script_ajax_nonce' );

	$is_verified_user = sanitize_text_field($_POST["verified"]);
	$user_id = intval($_POST["user_id"]);

	if( $is_verified_user == 'yes' )
    {
		update_user_meta( $user_id, 'disputo_verified_user' , 'yes' );
	} 
	else {
		delete_user_meta( $user_id, 'disputo_verified_user' );
	}

	echo esc_attr__( 'User verified Status Is Changed', 'disputo');
   
}
add_action( 'wp_ajax_disputo_toggle_verified_user_status', 'disputo_toggle_verified_user_status' );

/* Add checkbox option user edit page */
function disputo_add_verified_checkBox_userEditPage( $user ){    
    $user_id = $user->ID;               
    $is_verified_user  = sanitize_text_field(get_user_meta( $user_id, "disputo_verified_user", true ));               
    ?> 
    <table class="form-table">
	    <tr class="user-admin-bar-front-wrap">
			<th scope="row"><?php esc_html_e( 'Verified User', 'disputo'); ?></th>
			<td><fieldset><legend class="screen-reader-text"><span><?php esc_attr_e( 'Verified User', 'disputo'); ?></span></legend>
				<label for="disputo_verified_user">
				<input name="disputo_verified_user" type="checkbox" id="disputo_verified_user" value="yes" <?php if ( $is_verified_user == 'yes' ){ ?> checked="checked"<?php } ?> >
				<?php esc_attr_e( 'Verify this user', 'disputo'); ?></label><br>
				</fieldset>
			</td>
		</tr>		
	</table>   
    <?php    
} 
add_action( 'edit_user_profile', 'disputo_add_verified_checkBox_userEditPage',999 );

/* Save the verified option in the user edit page */
function disputo_save_verified_checkBox_userEditPage( $user_id ){ 	        
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;

	// update this users meta
	if ( isset( $_POST['disputo_verified_user'] ) && sanitize_text_field($_POST['disputo_verified_user']) == "yes" )
    {                     
    	update_user_meta( $user_id, 'disputo_verified_user' , 'yes' );
    }
	else {
	    delete_user_meta( $user_id, 'disputo_verified_user' );
	}                           
} 
add_action( 'edit_user_profile_update', 'disputo_save_verified_checkBox_userEditPage');
?>