<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

/* Register my wall menu item */

function disputo_mywall_menu_item() {
    if (is_user_logged_in()) {
        echo '<a class="dropdown-item" href="' . esc_url(bbp_get_user_profile_url(get_current_user_id())) . 'my-wall">' . esc_html__('My Wall', 'disputo') . '</a>';
    }
}

add_action ('disputo_mywall_link', 'disputo_mywall_menu_item');

/* Register my wall tab */

function disputo_register_wall_tab() {
    $disputo_enable_follow_user = get_theme_mod('disputo_bbpress_follow_user');
    if ($disputo_enable_follow_user) {
    return \bbPressProfileTabs::create(
        [
            'slug' => 'my-wall',
            'menu-item-text' => esc_html__( 'My Wall', 'disputo'),
            'menu-item-position' => 1,
            'visibility' => 'profile-owner'
        ]
    );
    }
}
add_action('plugins_loaded', 'disputo_register_wall_tab');

add_action( "BPT_content-my-wall", function() {
    echo do_shortcode('[bbpresswall]');
});

//ajax callbacks for following user
add_action( 'wp_ajax_bbpf_follow', 'bbpf_follow_ajax_callback' );
add_action( 'wp_ajax_nopriv_bbpf_follow', 'bbpf_follow_ajax_callback');

//ajax callbacks for unfollowing user
add_action( 'wp_ajax_bbpf_unfollow', 'bbpf_unfollow_ajax_callback' );
add_action( 'wp_ajax_nopriv_bbpf_unfollow', 'bbpf_unfollow_ajax_callback');

////ajax callbacks for loading the following list
add_action( 'wp_ajax_bbpf_following_list', 'bbpf_following_list_ajax_callback' );
add_action( 'wp_ajax_nopriv_bbpf_following_list', 'bbpf_following_list_ajax_callback');

//ajax callbacks for loading the follower list
add_action( 'wp_ajax_bbpf_follower_list', 'bbpf_follower_list_ajax_callback' );
add_action( 'wp_ajax_nopriv_bbpf_follower_list', 'bbpf_follower_list_ajax_callback');

//ajax callbacks for following user from loaded list
add_action( 'wp_ajax_bbpf_follow_from_list', 'bbpf_follow_from_list_ajax_callback' );
add_action( 'wp_ajax_nopriv_bbpf_follow_from_list', 'bbpf_follow_from_list_ajax_callback');

//ajax callbacks to update bbpress user profile page
add_action( 'wp_ajax_bbpf_update_user_profile', 'bbpf_update_user_page_ajax_callback' );
add_action( 'wp_ajax_nopriv_bbpf_update_user_profile', 'bbpf_update_user_page_ajax_callback');

//ajax callbacks for loading the wall topics
add_action( 'wp_ajax_bbpf_get_wall_topics', 'bbpf_get_wall_topics_ajax_callback' );
add_action( 'wp_ajax_nopriv_bbpf_get_wall_topics', 'bbpf_get_wall_topics_ajax_callback');

/**
 * Add our JS and CSS files
 */
