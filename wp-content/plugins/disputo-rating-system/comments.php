<?php
$disputo_like_dislike = get_option("disputo_like_dislike");
if((!empty($disputo_like_dislike)) && ($disputo_like_dislike['v-switch-comments'] != 'off')) {
    add_action( 'wp_ajax_nopriv_disputo_system_comment_like_button', 'disputo_system_comment_like_button' );
    add_action( 'wp_ajax_disputo_system_comment_like_button', 'disputo_system_comment_like_button' );
    
    function disputo_system_comment_like_button(){
        $disputo_like_dislike = get_option("disputo_like_dislike");
        $nonce = $_POST['nonce'];
        if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ){
            wp_die();
        }
        if (!is_user_logged_in()){
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
            'liked'    => 'liked',
            'disliked' => 'disliked'
        );
        if(get_comment_meta ($post_id,$user_key,true) == ''){
            add_comment_meta($post_id, $user_key, $user_data,true);
        }
        $user_data_new = array(
            'liked'    => 'noliked',
            'disliked' => 'disliked',
        );
        $current_user = get_comment_meta($post_id,$user_key,true);
        $disliked_value = $current_user['disliked'];
        $current_user_liked = $current_user['liked'];
        if($current_user_liked == 'liked' && $disliked_value == 'nodisliked'){
            $current_likes = get_comment_meta($post_id,$likes,true);
            $current_likes++;
            update_comment_meta($post_id,$likes,$current_likes);
            $current_dislikes = get_comment_meta($post_id,$dislikes,true);
            $current_dislikes--;
            update_comment_meta($post_id,$dislikes,$current_dislikes);
            update_comment_meta($post_id,$user_key,$user_data_new);
            do_action("disputo_com_dislike",'+likes','-dislikes',$current_user_id,$post_id);
            $response = array(
                'dislikes' => $current_dislikes,
                'likes'	   => $current_likes,
                'both'	   => 'yes'
            );
            echo json_encode($response);
            exit();
        } elseif($current_user_liked == 'liked'){
            $current_likes = get_comment_meta($post_id,$likes,true);
            $current_likes++;
            update_comment_meta($post_id,$likes,$current_likes);
            update_comment_meta($post_id,$user_key,$user_data_new);
            do_action("disputo_com_dislike",'+likes','nothing',$current_user_id,$post_id);
        } elseif($current_user_liked == 'noliked'){
            $current_likes = get_comment_meta($post_id,$likes,true);
            $current_likes--;
            update_comment_meta($post_id,$likes,$current_likes);
            update_comment_meta($post_id,$user_key,$user_data);
            do_action("disputo_com_dislike",'-likes','nothing',$current_user_id,$post_id);
            $response = array(
                'likes' => $current_likes,
                'both'   => 'no'
            );
            echo json_encode($response);
            wp_die();
        }
        $response = array(
            'likes' => $current_likes,
            'both'   => 'no'
        );
        echo json_encode($response);
        wp_die();
    }

	if ($disputo_like_dislike['v-switch-dislike'] != 'off'){
        add_action( 'wp_ajax_nopriv_disputo_system_comment_dislike_button', 'disputo_system_comment_dislike_button' );
		add_action( 'wp_ajax_disputo_system_comment_dislike_button', 'disputo_system_comment_dislike_button' );
		function disputo_system_comment_dislike_button() {
            $nonce = $_POST['nonce'];
            if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ){
                wp_die();
            }
            if (!is_user_logged_in()){
                exit();
            }
            $post_id = absint($_POST['post_id']);
            $likes = 'disputo_system_likes';
            $dislikes = 'disputo_system_dislikes';
            if (is_user_logged_in()){
                $current_user_id = get_current_user_id();
				$user_key = 'disputo_system_user_'.$current_user_id;     
				} else { 
                wp_die(); 
            }
            $user_data = array(
                'liked'    => 'liked',
                'disliked' => 'disliked'
            );
            $user_data_new = array(
                'liked'    => 'liked',
                'disliked' => 'nodisliked',
            );
            if(get_comment_meta ($post_id,$user_key,true) == ''){
                add_comment_meta($post_id, $user_key, $user_data,true);
            }
            $current_user = get_comment_meta($post_id,$user_key,true);
            $current_user_disliked = $current_user['disliked'];
            $liked_value = $current_user['liked'];
            if($current_user_disliked == 'disliked' && $liked_value == 'noliked'){
                $current_likes = get_comment_meta($post_id,$likes,true);
                $current_likes--;
                update_comment_meta($post_id,$likes,$current_likes);
                $current_dislikes = get_comment_meta($post_id,$dislikes,true);
				$current_dislikes++;
				update_comment_meta($post_id,$dislikes,$current_dislikes);
                update_comment_meta($post_id,$user_key,$user_data_new);
				do_action("disputo_com_dislike",'-likes','+dislikes',$current_user_id,$post_id);
				$response = array(
                    'dislikes' => $current_dislikes,
                    'likes'	   => $current_likes,
                    'both'	   => 'yes'
                );
                echo json_encode($response);
				exit();
				} elseif($current_user_disliked == 'disliked'){
					$current_dislikes = get_comment_meta($post_id,$dislikes,true);
					$current_dislikes++;
					update_comment_meta($post_id,$dislikes,$current_dislikes);
					update_comment_meta($post_id,$user_key,$user_data_new);
					do_action("disputo_com_dislike",'nothing','+dislikes',$current_user_id,$post_id);
				} elseif($current_user_disliked == 'nodisliked'){
					$current_dislikes = get_comment_meta($post_id,$dislikes,true);
					$current_dislikes--;
					update_comment_meta($post_id,$dislikes,$current_dislikes);
					update_comment_meta($post_id,$user_key,$user_data);
					do_action("disputo_com_dislike",'nothing','-dislikes',$current_user_id,$post_id);
                $response = array(
                    'dislikes' => $current_dislikes,
                    'both'   => 'no'
                );
                echo json_encode($response);
                wp_die();
				}
            $response = array(
                'dislikes' => $current_dislikes,
                'both'   => 'no'
            );
            echo json_encode($response);
            wp_die();
        }
	}
    
    function disputo_system_add_dislike_class_comment(){
        $disputo_like_dislike = get_option("disputo_like_dislike");
        $id = get_comment_ID();
        if (is_user_logged_in()){
            $current_user_id = get_current_user_id();
            $user_key = 'disputo_system_user_'.$current_user_id;
            $current_user_disliked = '';
            if(!get_comment_meta($id,$user_key,true) == ''){
                $current_user = get_comment_meta(get_comment_ID(),$user_key,true);
                $current_user_disliked = $current_user['disliked'];
            }
            if($current_user_disliked == 'nodisliked'){
                return 'disputo-p-dislike-active-comment';
            }
        }
    }
    
    function disputo_system_add_like_class_comment(){
        $disputo_like_dislike = get_option("disputo_like_dislike");
        $id = get_comment_ID();
        if(is_user_logged_in()){
            $current_user_id = get_current_user_id();
            $user_key = 'disputo_system_user_'.$current_user_id;
            $current_user_liked = '';
            if(!get_comment_meta($id,$user_key,true) == ''){
                $current_user = get_comment_meta(get_comment_ID(),$user_key,true);
                $current_user_liked = $current_user['liked'];
            }
            if($current_user_liked == 'noliked'){
                return 'disputo-p-like-active-comment';
            }
        }
    }
    
    function disputo_system_get_total_likes_comment(){
        $likes = get_comment_meta(get_comment_ID(),'disputo_system_likes',true);
        if(empty($likes)){
            return 0;
        } elseif(!$likes == ''){
            return $dislikes = get_comment_meta(get_comment_ID(),'disputo_system_likes',true);
        }
    }

    function disputo_system_get_total_dislikes_comment(){			
        $dislikes = get_comment_meta(get_comment_ID(),'disputo_system_dislikes',true);
        if(empty($dislikes)){
            return 0;
        } elseif(!$dislikes == ''){
            return $dislikes = get_comment_meta(get_comment_ID(),'disputo_system_dislikes',true);
        }
    }
		
    function disputo_system_get_like_icon_comment(){
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
    
    function disputo_system_get_dislike_icon_comment(){
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
	
    function disputo_system_dislike_counter_comment(){
        return '<span class="disputo-p-dislike-counter-comment '.get_comment_ID(). '">'. disputo_system_get_total_dislikes_comment().'</span>';
    }
	
    function disputo_system_render_dislike_button_comment(){
        return	'<div class="disputo-container-dislike-comment"><input type="hidden" value="'.get_comment_ID().'" /><div class="disputo-p-dislike-comment '.get_comment_ID().' '. disputo_system_add_dislike_class_comment() .' '.disputo_system_get_dislike_icon_comment().'">'.disputo_system_dislike_counter_comment().'</div></div>';	
    }
		
    function disputo_system_like_counter_comment(){
        return 	'<span class="disputo-p-like-counter-comment '. get_comment_ID().'">'.disputo_system_get_total_likes_comment().'</span>';
    }
		
    function disputo_render_for_comments($dislike = true){
        $disputo_like_dislike = get_option("disputo_like_dislike");
        if($disputo_like_dislike['v-switch-dislike'] != 'off' && $dislike){
			$buttons = '<div class="disputo-container-vote-comment"><div class="disputo-container-vote-comment-inner"><div class="disputo-container-like-comment"><input type="hidden" value="'.get_comment_ID().'" /><div class="disputo-p-like-comment '.get_comment_ID().' '.disputo_system_add_like_class_comment().' '.disputo_system_get_like_icon_comment().'">'.disputo_system_like_counter_comment().'</div></div>'.disputo_system_render_dislike_button_comment().'</div></div>';
            echo $buttons;
        } else {
            $buttons = '<div class="disputo-container-vote-comment"><div class="disputo-container-vote-comment"><div class="disputo-container-like-comment-inner"><input type="hidden" value="'.get_comment_ID().'" /><div class="disputo-p-like-comment '.get_comment_ID().' '.disputo_system_add_like_class_comment().' '.disputo_system_get_like_icon_comment().'">'.disputo_system_like_counter_comment().'</div></div></div></div>';
            echo $buttons;
        }
    }
		
	function disputo_system_styles_scripts_comments(){
		$disputo_like_dislike = get_option("disputo_like_dislike");
        if(is_user_logged_in()){
            wp_enqueue_style( 'disputo_like_or_dislike', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
            if ( is_rtl() ) {
                wp_enqueue_style('disputo_like_or_dislike_rtl', plugin_dir_url( __FILE__ ) . 'assets/css/rtl.css', true, '1.0'); 
            }
            if($disputo_like_dislike['v-switch-dislike'] != 'off'){
                wp_enqueue_script( 'disputo_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array( 'jquery' ), '1.0',true);
                wp_enqueue_script( 'disputo_like_or_dislike_comment_js', plugin_dir_url( __FILE__ ).'assets/js/like-or-dislike-comments.js', array( 'jquery' ), '1.0',true);
				wp_localize_script( 'disputo_like_or_dislike_comment_js', 'disputo_ajax_comment', array(
                    'url' => admin_url( 'admin-ajax.php' ),
                    'nonce' => wp_create_nonce( 'ajax-nonce' )
                ));
            } else {
                wp_enqueue_script( 'disputo_touchevents', plugin_dir_url( __FILE__ ).'assets/js/toucheventsdetect.js', array( 'jquery' ), '1.0',true);
                wp_enqueue_script( 'disputo_no_dislike_js_comment', plugin_dir_url( __FILE__ ).'assets/js/no-dislike-comments.js', array( 'jquery' ), '1.0',true);
                wp_localize_script( 'disputo_no_dislike_js_comment', 'disputo_ajax_comment', array(
                    'url' => admin_url( 'admin-ajax.php' ),
                    'nonce' => wp_create_nonce( 'ajax-nonce' )
                ));
            }
        } else {
            wp_enqueue_style( 'disputo_like_or_dislike_comment', plugin_dir_url( __FILE__ ).'assets/css/style.css' );
            wp_enqueue_script( 'disputo_login_comment_js', plugin_dir_url( __FILE__ ).'assets/js/login-comments.js', array( 'jquery' ), '1.0',true);
            wp_localize_script( 'disputo_login_comment_js', 'disputo_login_comment', array(
                'text' => esc_html__( 'You must be logged in to vote.', 'disputo'),
            ));
        }
	}
	add_action('wp_enqueue_scripts','disputo_system_styles_scripts_comments');
    add_filter( 'manage_edit-comments_columns', 'disputo_system_columns_comments' ) ;
    
    function disputo_system_columns_comments( $columns ) {
        $disputo_like_dislike = get_option("disputo_like_dislike");
        $columns['likes'] = '<span class="dashicons dashicons-thumbs-up"></span>';
        if($disputo_like_dislike['v-switch-dislike'] != 'off'){
            $columns['dislikes'] = '<span class="dashicons dashicons-thumbs-down"></span>';
        }
        return $columns;
    }
    add_action( 'manage_comments_custom_column', 'disputo_system_columns_value_comments', 10, 2 );

    function disputo_system_columns_value_comments( $column, $comment_ID ) {
        global $post;
        switch( $column ) {
            case 'likes' :
                $likes = get_comment_meta( $comment_ID, 'disputo_system_likes', true );
                if ( empty( $likes ) )
                    echo '0';
                else
                    echo $likes;
                break;
            case 'dislikes' :
                $dislikes = get_comment_meta( $comment_ID, 'disputo_system_dislikes', true );
                if ( empty( $dislikes ) )
                    echo '0';
                else
                    echo $dislikes;
                break;
            default :
                break;
        }
    }
}
?>