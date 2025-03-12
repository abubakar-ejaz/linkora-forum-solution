<?php
add_action( 'add_meta_boxes_post', 'disputo_rating_system_add_post_meta_boxes' );
add_action( 'save_post', 'disputo_meta_box_saving', 10, 2 );

function disputo_rating_system_add_post_meta_boxes() {
    add_meta_box(
        'disputo-ra-custom-meta-box',
        esc_html__( 'Rating System', 'disputo' ),
        'rating_system_post_class_meta_box',
        'post',
        'side',
        'default'
    );
}

function rating_system_post_class_meta_box($object, $box){
	
	$likes   = get_post_meta($object->ID, 'disputo_system_likes', true);
	if(empty($likes)){
		$likes = 0;
	}

	$dislikes   = get_post_meta($object->ID, 'disputo_system_dislikes', true);
	if(empty($dislikes)){
		$dislikes = 0;
	}
	
	wp_nonce_field( basename( __FILE__ ), 'disputo_system_metabox_nonce' );
	
	?><div style="line-height:22px">
		<table width="100%">
			<tr>
				<td width="50%" align="center">
					<span style="margin-top:6px;" class="dashicons dashicons-thumbs-up"></span>
					<b>&nbsp;<input min="0" name="disputo_meta_likes" type="number" style="width:55px;" value="<?php echo esc_attr($likes); ?>"/></b>
				</td>
				<td width="50%" align="center">
					<span style="margin-top:6px;" class="dashicons dashicons-thumbs-down"></span>
					<b>&nbsp;<input min="0" name="disputo_meta_dislikes" type="number" style="width:55px;" value="<?php echo esc_attr($dislikes); ?>"/></b>
				</td>
			</tr>
		</table>
	</div>
<?php	
}

function disputo_meta_box_saving($post_id, $post){
	
	if ( !isset( $_POST['disputo_system_metabox_nonce'] ) || !wp_verify_nonce( $_POST['disputo_system_metabox_nonce'], basename( __FILE__ ) ) )
		return $post_id;
    
	$post_type = get_post_type_object( $post->post_type );

	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
	
	if(isset($_POST['disputo_meta_likes']) && isset($_POST['disputo_meta_dislikes'])){
		
		$likes = absint($_POST['disputo_meta_likes']);
		$dislikes = absint($_POST['disputo_meta_dislikes']);
		$ml = 'disputo_system_likes';
		$md = 'disputo_system_dislikes';
		
		update_post_meta($post_id,$ml,$likes);
		update_post_meta($post_id,$md,$dislikes);
	}
}
?>