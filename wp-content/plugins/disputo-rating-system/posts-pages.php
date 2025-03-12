<?php
$disputo_like_dislike = get_option("disputo_like_dislike");

if(!empty($disputo_like_dislike)){
    add_action( 'wp_ajax_nopriv_disputo_system_like_button', 'disputo_system_like_button' );
    add_action( 'wp_ajax_disputo_system_like_button', 'disputo_system_like_button' );
    
    function disputo_system_like_button() {
        $nonce = $_POST['nonce'];
        if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ){
            wp_die();
        }
        if(!is_user_logged_in()){
            exit();
        }
        $post_id = absint($_POST['post_id']);
        $likes = 'disputo_system_likes';
        $dislikes = 'disputo_system_dislikes';
        if(is_user_logged_in()){
            $current_user_id = get_current_user_id();
            $user_key = 'disputo_system_user_'.$current_user_id;
        } else { 
            wp_die();
        }
        $user_data = array(
            'liked' => 'liked',
            'disliked' => 'disliked'
        );
        $shall_we = apply_filters("disputo_one_vote",false);
        if(get_post_meta ($post_id,$user_key,true) == ''){
            add_post_meta($post_id, $user_key, $user_data,true);
        } elseif($shall_we && !(get_post_meta ($post_id,$user_key,true) == '')){
            $response = array(
                'likes' => "exit",
            );
            echo json_encode($response);
            exit();
        }
        $user_data_new = array(
            'liked' => 'noliked',
            'disliked' => 'disliked',
        );
        $current_user = get_post_meta($post_id,$user_key,true);
        $disliked_value = $current_user['disliked'];
        $current_user_liked = $current_user['liked'];
        $login_number = apply_filters('disputo_login_number',1);
        $logout_number = apply_filters('disputo_logout_number',1);
        
        if($current_user_liked == 'liked' && $disliked_value == 'nodisliked'){
            $current_likes = get_post_meta($post_id,$likes,true);
            if(!is_user_logged_in()){
                $current_likes += $logout_number;
            } else {
                $current_likes += $login_number;
            }
            update_post_meta($post_id,$likes,$current_likes);
            $current_dislikes = get_post_meta($post_id,$dislikes,true);
            if(!is_user_logged_in()){
                $current_dislikes -= $logout_number;
            } else {
                $current_dislikes -= $login_number;
            }
            update_post_meta($post_id,$dislikes,$current_dislikes);
            update_post_meta($post_id,$user_key,$user_data_new);
            do_action("disputo_post_dislike",'+likes','-dislikes',$current_user_id,$post_id);
            $response = array(
                'dislikes' => $current_dislikes,
                'likes'	   => $current_likes,
                'both'	   => 'yes',
                'title'	   => esc_html(get_the_title($post_id)),
                'url'	   => esc_url(get_permalink($post_id)),
                'id'	   => $post_id
            );
            echo json_encode($response);
            exit();
        } elseif($current_user_liked == 'liked'){
            $current_likes = get_post_meta($post_id,$likes,true);
            if(!is_user_logged_in()){
                $current_likes += $logout_number;
            } else {
                $current_likes += $login_number;
            }
            update_post_meta($post_id,$likes,$current_likes);
            update_post_meta($post_id,$user_key,$user_data_new);
            do_action("disputo_post_dislike",'+likes','nothing',$current_user_id,$post_id);
        } elseif($current_user_liked == 'noliked' ){
            $current_likes = get_post_meta($post_id,$likes,true);
            if(!is_user_logged_in()){
                $current_likes -= $logout_number;
            } else {
                $current_likes -= $login_number;
            }
            update_post_meta($post_id,$likes,$current_likes);
            update_post_meta($post_id,$user_key,$user_data);
            do_action("disputo_post_dislike",'-likes','nothing',$current_user_id,$post_id);
            $response = array(
                'likes' => $current_likes,
                'both' => 'no',
                'title'	=> esc_html(get_the_title($post_id)),
                'url' => esc_url(get_permalink($post_id)),
                'id' => $post_id
            );
            echo json_encode($response);
            wp_die();
        }
        $response = array(
            'likes' => $current_likes,
            'both' => 'no',
            'title' => esc_html(get_the_title($post_id)),
            'url' => esc_url(get_permalink($post_id)),
            'id' => $post_id
        );
        echo json_encode($response);
        wp_die();
    }
    
    if($disputo_like_dislike['v-switch-dislike'] != 'off') {
		add_action( 'wp_ajax_nopriv_disputo_system_dislike_button', 'disputo_system_dislike_button' );
		add_action( 'wp_ajax_disputo_system_dislike_button', 'disputo_system_dislike_button' );
		function disputo_system_dislike_button() {
            $nonce = $_POST['nonce'];
            if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ){
                wp_die();
            }
            if(!is_user_logged_in()){
                exit();
            }
            $post_id = absint($_POST['post_id']);
            $likes = 'disputo_system_likes';
            $dislikes = 'disputo_system_dislikes';
            $current_user_id = null;
            if(is_user_logged_in()){
                $current_user_id = get_current_user_id();
				$user_key = 'disputo_system_user_'.$current_user_id;	
				} else { 
                wp_die(); 
            }
            $user_data = array(
                'liked' => 'liked',
                'disliked' => 'disliked'
            );
				
            $shall_we = apply_filters("disputo_one_vote",false);
            if(get_post_meta ($post_id,$user_key,true) == '') {
                add_post_meta($post_id, $user_key, $user_data,true);
            } elseif($shall_we && !(get_post_meta ($post_id,$user_key,true) == '')){
                $response = array(
                    'dislikes'	   => "exit",
                );
                echo json_encode($response);
                exit();
            }
            $user_data_new = array(
                'liked' => 'liked',
                'disliked' => 'nodisliked',
            );
            $current_user = get_post_meta($post_id,$user_key,true);
            $current_user_disliked = $current_user['disliked'];
            $liked_value = $current_user['liked'];
            $login_number = apply_filters('disputo_login_number',1);
            $logout_number = apply_filters('disputo_logout_number',1);
            if($current_user_disliked == 'disliked' && $liked_value == 'noliked'){
                $current_likes = get_post_meta($post_id,$likes,true);
                if(!is_user_logged_in()){
                    $current_likes -= $logout_number;
                } else {
                    $current_likes -= $login_number;
                }
                update_post_meta($post_id,$likes,$current_likes);
                $current_dislikes = get_post_meta($post_id,$dislikes,true);
                if(!is_user_logged_in()){
                    $current_dislikes += $logout_number;
                } else {
                    $current_dislikes += $login_number;
                }
                update_post_meta($post_id,$dislikes,$current_dislikes);
                update_post_meta($post_id,$user_key,$user_data_new);
                do_action("disputo_post_dislike",'-likes','+dislikes',$current_user_id,$post_id);
                $response = array(
                    'dislikes' => $current_dislikes,
                    'likes'	   => $current_likes,
                    'both'	   => 'yes',
                    'title'	   => esc_html(get_the_title($post_id)),
                    'url'	   => esc_url(get_permalink($post_id)),
                    'id'	   => $post_id
                );
                echo json_encode($response);
                exit();
            } elseif($current_user_disliked == 'disliked') {
                $current_dislikes = get_post_meta($post_id,$dislikes,true);
                if(!is_user_logged_in()){
					$current_dislikes += $logout_number;
                } else {
                    $current_dislikes += $login_number;
                }
                update_post_meta($post_id,$dislikes,$current_dislikes);
                update_post_meta($post_id,$user_key,$user_data_new);
                do_action("disputo_post_dislike",'nothing','+dislikes',$current_user_id,$post_id);
            } elseif($current_user_disliked == 'nodisliked') {
                $current_dislikes = get_post_meta($post_id,$dislikes,true);
                if(!is_user_logged_in()){
					$current_dislikes -= $logout_number;
                } else {
                    $current_dislikes -= $login_number;
                }
                update_post_meta($post_id,$dislikes,$current_dislikes);
                do_action("disputo_post_dislike",'nothing','-dislikes',$current_user_id,$post_id);
                update_post_meta($post_id,$user_key,$user_data);
                $response = array(
                    'dislikes' => $current_dislikes,
                    'both' => 'no',
                    'title' => esc_html(get_the_title($post_id)),
                    'url' => esc_url(get_permalink($post_id)),
                    'id' => $post_id
                );
                echo json_encode($response);
                wp_die();
            }
            $response = array(
                'dislikes' => $current_dislikes,
                'both'   => 'no',
                'title'	   => esc_html(get_the_title($post_id)),
                'url'	   => esc_url(get_permalink($post_id)),
                'id'	   => $post_id
            );
            echo json_encode($response);
            wp_die();
        }
    }
    
    function disputo_system_add_dislike_class(){
        if(function_exists('bbp_get_reply_id')){
            if(bbp_get_reply_id() != null){
				$id = bbp_get_reply_id();
            } else {
                $id = get_the_ID();
            }
        } else {
            $id = get_the_ID();
        }
        if(is_user_logged_in()) {
            $current_user_id = get_current_user_id();
            $user_key = 'disputo_system_user_'.$current_user_id;
            $current_user_disliked = '';
            if(!get_post_meta($id,$user_key,true) == ''){
                $current_user = get_post_meta($id,$user_key,true);
                $current_user_disliked = $current_user['disliked'];
            }
            if($current_user_disliked == 'nodisliked'){
                return 'disputo-p-dislike-active';
            }
        }
    }

    function disputo_system_add_like_class(){
        if(function_exists('bbp_get_reply_id')){
            if(bbp_get_reply_id() != null){
                $id = bbp_get_reply_id();
            } else {
				$id = get_the_ID();
            }
        } else {
            $id = get_the_ID();
        }
        if(is_user_logged_in()) {
            $current_user_id = get_current_user_id();
            $user_key = 'disputo_system_user_'.$current_user_id;
            $current_user_liked = '';
            if(!get_post_meta($id,$user_key,true) == ''){
                $current_user = get_post_meta($id,$user_key,true);
                $current_user_liked = $current_user['liked'];
            }
            if($current_user_liked == 'noliked'){
                return 'disputo-p-like-active';
            }
        }
    }

    function disputo_system_get_total_likes(){
        if(function_exists('bbp_get_reply_id')){
            if(bbp_get_reply_id() != null){
                $id = bbp_get_reply_id();
            } else {
                $id = get_the_ID();
            }
        } else {
            $id = get_the_ID();
        }
        $likes = get_post_meta($id,'disputo_system_likes',true);
        if(empty($likes)) {
            return 0;
        } elseif(!$likes == '') {
            return $dislikes = get_post_meta($id,'disputo_system_likes',true);
        }
    }
    
    function disputo_system_get_total_dislikes(){
        if(function_exists('bbp_get_reply_id')){
            if(bbp_get_reply_id() != null){
                $id = bbp_get_reply_id();
            } else {
                $id = get_the_ID();
            }
        } else {
            $id = get_the_ID();
        }
        $dislikes = get_post_meta($id,'disputo_system_dislikes',true);
        if(empty($dislikes)){
            return 0;
        } elseif(!$dislikes == '') {
            return $dislikes = get_post_meta($id,'disputo_system_dislikes',true);
        }
    }
    
    function disputo_get_like_count() {
        global $wpdb;  
        $count = $wpdb->get_var( "SELECT SUM(meta_value) FROM $wpdb->postmeta WHERE meta_key = 'disputo_system_likes'");	
        return $count;
    }
    
    function disputo_get_dislike_count() {
        global $wpdb;  
        $count = $wpdb->get_var( "SELECT SUM(meta_value) FROM $wpdb->postmeta WHERE meta_key = 'disputo_system_dislikes'");	
        return $count;
    }
		
    function disputo_system_get_like_icon(){
        $disputo_like_dislike = get_option("disputo_like_dislike");
        if($disputo_like_dislike['v_button_style'] == '1'){
            return 'icon-thumbs-up-1';
        } elseif($disputo_like_dislike['v_button_style'] == '2'){
            return 'icon-thumbs-up-alt';
        } elseif($disputo_like_dislike['v_button_style'] == '3'){
            return 'icon-thumbs-up';
        } elseif($disputo_like_dislike['v_button_style'] == '4'){
            return 'icon-thumbs-up-3';
        } elseif($disputo_like_dislike['v_button_style'] == '5'){
            return 'icon-thumbs-up-4';
        } elseif($disputo_like_dislike['v_button_style'] == '6'){
            return 'icon-thumbs-up-2';
        } elseif($disputo_like_dislike['v_button_style'] == '7'){
            return 'icon-plus-circled';
        } elseif($disputo_like_dislike['v_button_style'] == '8'){
            return 'icon-plus';
        } elseif($disputo_like_dislike['v_button_style'] == '9'){
            return 'icon-up';
        } elseif($disputo_like_dislike['v_button_style'] == '10'){
            return 'icon-up-big';
        } elseif($disputo_like_dislike['v_button_style'] == '11'){
            return 'icon-heart';
        } elseif($disputo_like_dislike['v_button_style'] == '12'){
            return 'icon-star';
        } elseif($disputo_like_dislike['v_button_style'] == '13'){
            return 'icon-ok-circle';
        } elseif($disputo_like_dislike['v_button_style'] == '14'){
            return 'icon-ok';
        }
    }
		
    function disputo_system_get_dislike_icon(){
        $disputo_like_dislike = get_option("disputo_like_dislike");
		if($disputo_like_dislike['v_button_style'] == '1'){
            return 'icon-thumbs-down-1';
        } elseif($disputo_like_dislike['v_button_style'] == '2'){
            return 'icon-thumbs-down-alt';
        } elseif($disputo_like_dislike['v_button_style'] == '3'){
            return 'icon-thumbs-down';
        } elseif($disputo_like_dislike['v_button_style'] == '4'){
            return 'icon-thumbs-down-3';
        } elseif($disputo_like_dislike['v_button_style'] == '5'){
            return 'icon-thumbs-down-4';
        } elseif($disputo_like_dislike['v_button_style'] == '6'){
            return 'icon-thumbs-down-2';
        } elseif($disputo_like_dislike['v_button_style'] == '7'){
            return 'icon-minus-circled';
        } elseif($disputo_like_dislike['v_button_style'] == '8'){
            return 'icon-minus';
        } elseif($disputo_like_dislike['v_button_style'] == '9'){
            return 'icon-down';
        } elseif($disputo_like_dislike['v_button_style'] == '10'){
            return 'icon-down-big';
        } elseif($disputo_like_dislike['v_button_style'] == '11'){
            return 'icon-heart-broken';
        } elseif($disputo_like_dislike['v_button_style'] == '12'){
            return 'icon-star-empty';
        } elseif($disputo_like_dislike['v_button_style'] == '13'){
            return 'icon-cancel-circle';
        } elseif($disputo_like_dislike['v_button_style'] == '14'){
            return 'icon-cancel';
        }
    }
		
    function disputo_system_dislike_counter(){
        if(function_exists('bbp_get_reply_id')){
            if(bbp_get_reply_id() != null){
				$id = bbp_get_reply_id();
            } else {
                $id = get_the_ID();
            }
        } else {
				$id = get_the_ID();
        }
        $disputo_like_dislike = get_option("disputo_like_dislike");
        return '<span class="disputo-p-dislike-counter '.$id. '">'. disputo_system_get_total_dislikes().'</span>';
    }
		
    function disputo_system_render_dislike_button($counter){
        $dislike_counter = "";
        if($counter){
            $dislike_counter = disputo_system_dislike_counter();
        }
        if(function_exists('bbp_get_reply_id')){
            if(bbp_get_reply_id() != null){
				$id = bbp_get_reply_id();
            } else {
                $id = get_the_ID();
            }
        }else {
            $id = get_the_ID();
        }
        return	'<div class="disputo-container-dislike"><input type="hidden" value="'.$id.'" /><div class="disputo-p-dislike '.$id.' '. disputo_system_add_dislike_class() .' '.disputo_system_get_dislike_icon().'">'.$dislike_counter.'</div></div>';
    }

    function disputo_system_like_counter(){
        if(function_exists('bbp_get_reply_id')){
            if(bbp_get_reply_id() != null){
				$id = bbp_get_reply_id();
            } else {
                $id = get_the_ID();
            }
        } else {
            $id = get_the_ID();
        }
        $disputo_like_dislike = get_option("disputo_like_dislike");
        return 	'<span  class="disputo-p-like-counter '. $id.'">'.disputo_system_get_total_likes().'</span>';
    }
		
    function disputo_render_for_posts($dislike = true , $counter = true){
        $disputo_like_dislike = get_option("disputo_like_dislike");
        $like_counter = "";
        if(function_exists('bbp_get_reply_id')){
            if(bbp_get_reply_id() != null){
                $id = bbp_get_reply_id();
            } else {
                $id = get_the_ID();
            }
        } else {
            $id = get_the_ID();
        }
        if($counter){
            $like_counter = disputo_system_like_counter();
        }
        if($disputo_like_dislike['v-switch-dislike'] != 'off' && $dislike){
            $buttons = '<div class="disputo-container-vote"><div class="disputo-container-vote-inner"><div class="disputo-container-like"><input type="hidden" value="'.$id.'" /><div class="disputo-p-like '.$id.' '.disputo_system_add_like_class().' '.disputo_system_get_like_icon().'">'.$like_counter.'</div></div>'.disputo_system_render_dislike_button($counter).'</div></div>';
            return $buttons;
        } else {
            $buttons = '<div class="disputo-container-vote"><div class="disputo-container-vote-inner"><div class="disputo-container-like"><input type="hidden" value="'.$id.'" /><div class="disputo-p-like '.$id.' '.disputo_system_add_like_class().' '.disputo_system_get_like_icon().'">'.$like_counter.'</div></div></div></div>';
            return $buttons;
        }
    }
			
    function disputo_system_columns( $columns ) {
        $disputo_like_dislike = get_option("disputo_like_dislike");
        $columns['likes'] = '<span class="dashicons dashicons-thumbs-up"></span>';
        if($disputo_like_dislike['v-switch-dislike'] != 'off'){
            $columns['dislikes'] = '<span class="dashicons dashicons-thumbs-down"></span>';
        }
        return $columns;
    }

    function disputo_system_columns_value( $column, $post_id ) {
        global $post;
        switch( $column ) {
            case 'likes' :
                $likes = get_post_meta( $post_id, 'disputo_system_likes', true );
                if ( empty( $likes ) )
                    echo '0';
                else
                    echo $likes;
                break;
            case 'dislikes' :
                $dislikes = get_post_meta( $post_id, 'disputo_system_dislikes', true );
                if ( empty( $dislikes ) )
                    echo '0';
                else
                    echo $dislikes;
                break;
            default :
                break;
        }
    }
    
    function disputo_system_sortable_columns( $columns ) {
        $disputo_like_dislike = get_option("disputo_like_dislike");
        $columns['likes'] = 'likes';
        if($disputo_like_dislike['v-switch-dislike'] != 'off'){
            $columns['dislikes'] = 'dislikes';
        }
        return $columns;
    }
    
    function disputo_ra_custom_columns(){
        $args = array(
		   '_builtin' => false,
		   'public' => true
		);
        
        add_filter( 'manage_edit-post_sortable_columns', 'disputo_system_sortable_columns' );
        add_action( 'manage_post_posts_custom_column', 'disputo_system_columns_value', 10, 2 );
        add_filter( 'manage_edit-post_columns', 'disputo_system_columns' ) ;
           
    }
    add_action('wp_loaded','disputo_ra_custom_columns');
		
        function disputo_system_after_post(){
			$disputo_like_dislike = get_option("disputo_like_dislike");
			if(function_exists('bbp_get_reply_id')){
				if(bbp_get_reply_id() != null){
				$id = bbp_get_reply_id();
				} else {
					$id = get_the_ID();
				}
			} else {
				$id = get_the_ID();
            }
            echo disputo_render_for_posts();
		}
		if(!post_password_required()){
            if((!empty($disputo_like_dislike)) && ($disputo_like_dislike['v_enable_bbpress'] != 'off')) {
				add_action('bbp_theme_after_reply_content','disputo_system_after_post', 99);
                add_action('bbp_theme_after_topic_content','disputo_system_after_post', 99);
            }
		}
    
	function disputo_system_styles_scripts(){
		$disputo_like_dislike = get_option("disputo_like_dislike");	
			if(is_user_logged_in()){
				wp_enqueue_style( 'disputo_like_or_dislike', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
                if ( is_rtl() ) {
                    wp_enqueue_style('disputo_like_or_dislike_rtl', plugin_dir_url( __FILE__ ) . 'assets/css/rtl.css', true, '1.0'); 
                }
				if($disputo_like_dislike['v-switch-dislike'] != 'off'){
					wp_enqueue_script( 'disputo_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array( 'jquery' ), '1.0',true);
					wp_enqueue_script( 'disputo_like_or_dislike_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike.js', array( 'jquery' ), '1.0',true);
					wp_localize_script( 'disputo_like_or_dislike_js', 'disputo_ajax_var', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
				} else {
					wp_enqueue_script( 'disputo_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array( 'jquery' ), '1.0',true);
					wp_enqueue_script( 'disputo_no_dislike_js', plugin_dir_url( __FILE__ ).'assets/js/no-dislike.js', array( 'jquery' ), '1.0',true);
					wp_localize_script( 'disputo_no_dislike_js', 'disputo_ajax_var', array(
						'url' => admin_url( 'admin-ajax.php' ),
						'nonce' => wp_create_nonce( 'ajax-nonce' )
						)
					);
				}
			} else {
				wp_enqueue_style( 'disputo_like_or_dislike', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
				wp_enqueue_script( 'disputo_login_js', plugin_dir_url( __FILE__ ).'assets/js/login.js', array( 'jquery' ), '1.0',true);
				wp_localize_script( 'disputo_login_js', 'disputo_login', array(
					'text' => esc_html__( 'You must be logged in to vote.', 'disputo'),
					)
				);		
			}		
	}
	add_action('wp_enqueue_scripts','disputo_system_styles_scripts');
}
?>