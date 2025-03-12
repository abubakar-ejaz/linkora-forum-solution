<?php
$disputo_query_var = get_query_var('bb_user');
$disputo_orderby = isset($instance['b_section']['orderby']) ? $instance['b_section']['orderby'] : 'topics';
$disputo_limit = isset($instance['b_section']['limit']) ? $instance['b_section']['limit'] : 12;
$disputo_exclude = $instance['b_section']['exclude'];
$disputo_pagination = $instance['b_section']['pagination'];
$disputo_verified = $instance['b_section']['verified'];
$disputo_register = $instance['c_section']['register'];
$disputo_avatar = $instance['c_section']['avatar'];
$disputo_role = $instance['c_section']['role'];
$disputo_statistics = $instance['c_section']['statistics'];
$disputo_bio = $instance['c_section']['bio'];
$disputo_flag = $instance['c_section']['flag'];

$verified_filter = array();
if ($disputo_verified) {
    $verified_filter = array(
        'meta_query' => array(
            array(
                'key' => 'disputo_verified_user',
                'value' => 'yes'
            )
        )
    );
}

if ($disputo_exclude) {
    $exclude = explode( ',', $disputo_exclude );
} else {
    $exclude = array();
}

if ($disputo_pagination) {
    if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
    elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
    else { $paged = 1; }
    $offset = ($paged - 1) * $disputo_limit;
    if ($disputo_verified) {
        $users = get_users(array(
            'meta_key'     => 'disputo_verified_user',
            'meta_value'   => 'yes'
        ));
    } else {
        $users = get_users();
    }
    $total_users = count($users);
    $total_pages = intval(ceil($total_users / $disputo_limit));
} else {
    $offset = 0;
}

if ($disputo_query_var) {
    $user_query = array(
        'search'         => '*' . esc_attr( $disputo_query_var ) . '*',
        'search_columns' => array(
            'user_login',
            'user_nicename'
        ),
        'exclude' => $exclude
    );  
} else {
switch ($disputo_orderby) {
    case 'replies':
        $user_query = array(
            'orderby'	 => 'meta_value_num',
            'meta_key'	 => 'wp__bbp_reply_count',
            'order'		 => 'DESC',
            'exclude' => $exclude,
            'number'	 => $disputo_limit,
            'offset'     => $offset
        );
        break;
    case 'active':
        $user_query = array(
            'orderby'	 => 'meta_value_num',
            'meta_key'	 => 'last_login',
            'order'		 => 'DESC',
            'exclude' => $exclude,
            'number'	 => $disputo_limit,
            'offset'     => $offset
        );
        break;
    case 'online':
        $user_query = array(
            'orderby'		 => 'meta_value_num',
            'meta_key'		 => 'last_login',
            'meta_value'	 => time() - 30 * MINUTE_IN_SECONDS,
            'meta_compare'	 => '>',
            'order'			 => 'DESC',
            'exclude' => $exclude,
            'number'		 => $disputo_limit,
            'offset'     => $offset
        );
        break;
    case 'new':
        $user_query = array(
            'orderby'	 => 'user_registered',
            'order'		 => 'DESC',
            'exclude' => $exclude,
            'number'	 => $disputo_limit,
            'offset'     => $offset
        );
        break;
    case 'old':
        $user_query = array(
            'orderby'	 => 'user_registered',
            'order'		 => 'ASC',
            'exclude' => $exclude,
            'number'	 => $disputo_limit,
            'offset'     => $offset
        );
        break;
    case 'titleasc':
        $user_query = array(
            'orderby'	 => 'title',
            'order'		 => 'ASC',
            'exclude' => $exclude,
            'number'	 => $disputo_limit,
            'offset'     => $offset
        );
        break;
    case 'titledesc':
        $user_query = array(
            'orderby'	 => 'title',
            'order'		 => 'DESC',
            'exclude' => $exclude,
            'number'	 => $disputo_limit,
            'offset'     => $offset
        );
        break;    
    case 'topics':
    default:
        $user_query = array(
            'orderby'	 => 'meta_value_num',
            'meta_key'	 => 'wp__bbp_topic_count',
            'order'		 => 'DESC',
            'exclude' => $exclude,
            'number'	 => $disputo_limit,
            'offset'     => $offset
        );
        break;
}
}