function disputo_bbpf_scripts() {
    wp_enqueue_script('bbpf-frontend-script', plugin_dir_url( __FILE__ ) . 'js/follow.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_style('bbpf-frontend-style', plugin_dir_url( __FILE__ ) . 'css/follow.css', true, '1.0'); 
    wp_localize_script( 'bbpf-frontend-script', 'bbpf_ajax_url', array( 'ajax_url' => admin_url('admin-ajax.php'),'check_nonce'=>wp_create_nonce('bbpf-nonce')) );
}
add_action( 'wp_enqueue_scripts', 'disputo_bbpf_scripts' );

//check if one user follows another one
function bbpf_is_follow($user_id,$follower_id) {
    global $wpdb;
    $item_info = $wpdb->get_row( $wpdb->prepare("SELECT a.ID,a.start_follow FROM bbpress_follow a WHERE a.user_id=%d AND a.follower_id=%d LIMIT 1",$user_id,$follower_id));
    if(!empty($item_info)) {
        return $item_info;
    } else {
        return false;
    }
}

//follow user
function bbpf_follow_user($user_id,$follower_id) {
    global $wpdb;
    if(empty($user_id) || empty($follower_id)) {
        return false;
    }
    $res = $wpdb->insert('bbpress_follow',array('user_id'=>$user_id,'follower_id'=>$follower_id,'start_follow'=> current_time('mysql')),array('%d','%d','%s'));  
    if(is_numeric($res)) {
        $followers = get_user_meta($user_id,'bbpress_followers',true);
        if(empty($followers)) {
            $followers = 0;
        }
        $followers = intval($followers)+1;
        update_user_meta($user_id,'bbpress_followers',$followers);
        $followings = get_user_meta($follower_id,'bbpress_following',true);

        if(empty($followings)) {
            $followings = 0;
        }
        $followings = intval($followings)+1;
        update_user_meta($follower_id,'bbpress_following',$followings);
        
        return true;
    }
    else {
       return false;
    }

}

//unfollow user
function bbpf_unfollow_user($user_id,$follower_id) {
    global $wpdb;
    if(empty($user_id) || empty($follower_id)) {
        return false;
    }
    $res=$wpdb->query( $wpdb->prepare("DELETE FROM bbpress_follow WHERE user_id=%d AND follower_id=%d",$user_id,$follower_id));
    if($res!==false) {
        $followers = get_user_meta($user_id,'bbpress_followers',true);
        if(empty($followers)) {
            $followers = 0;
        }
        $followers = intval($followers)-1;
        update_user_meta($user_id,'bbpress_followers',$followers);
        $followings = get_user_meta($follower_id,'bbpress_following',true);

        if(empty($followings)) {
            $followings = 0;
        }
        $followings = intval($followings)-1;
        update_user_meta($follower_id,'bbpress_following',$followings);

        return true;

    } else {
        return false;
    }
}

//get topics data from database
function bbpf_get_topics_info($user_id,$limit=5,$offset=0) {
    global $wpdb;
    $date_format = get_option('date_format');
    $time_format = get_option('time_format');
    $item_info = $wpdb->get_results( $wpdb->prepare("SELECT a.ID,b.ID as forum_id,a.post_title as topic_title,b.post_title as forum_title,a.post_author,d.display_name,a.post_content,a.post_date FROM {$wpdb->prefix}posts a
    INNER JOIN {$wpdb->prefix}posts b ON(a.post_parent=b.ID) INNER JOIN bbpress_follow c ON (c.user_id=a.post_author) INNER JOIN {$wpdb->prefix}users d ON(d.ID=c.user_id)
    WHERE a.post_type='topic' AND b.post_type='forum' AND a.post_status='publish' AND c.follower_id = %d ORDER BY a.ID DESC LIMIT %d,%d",$user_id,$offset,$limit));
    if(!empty($item_info)) {
       foreach($item_info as $k=>$topic) {
       $output[$k]['ID'] = $topic->ID;
       $output[$k]['forum_id'] = $topic->forum_id;
       $output[$k]['forum_title'] = $topic->forum_title;
       $output[$k]['content'] = $topic->post_content;
       $output[$k]['topic_title'] = $topic->topic_title;
       $output[$k]['date'] = get_the_date( $date_format, $topic->ID ) . ' - ' . get_the_time( $time_format, $topic->ID );
       $output[$k]['topic_url'] = bbp_get_topic_permalink( $topic->ID );
       $output[$k]['forum_url'] = bbp_get_forum_permalink( $topic->forum_id );
       $output[$k]['display_name'] = $topic->display_name;
       $output[$k]['profile_url'] = bbp_get_user_profile_url($topic->post_author);
       $output[$k]['avatar_url'] = get_avatar_url($topic->post_author);
       }
   } else {
       $output = array();
   }
   return $output;
}

//get the list of followers
function bbpf_get_follower_list($user_id,$follower_id,$limit=5,$offset=0){
    global $wpdb;
    $item_info = $wpdb->get_results( $wpdb->prepare("SELECT a.ID,a.display_name,c.ID as is_follow FROM {$wpdb->prefix}users a
    INNER JOIN bbpress_follow b ON (a.ID=b.follower_id) LEFT JOIN bbpress_follow c ON(a.ID=c.user_id AND c.follower_id=%d)
    WHERE b.user_id=%d ORDER BY a.ID DESC LIMIT %d,%d",$follower_id,$user_id,$offset,$limit));
    if(!empty($item_info)) {
       foreach($item_info as $k=>$user) {
            $output[$k]['ID'] = $user->ID;
            $output[$k]['display_name'] = $user->display_name;
            $output[$k]['profile_url'] = bbp_get_user_profile_url($user->ID);
            $output[$k]['avatar_url'] = get_avatar_url($user->ID);
            $output[$k]['is_follow'] = (!empty($user->is_follow))?1:0;
       }
   }
   else {
        $output = array();
   }
   return $output;
}

//get the list of the following people
function bbpf_get_following_list($user_id,$follower_id,$limit=5,$offset=0){
    global $wpdb;
    $item_info = $wpdb->get_results( $wpdb->prepare("SELECT a.ID,a.display_name,c.ID as is_follow FROM {$wpdb->prefix}users a
    INNER JOIN bbpress_follow b ON (a.ID=b.user_id) LEFT JOIN bbpress_follow c ON(a.ID=c.user_id AND c.follower_id=%d)
    WHERE b.follower_id=%d ORDER BY a.ID DESC LIMIT %d,%d",$follower_id,$user_id,$offset,$limit));
    if(!empty($item_info)) {
       foreach($item_info as $k=>$user) {
            $output[$k]['ID'] = $user->ID;
            $output[$k]['display_name'] = $user->display_name;
            $output[$k]['profile_url'] = bbp_get_user_profile_url($user->ID);
            $output[$k]['avatar_url'] = get_avatar_url($user->ID);
            $output[$k]['is_follow'] = (!empty($user->is_follow))?1:0;
       }
   }
   else {
        $output = array();
   }
   return $output;
}

//callback function to update user profile page
function bbpf_update_user_page_ajax_callback(){
    check_ajax_referer( 'bbpf-nonce', 'security' );
    //get sent params
    $get_user_num_limit = get_theme_mod('disputo_bbpress_follow_users_load');
    $user_num_limit = (!empty($get_user_num_limit))? intval($get_user_num_limit):5;
    $user_id= isset($_POST['cur_user_id'])?intval(sanitize_text_field($_POST['cur_user_id'])):0;

    $output ='';
    if(!empty($user_id) ) {
        $follow_info = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );
        $followers_count = (!empty($follow_info['bbpress_followers']))? intval($follow_info['bbpress_followers']):0;
        $following_count = (!empty($follow_info['bbpress_following']))? intval($follow_info['bbpress_following']):0;
        $output .= '<div class="bbpf_followers" ><a class="bbpf_followers_link" href="#" data-popup-open="follower_popup"  >'.esc_html('Followers:','disputo').' <span class="badge badge-primary">'.$followers_count.'</span></a></div>';
        $output .= '<div class="bbpf_following" ><a class="bbpf_following_link" href="#" data-popup-open="following_popup"  >'.esc_html('Following:','disputo').' <span class="badge badge-primary">'.$following_count.'</span></a></div>';
        $output .= '<div class="popup bbpf_follower_list" data-popup="follower_popup" data-user_id="'.$user_id.'" data-item_limit="'.$user_num_limit.'">
        <div class="popup-inner">
        <div class="popup-header" >
            <h4>'.esc_html('Followers','disputo').'</h4>
            <a class="popup-close" data-popup-close="follower_popup" data-user_id="'.$user_id.'" href="#"><i class="fa fa-times"></i></a>
            </div>
            <div class="bbpf_view_list"></div>
        </div>
        </div>
        <div class="popup bbpf_following_list" data-popup="following_popup" data-user_id="'.$user_id.'" data-item_limit="'.$user_num_limit.'">
            <div class="popup-inner">
            <div class="popup-header" >
                <h4>'.esc_html('Following','disputo').'</h4>
                <a class="popup-close" data-popup-close="following_popup" href="#"><i class="fa fa-times"></i></a>
                </div>
                <div class="bbpf_view_list"></div>

            </div>
        </div>';
    }
    echo $output;
    wp_die();
}

//callback function to follow user
function bbpf_follow_ajax_callback(){
    check_ajax_referer( 'bbpf-nonce', 'security' );
    //get sent params
    $get_user_num_limit = get_theme_mod('disputo_bbpress_follow_users_load');
    $user_num_limit = (!empty($get_user_num_limit)) ? intval($get_user_num_limit):5;
    $user_id= isset($_POST['follow_user_id']) ? intval(sanitize_text_field($_POST['follow_user_id'])):0;
    $follower_id = get_current_user_id();
    $output ='';
    if(!empty($follower_id) && !empty($user_id) && ($user_id!= $follower_id)) {
        $res = bbpf_follow_user($user_id,$follower_id);
        $follow_info = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );
        $followers_count = (!empty($follow_info['bbpress_followers']))? intval($follow_info['bbpress_followers']):0;
        $following_count = (!empty($follow_info['bbpress_following']))? intval($follow_info['bbpress_following']):0;
        $output .= '<div class="bbpf_followers" ><a class="bbpf_followers_link" href="#" data-popup-open="follower_popup"  >'.esc_html('Followers:','disputo').' <span class="badge badge-primary">'.$followers_count.'</span></a></div>';
        $output .= '<div class="bbpf_following" ><a class="bbpf_following_link" href="#" data-popup-open="following_popup"  >'.esc_html('Following:','disputo').' <span class="badge badge-primary">'.$following_count.'</span></a></div>';
        $output .= '<div class="popup bbpf_follower_list" data-popup="follower_popup" data-user_id="'.$user_id.'" data-item_limit="'.$user_num_limit.'">
        <div class="popup-inner">
        <div class="popup-header" >
            <h4>'.esc_html('Followers','disputo').'</h4>
            <a class="popup-close" data-popup-close="follower_popup" data-user_id="0" href="#"><i class="fa fa-times"></i></a>
            </div>
            <div class="bbpf_view_list"></div>
        </div>
        </div>
        <div class="popup bbpf_following_list" data-popup="following_popup" data-user_id="'.$user_id.'" data-item_limit="'.$user_num_limit.'">
            <div class="popup-inner">
            <div class="popup-header" >
                <h4>'.esc_html('Following','disputo').'</h4>
                <a class="popup-close" data-popup-close="following_popup" href="#"><i class="fa fa-times"></i></a>
                </div>
                <div class="bbpf_view_list"></div>
            </div>
        </div>';
        if($res) {
            $output .= '<div class="bbpf_load_container"><div class="fb_load_container"></div><button class="btn btn-sm btn-danger bbpf_unfollow" data-user_id="'.$user_id.'" ><i class="fa fa-times mr-1"></i>'.esc_html('Unfollow','disputo').'</button></div>';
        } else {
            $output .= '<div class="bbpf_load_container"><div class="fb_load_container"></div><button class="btn btn-sm btn-success bbpf_follow" data-user_id="'.$user_id.'"><i class="fa fa-check mr-1"></i>'.esc_html('Follow','disputo').'</button></div>';
        }
    }
    echo $output;
    wp_die();
}
    
//callback function to follow user from following or followers list
function bbpf_follow_from_list_ajax_callback(){
    check_ajax_referer( 'bbpf-nonce', 'security' );
    //get sent params
    $user_id= isset($_POST['follow_user_id'])?intval(sanitize_text_field($_POST['follow_user_id'])):0;
    $follower_id = get_current_user_id();
    $output ='';
    if(!empty($follower_id) && !empty($user_id) && ($user_id!= $follower_id)) {
        $res = bbpf_follow_user($user_id,$follower_id);
        if($res) {
            $output .= '<span>'.esc_html('Following','disputo').'</span>';
        } else {
            $output .= '<button class="btn btn-sm btn-success bbpf_follow_from_list" data-user_id="'.$user_id.'"><i class="fa fa-check mr-1"></i>'.esc_html('Follow','disputo').'</button>';
        }
    }
    echo $output;
    wp_die();
}

//callback function to unfollow user
function bbpf_unfollow_ajax_callback(){
    check_ajax_referer( 'bbpf-nonce', 'security' );
    //get sent params
    $get_user_num_limit = get_theme_mod('disputo_bbpress_follow_users_load');
    $user_num_limit = (!empty($get_user_num_limit))? intval($get_user_num_limit):5;
    $user_id= isset($_POST['unfollow_user_id'])?intval(sanitize_text_field($_POST['unfollow_user_id'])):0;
    $follower_id = get_current_user_id();
    $output ='';
    $follow_item = bbpf_is_follow($user_id,$follower_id);
    if(!empty($follower_id) && !empty($user_id) && ($user_id!= $follower_id) && $follow_item) {
        $res = bbpf_unfollow_user($user_id,$follower_id);
        $follow_info = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );
        $followers_count = (!empty($follow_info['bbpress_followers']))? intval($follow_info['bbpress_followers']):0;
        $following_count = (!empty($follow_info['bbpress_following']))? intval($follow_info['bbpress_following']):0;
        $output .= '<div class="bbpf_followers" ><a class="bbpf_followers_link" href="#" data-popup-open="follower_popup" >'.esc_html('Followers:','disputo').' <span class="badge badge-primary">'.$followers_count.'</span></a></div>';
        $output .= '<div class="bbpf_following" ><a class="bbpf_following_link" href="#" data-popup-open="following_popup"  >'.esc_html('Following:','disputo').' <span class="badge badge-primary">'.$following_count.'</span></a></div>';
        $output .= '<div class="popup bbpf_follower_list" data-popup="follower_popup" data-user_id="'.$user_id.'" data-item_limit="'.$user_num_limit.'">
        <div class="popup-inner">
        <div class="popup-header" >
            <h4>'.esc_html('Followers','disputo').'</h4>
            <a class="popup-close" data-popup-close="follower_popup" data-user_id="0" href="#"><i class="fa fa-times"></i></a>
            </div>
            <div class="bbpf_view_list"></div>
        </div>
        </div>
        <div class="popup bbpf_following_list" data-popup="following_popup" data-user_id="'.$user_id.'" data-item_limit="'.$user_num_limit.'">
            <div class="popup-inner">
            <div class="popup-header" >
                <h4>'.esc_html('Following','disputo').'</h4>
                <a class="popup-close" data-popup-close="following_popup" href="#"><i class="fa fa-times"></i></a>
                </div>
                <div class="bbpf_view_list"></div>

            </div>
        </div>';
        if($res) {
            $output .= '<div class="bbpf_load_container"><div class="fb_load_container"></div><button class="btn btn-sm btn-success bbpf_follow" data-user_id="'.$user_id.'" ><i class="fa fa-check mr-1"></i>'.esc_html('Follow','disputo').'</button></div>';
        } else {
            $output .= '<div class="bbpf_load_container"><div class="fb_load_container"></div><button class="btn btn-sm btn-danger bbpf_unfollow" data-user_id="'.$user_id.'" ><i class="fa fa-times mr-1"></i>'.esc_html('Unfollow','disputo').'</button></div>';
        }
    }
    echo $output;
    wp_die();
}

//callback function to load the list of followers
function bbpf_follower_list_ajax_callback(){
    check_ajax_referer( 'bbpf-nonce', 'security' );
    //get sent params
    $user_id= isset($_POST['list_user_id'])?intval(sanitize_text_field($_POST['list_user_id'])):0;
    $offset = isset($_POST['list_offset'])?intval(sanitize_text_field($_POST['list_offset'])):0;
    $limit = isset($_POST['item_limit'])?intval(sanitize_text_field($_POST['item_limit'])):5;
    $follower_id = get_current_user_id();
    $output ='';
    if(!empty($follower_id) && !empty($user_id)) {
        $users = bbpf_get_follower_list($user_id,$follower_id,$limit,$offset);
        if(!empty($users)) {
            foreach($users as $k=>$user) {
                if($user['is_follow'] || $user['ID']==$follower_id) {
                    $follow_state = '<div class="bbpf-state">'.esc_html('Following','disputo').'</div>';
                } else {
                    $follow_state = '<button class="btn btn-sm btn-success bbpf_follow_from_list" data-user_id="'.$user['ID'].'"><i class="fa fa-check mr-1"></i>'.esc_html('Follow','disputo').'</button>';
                }
                $output .= '<div class="bbpf_follow_list_container" >
                <div class="bbpf_user_info">
                <a href="'.esc_url($user['profile_url']).'"><img src="'.esc_url($user['avatar_url']).'" title="'.$user['display_name'].'" alt="'.$user['display_name'].'"/></a>
                <a href="'.esc_url($user['profile_url']).'">'.$user['display_name'].'</a>
                </div>
                <div class="bbpf_follow_state">'.$follow_state.'</div>
                </div>';
            }
        } else {
            if($offset==0) {
                $output = '<div class="alert alert-info">'.esc_html('No follower found','disputo').'</div>';
            }
        }
    }
    echo $output;
    wp_die();
}

//callback function to load the list of following people
function bbpf_following_list_ajax_callback(){
    check_ajax_referer( 'bbpf-nonce', 'security' );
    //get sent params
    $user_id= isset($_POST['list_user_id'])?intval(sanitize_text_field($_POST['list_user_id'])):0;
    $offset= isset($_POST['list_offset'])?intval(sanitize_text_field($_POST['list_offset'])):0;
    $limit = isset($_POST['item_limit'])?intval(sanitize_text_field($_POST['item_limit'])):5;
    $follower_id = get_current_user_id();
    $output ='';
    if(!empty($follower_id) && !empty($user_id)) {
        $users = bbpf_get_following_list($user_id,$follower_id,$limit,$offset);
        if(!empty($users)) {
            foreach($users as $k=>$user) {
                if($user['is_follow'] || $user['ID']==$follower_id) {
                    $follow_state = '<div class="bbpf-state">'.esc_html('Following','disputo').'</div>';
                } else {
                    $follow_state = '<button class="btn btn-sm btn-success bbpf_follow_from_list" data-user_id="'.$user['ID'].'"><i class="fa fa-check mr-1"></i>'.esc_html('Follow','disputo').'</button>';
                }
                $output .= '<div class="bbpf_follow_list_container" >
                <div class="bbpf_user_info">
                <a href="'.esc_url($user['profile_url']).'"><img src="'.esc_url($user['avatar_url']).'" title="'.$user['display_name'].'" alt="'.$user['display_name'].'"/></a>
                <a href="'.esc_url($user['profile_url']).'">'.$user['display_name'].'</a>
                </div>
                <div class="bbpf_follow_state">'.$follow_state.'</div>
                </div>';
            }
        } else { 
            if($offset==0) {
                $output = '<div class="alert alert-info">'.esc_html('No following found','disputo').'</div>';
            }
        }
    }
    echo $output;
    wp_die();
}

//callback function to load wall topics
function bbpf_get_wall_topics_ajax_callback(){
    check_ajax_referer( 'bbpf-nonce', 'security' );
    //get sent params
    $word_limit = isset($_POST['wall_word_limit'])?intval(sanitize_text_field($_POST['wall_word_limit'])):20;
    $title_limit = isset($_POST['wall_title_limit'])?intval(sanitize_text_field($_POST['wall_title_limit'])):5;
    $offset= isset($_POST['wall_offset'])?intval(sanitize_text_field($_POST['wall_offset'])):0;
    $item_limit = isset($_POST['wall_item_limit'])?intval(sanitize_text_field($_POST['wall_item_limit'])):5;
    $output ='';
    $user_id = get_current_user_id();
    if(!empty($user_id)) {
        //get the topics of current user from database
        $topics = bbpf_get_topics_info($user_id,$item_limit,$offset);
        if(!empty($topics)) {
            foreach($topics as $topic)
            {
                $limited_topic_title = wp_trim_words($topic['topic_title'],$title_limit,'...');
                $output .='<div class="bbpf_topic_item">';
                $output .= '<div class="bbpf_topic_header"><a class="bbpf_img_link" href="'.esc_url($topic['profile_url']).'"><img src="'.esc_url($topic['avatar_url']).'" title="'.$topic['display_name'].'" alt="'.$topic['display_name'].'"/></a><a class="bbpf_user_link" href="'.esc_url($topic['profile_url']).'">'.$topic['display_name'].'</a></div>';
                $output .= '<div class="bbpf_topic_content_wrapper">';
                $output .= '<div class="bbpf_topic_title"><a href="'.esc_url($topic['topic_url']).'" >'.$limited_topic_title.'</a></div>';
                $output .='<div class="bbpf_topic_date"><i class="fa fa-clock-o"></i> '.$topic['date'].'</div>';
                $output .= '<div class="bbpf_topic_content"><p>'.wp_trim_words($topic['content'],$word_limit,'...').'</p><div class="bbpf_topic_content_btn"><a class="btn btn-sm btn-primary" href="'.esc_url($topic['topic_url']).'" >'.esc_html('Read More','disputo').'</a></div></div>';
                $output .='</div>';
                $output .='</div>';
            }
        }
    }
    echo $output;
    wp_die();
}

//adding the following box to user profile page
add_action('disputo_before_user_profile','bbpf_display_follow_box');
function bbpf_display_follow_box(){
    $bbp = bbpress();
    $user_id = get_current_user_id();
    $get_user_num_limit = get_theme_mod('disputo_bbpress_follow_users_load');
    $user_num_limit = (!empty($get_user_num_limit))? intval($get_user_num_limit):5;
    
    if(!empty($user_id)) {
        $follow_info = array_map( function( $a ){ return $a[0]; }, get_user_meta( $bbp->displayed_user->ID ) );
        $followers_count = (!empty($follow_info['bbpress_followers']))? intval($follow_info['bbpress_followers']):0;
        $following_count = (!empty($follow_info['bbpress_following']))? intval($follow_info['bbpress_following']):0;
        $current_user_id = ($bbp->displayed_user->ID == $user_id)? $user_id:0;
        $output ='<div class="follow_box_container">';
        $output .= '<div class="bbpf_followers" ><a class="bbpf_followers_link" href="#" data-popup-open="follower_popup"  >'. esc_html__('Followers:','disputo').' <span class="badge badge-primary">'.$followers_count.'</span></a></div>';
        $output .= '<div class="bbpf_following" ><a class="bbpf_following_link" href="#" data-popup-open="following_popup"  >'. esc_html__('Following:','disputo').' <span class="badge badge-primary">'.$following_count.'</span></a></div>';
        $output .= '<div class="popup bbpf_follower_list" data-popup="follower_popup" data-user_id="'.$bbp->displayed_user->ID.'" data-item_limit="'.$user_num_limit.'">
        <div class="popup-inner">
        <div class="popup-header" >
            <h4>'. esc_html__('Followers','disputo').'</h4>
            <a class="popup-close" data-popup-close="follower_popup" data-user_id="'.$current_user_id.'" href="#"><i class="fa fa-times"></i></a>
            </div>
            <div class="bbpf_view_list"></div>
            <div class="fb_load_container"></div>
        </div>
        </div>
        <div class="popup bbpf_following_list" data-popup="following_popup" data-user_id="'.$bbp->displayed_user->ID.'" data-item_limit="'.$user_num_limit.'">
            <div class="popup-inner">
            <div class="popup-header" >
                <h4>'. esc_html__('Following','disputo').'</h4>
                <a class="popup-close" data-popup-close="following_popup" href="#"><i class="fa fa-times"></i></a>
                </div>
                <div class="bbpf_view_list"></div>
                <div class="fb_load_container"></div>
            </div>
        </div>';
        if($bbp->displayed_user->ID!= $user_id) {
            //check the following state
            $follow_item = bbpf_is_follow($bbp->displayed_user->ID,$user_id);
            if($follow_item && $bbp->displayed_user->ID) {
                $output .= '<div class="bbpf_load_container"><div class="fb_load_container"></div><button class="btn btn-sm btn-danger bbpf_unfollow" data-user_id="'.$bbp->displayed_user->ID.'" ><i class="fa fa-times mr-1"></i>'. esc_html__('Unfollow','disputo').'</button></div>';
            } else {
                $output .= '<div class="bbpf_load_container"><div class="fb_load_container"></div><button class="btn btn-sm btn-success bbpf_follow" data-user_id="'.$bbp->displayed_user->ID.'" ><i class="fa fa-check mr-1"></i>'. esc_html__('Follow','disputo').'</button></div>';
            }
        }
        $output .='</div>';
        echo $output;
    }
}

// SHORTCODE
function bbpf_wall_makeshortcode($atts) {
    //get attributes for shortcode
    $get_word_limit = get_theme_mod('disputo_bbpress_follow_limit_topic_desc');
    $get_item_limit = get_theme_mod('disputo_bbpress_follow_topics_load');
    $get_title_limit = get_theme_mod('disputo_bbpress_follow_limit_topic');

    $tmp_word_limit = !empty($get_word_limit) ? $get_word_limit:40;
    $tmp_item_limit = !empty($get_item_limit) ? $get_item_limit:5;
    $tmp_title_limit = !empty($get_title_limit)? $get_title_limit:5;
    $attr = shortcode_atts( array('word_limit'=>$tmp_word_limit,'item_limit'=>$tmp_item_limit,'title_limit'=>$tmp_title_limit), $atts );

    //checking sent values
    $word_limit=intval(sanitize_text_field($attr['word_limit']));
    $title_limit=intval(sanitize_text_field($attr['title_limit']));
    $item_limit=intval(sanitize_text_field($attr['item_limit']));
    
    $output ='';
    
    $user_id = get_current_user_id();
    if(!empty($user_id)) {
        //get the topics of current user from database
        $topics = bbpf_get_topics_info($user_id,$item_limit);
            if(!empty($topics)) {
                $output = '<div class="bbpf_topic_container">';
                foreach($topics as $topic) {
                    $limited_topic_title = wp_trim_words($topic['topic_title'],$title_limit,'...');
                    $output .='<div class="bbpf_topic_item">';
                    $output .= '<div class="bbpf_topic_header"><a class="bbpf_img_link" href="'.esc_url($topic['profile_url']).'"><img src="'.esc_url($topic['avatar_url']).'" title="'.$topic['display_name'].'" alt="'.$topic['display_name'].'"/></a><a class="bbpf_user_link" href="'.esc_url($topic['profile_url']).'">'.$topic['display_name'].'</a></div>';
                    $output .= '<div class="bbpf_topic_content_wrapper">';
                    $output .= '<div class="bbpf_topic_title"><a href="'.esc_url($topic['topic_url']).'" >'.$limited_topic_title.'</a></div>';
                    $output .='<div class="bbpf_topic_date"><i class="fa fa-clock-o"></i> '.$topic['date'].'</div>';
                    $output .= '<div class="bbpf_topic_content"><p>'.wp_trim_words($topic['content'],$word_limit,'...').'</p><div class="bbpf_topic_content_btn"><a class="btn btn-sm btn-primary" href="'.esc_url($topic['topic_url']).'" >'. esc_html__('Read More','disputo').'</a></div></div>';
                    $output .='</div>';
                    $output .='</div>';
                }
                //show load more button if topics are more than limitation
                if(count($topics) >= $item_limit) {
                    $output .= '<div class="bbpf_load_container"><button class="btn btn-primary bbpf_load bbpf_topic_btn" data-item_limit="'.$item_limit.'" data-word_limit="'.$word_limit.'" data-title_limit="'.$title_limit.'" data-noposts="'. esc_html__('No More Posts Found','disputo').'" data-loadingtxt="'. esc_html__('Loading...','disputo').'" data-loadtxt="'. esc_html__('Load More','disputo').'"> '. esc_html__('Load More','disputo').'</button></div>';
                }
            $output .= '</div>';
        } else {
            $output .= '<div class="alert alert-danger">'. esc_html__('No topics found','disputo').'</div>';
        }
    } else {
        $output = '<div class="alert alert-danger" >'. esc_html__('You must login to see the topics','disputo').'</div>'; 
    }
    ob_start();
    echo $output;
    return ob_get_clean();
}
    
//add shortcode
add_shortcode('bbpresswall','bbpf_wall_makeshortcode');