$final_query = new WP_User_Query($user_query + $verified_filter);

$total_query = count($final_query);
?>

<?php if (!empty($instance['a_section']['heading'])) { ?>
<div class="disputo-widget-title">
    <<?php echo esc_attr($instance['a_section']['headinglevel']); ?>><span><?php echo esc_attr($instance['a_section']['heading']); ?></span></<?php echo esc_attr($instance['a_section']['headinglevel']); ?>>
</div>
<?php } ?>
<?php
$grid_style = '';
if (($instance['b_section']['columns'] == 'disputo-four-columns') || ($instance['b_section']['columns'] == 'disputo-five-columns')) {
    $grid_style = 'small-grid';
}
?>
<?php if ($final_query->get_results()) { ?> 

<?php if (strpos($instance['b_section']['columns'], 'thumbnail-grid-') !== false) { ?>
<div class="disputo-thumbnail-grid <?php echo esc_attr($instance['b_section']['columns']); ?>" style="grid-gap: <?php echo esc_attr($instance['b_section']['thumbnail_grid_gap']); ?>px;">
    <?php foreach ($final_query->get_results() as $user) {
            $disputo_bbpress_user_avatar = get_theme_mod('disputo_bbpress_user_avatar');
            $custom_avatar = get_user_meta($user->ID, 'disputo_cmb2_user_avatar' );
            $selected_thumb_size = 'thumbnail';
            if ($instance['b_section']['thumb_size'] == 512) {
                $selected_thumb_size = 'medium_large';
            } elseif ($instance['b_section']['thumb_size'] == 300) {
                $selected_thumb_size = 'medium';
            }
            $custom_avatar_img = wp_get_attachment_image_src( get_user_meta( $user->ID, 'disputo_cmb2_user_avatar_id', 1 ), $selected_thumb_size );      
            $disputo_verified_user = disputo_verified_check($user->ID); 
            $disputo_verified_class = '';
            $disputo_verified_title = '';
            if ($disputo_verified_user == 'verified') {
                $disputo_verified_class = 'disputo-verified-user';
            }
            $user_info = get_userdata( $user->ID );
            $display_name = $user_info->display_name;
            if ($disputo_bbpress_user_avatar && $custom_avatar) { ?>
            <div class="disputo-thumbnail-grid-item <?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($display_name); ?>" data-toggle="tooltip" data-placement="top">
                <a href="<?php bbp_user_profile_url($user->ID); ?>" class="<?php echo esc_attr($instance['b_section']['thumb_border_radius']); ?>">
                    <img src="<?php echo esc_url($custom_avatar_img[0]); ?>" alt="" />
                </a>
            </div>
            <?php } else { ?>
            <div class="disputo-thumbnail-grid-item <?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($display_name); ?>" data-toggle="tooltip" data-placement="top">
                <a href="<?php bbp_user_profile_url($user->ID); ?>" class="<?php echo esc_attr($instance['b_section']['thumb_border_radius']); ?>">
                    <?php echo get_avatar( $user->ID, apply_filters( 'bbp_single_user_details_avatar_size', $instance['b_section']['thumb_size'] ) ); ?>
                </a>
            </div>
    <?php }
    } ?> 
</div>
<?php } else { ?>

<div class="disputo-masonry-grid card-bbpress-user <?php echo esc_html($grid_style); ?>">
    <div class="<?php echo esc_attr($instance['b_section']['columns']); ?>" data-columns>    
<?php
foreach ($final_query->get_results() as $user) {
    if (($instance['b_section']['columns'] == 'disputo-four-columns') || ($instance['b_section']['columns'] == 'disputo-five-columns')) { ?>
    <div class="card-masonry card-small">
        <div class="card">
            <div class="card-body">
            <?php if ($disputo_avatar) { ?> 
            <?php
            $disputo_bbpress_user_avatar = get_theme_mod('disputo_bbpress_user_avatar');
            $custom_avatar = get_user_meta($user->ID, 'disputo_cmb2_user_avatar' );
            $selected_thumb_size = 'thumbnail';
            if ($instance['b_section']['thumb_size'] == 512) {
                $selected_thumb_size = 'medium_large';
            } elseif ($instance['b_section']['thumb_size'] == 300) {
                $selected_thumb_size = 'medium';
            }
            $custom_avatar_img = wp_get_attachment_image_src( get_user_meta( $user->ID, 'disputo_cmb2_user_avatar_id', 1 ), $selected_thumb_size );                                                                                                                             
            $disputo_verified_user = disputo_verified_check($user->ID); 
            $disputo_verified_class = '';
            $disputo_verified_title = '';
            if ($disputo_verified_user == 'verified') {
                $disputo_verified_class = 'disputo-verified-user';
                $disputo_verified_title = esc_html__( 'Verified User', 'disputo' ); 
            }
            ?>
            <?php if ($disputo_bbpress_user_avatar && $custom_avatar) { ?>
            <div class="<?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($disputo_verified_title); ?>">
                <a class="card-user-thumb <?php echo esc_attr($instance['b_section']['thumb_border_radius']); ?>" href="<?php bbp_user_profile_url($user->ID); ?>">
                    <img src="<?php echo esc_url($custom_avatar_img[0]); ?>" alt="" />
                </a>
            </div>
            <?php } else { ?>
            <div class="<?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($disputo_verified_title); ?>">
                <a class="card-user-thumb <?php echo esc_attr($instance['b_section']['thumb_border_radius']); ?>" href="<?php bbp_user_profile_url($user->ID); ?>">
                    <?php echo get_avatar( $user->ID, apply_filters( 'bbp_single_user_details_avatar_size', $instance['b_section']['thumb_size'] ) ); ?>
                </a>
            </div>
            <?php } ?>
            <?php } ?>    
                <h5><?php echo bbp_get_user_profile_link($user->ID); ?></h5>
                <?php if ($disputo_role) { ?>
                <?php $roles = bbp_get_dynamic_roles(); ?>
                <?php echo '<span class="badge badge-info">' . bbp_translate_user_role($roles[bbp_get_user_role( $user->ID )]['name']) . '</span>'; ?>
                <?php } ?>   
                <?php
                $disputo_bbpress_flags = get_theme_mod('disputo_bbpress_flags');
                $disputo_user_flag = get_user_meta( $user->ID, 'disputo_cmb2_flag', true ); 
                $disputo_follow_user = get_theme_mod('disputo_bbpress_follow_user');
                $disputo_follow_info = '';
                if ($disputo_follow_user) {
                    $followers = get_user_meta($user->ID,'bbpress_followers',true);
                    $following = get_user_meta($user->ID,'bbpress_following',true);
                    if (empty($followers)) {
                        $followers = '0';
                    }
                    if (empty($following)) {
                        $following = '0';
                    }
                    $disputo_follow_info = '<br>' . esc_html( 'Followers', 'disputo') . ': ' . $followers . '<br>' . esc_html( 'Following', 'disputo') . ': ' . $following;
                }
                if ($disputo_bbpress_flags && $disputo_user_flag && $disputo_flag) {
                ?>
                <div class="disputo-user-location">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/blank.gif" class="flag flag-<?php echo esc_attr(strtolower($disputo_user_flag)); ?>" alt="<?php echo esc_attr($disputo_user_flag); ?>" />
                </div>
                <?php } ?> 
                <?php if (!empty(get_user_meta( $user->ID, 'description', 1 )) && $disputo_bio) { ?>
                <p><?php echo get_user_meta( $user->ID, 'description', 1 ); ?></p>
                <?php } ?>
            </div>
            <?php if (($disputo_statistics) || ($disputo_register)) { ?>
            <div class="card-footer">
                <?php if ($disputo_register) { ?>
                <div><strong><?php esc_html_e( 'Registered', 'disputo' ); ?>:</strong> <?php echo bbp_get_time_since( $user->user_registered ) ?></div>
                <?php } ?>
                <?php if ($disputo_statistics) { ?>
                <div class="disputo-comment-count">
                    <a tabindex="0" class="disputo-popover" data-container="body" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="<?php esc_attr_e( 'Topics Started', 'disputo' ); ?>: <?php echo esc_attr(bbp_get_user_topic_count_raw($user->ID)); ?><br><?php esc_attr_e( 'Replies Created', 'disputo' ); ?>: <?php echo esc_attr(bbp_get_user_reply_count_raw($user->ID)); ?><?php echo $disputo_follow_info; ?>" data-original-title="<?php esc_attr_e( 'Statistics', 'disputo') ?>"><i class="fa fa-bar-chart"></i></a> 
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div> 
    </div>
    <?php } else { ?>
    <div class="card-masonry">
        <div class="card">
            <div class="card-body">
                <?php if ($disputo_avatar) { ?> 
                <?php
                $disputo_bbpress_user_avatar = get_theme_mod('disputo_bbpress_user_avatar');
                $custom_avatar = get_user_meta($user->ID, 'disputo_cmb2_user_avatar' );
                $selected_thumb_size = 'thumbnail';
                if ($instance['b_section']['thumb_size'] == 512) {
                    $selected_thumb_size = 'medium_large';
                } elseif ($instance['b_section']['thumb_size'] == 300) {
                    $selected_thumb_size = 'medium';
                }
                $custom_avatar_img = wp_get_attachment_image_src( get_user_meta( $user->ID, 'disputo_cmb2_user_avatar_id', 1 ), $selected_thumb_size );                                                                                                                             
                $disputo_verified_user = disputo_verified_check($user->ID); 
                $disputo_verified_class = '';
                $disputo_verified_title = '';
                if ($disputo_verified_user == 'verified') {
                    $disputo_verified_class = 'disputo-verified-user';
                    $disputo_verified_title = esc_html__( 'Verified User', 'disputo' ); 
                }
                ?>
                <?php if ($disputo_bbpress_user_avatar && $custom_avatar) { ?>
                <div class="<?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($disputo_verified_title); ?>">
                    <a class="card-user-thumb <?php echo esc_attr($instance['b_section']['thumb_border_radius']); ?>" href="<?php bbp_user_profile_url($user->ID); ?>">
                        <img src="<?php echo esc_url($custom_avatar_img[0]); ?>" alt="" />
                    </a>
                </div>
                <?php } else { ?>
                <div class="<?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($disputo_verified_title); ?>">
                    <a class="card-user-thumb <?php echo esc_attr($instance['b_section']['thumb_border_radius']); ?>" href="<?php bbp_user_profile_url($user->ID); ?>">
                        <?php echo get_avatar( $user->ID, apply_filters( 'bbp_single_user_details_avatar_size', $instance['b_section']['thumb_size'] ) ); ?>
                    </a>
                </div>
                <?php } ?>
                <?php } ?>
                <h2 class="card-title no-margin"><?php echo bbp_get_user_profile_link($user->ID); ?></h2>
                <?php if ($disputo_role) { ?>
                <?php $roles = bbp_get_dynamic_roles(); ?>
                <?php echo '<span class="badge badge-info">' . bbp_translate_user_role($roles[bbp_get_user_role( $user->ID )]['name']) . '</span>'; ?>
                <?php } ?>
                <?php
                $disputo_bbpress_flags = get_theme_mod('disputo_bbpress_flags');
                $disputo_user_flag = get_user_meta( $user->ID, 'disputo_cmb2_flag', true ); 
                $disputo_follow_user = get_theme_mod('disputo_bbpress_follow_user');
                $disputo_follow_info = '';
                if ($disputo_follow_user) {
                    $followers = get_user_meta($user->ID,'bbpress_followers',true);
                    $following = get_user_meta($user->ID,'bbpress_following',true);
                    if (empty($followers)) {
                        $followers = '0';
                    }
                    if (empty($following)) {
                        $following = '0';
                    }
                    $disputo_follow_info = '<br>' . esc_html( 'Followers', 'disputo') . ': ' . $followers . '<br>' . esc_html( 'Following', 'disputo') . ': ' . $following;
                }
                if ($disputo_bbpress_flags && $disputo_user_flag && $disputo_flag) {
                ?>
                <div class="disputo-user-location">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/blank.gif" class="flag flag-<?php echo esc_attr(strtolower($disputo_user_flag)); ?>" alt="<?php echo esc_attr($disputo_user_flag); ?>" />
                </div>
                <?php } ?> 
                <?php if (!empty(get_user_meta( $user->ID, 'description', 1 )) && $disputo_bio) { ?>
                <p><?php echo get_user_meta( $user->ID, 'description', 1 ); ?></p>
                <?php } ?>
            </div>
            <?php if (($disputo_statistics) || ($disputo_register)) { ?>
            <div class="card-footer">
                <?php if ($disputo_register) { ?>
                <div><strong><?php esc_html_e( 'Registered', 'disputo' ); ?>:</strong> <?php echo bbp_get_time_since( $user->user_registered ) ?></div>
                <?php } ?>
                <?php if ($disputo_statistics) { ?>
                <div class="disputo-comment-count">
                    <a tabindex="0" class="disputo-popover" data-container="body" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="<?php esc_attr_e( 'Topics Started', 'disputo' ); ?>: <?php echo esc_attr(bbp_get_user_topic_count_raw($user->ID)); ?><br><?php esc_attr_e( 'Replies Created', 'disputo' ); ?>: <?php echo esc_attr(bbp_get_user_reply_count_raw($user->ID)); ?><?php echo $disputo_follow_info; ?>" data-original-title="<?php esc_attr_e( 'Statistics', 'disputo') ?>"><i class="fa fa-bar-chart"></i></a> 
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div> 
    </div>    
    <?php }
}
?>
    </div>
</div>
<?php    
}                              
if ($disputo_pagination && empty($disputo_query_var)) {
  if ($total_users > $total_query) {
    $pages = paginate_links( [
        'base' => get_pagenum_link(1) . '%_%',
        'format' => 'page/%#%/',
        'current'      => max( 1, $paged ),
        'total'        => $total_pages,
        'type'         => 'array',
        'show_all'     => false,
        'end_size'     => 3,
        'mid_size'     => 1,
        'prev_next'    => true,
        'prev_text'    => '<i class="fa fa-angle-left"></i>',
        'next_text'    => '<i class="fa fa-angle-right"></i>',
        'add_args'     => false,
        'add_fragment' => ''
    ]
);
$pagination_spacing = 0;
if (strpos($instance['b_section']['columns'], 'thumbnail-grid-') !== false) {
    $pagination_spacing = $instance['b_section']['thumbnail_grid_gap'] * 2;
}
$pagination = '<div class="disputo-pager" style="margin-top:' . $pagination_spacing . 'px"><ul class="pagination flex-wrap justify-content-center">';
foreach ($pages as $page) {
    $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
}
$pagination .= '</ul></div>';
echo wp_kses_post($pagination);  
  }
}
?>
<?php } else { ?>
<div class="alert alert-danger"><?php echo esc_html__( 'No Results Found', 'disputo' ); ?></div>
<?php } ?>
<?php wp_reset_postdata(); ?>