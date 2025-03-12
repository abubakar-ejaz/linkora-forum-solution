<?php
/* ---------------------------------------------------------
bbPress Breadcrumb menu
----------------------------------------------------------- */

function disputo_no_breadcrumb() {
    return true; 
}

$disputo_breadcrumb = get_theme_mod('disputo_bbpress_breadcrumb');
    
if ($disputo_breadcrumb) {
    add_filter('bbp_no_breadcrumb', 'disputo_no_breadcrumb');
}

/* ---------------------------------------------------------
bbPress Breadcrumb home icon
----------------------------------------------------------- */

function disputo_modify_breadcrumb() {
    $args['home_text'] = '<i class="fa fa-home"></i>';
    return $args;
}

add_filter( 'bbp_before_get_breadcrumb_parse_args', 'disputo_modify_breadcrumb' );

/* ---------------------------------------------------------
bbPress Max Topic Length
----------------------------------------------------------- */

function disputo_title_max_length ($default) {
    $default = get_theme_mod('disputo_max_topic_length', 80);
    return $default;
}

add_filter('bbp_get_title_max_length','disputo_title_max_length');

/* ---------------------------------------------------------
bbPress Forum Signature
----------------------------------------------------------- */

function disputo_reply_forum_signature() {
    $signature = get_user_meta( bbp_get_reply_author_id(), 'disputo_cmb2_forum_signature', true );
    if($signature) {
        echo '<div class="disputo-forum-signature">' . wp_kses_post($signature) . '</div>';
    }
}

function disputo_topic_forum_signature() {
    $signature = get_user_meta( bbp_get_topic_author_id(), 'disputo_cmb2_forum_signature', true );
    if($signature) {
        echo '<div class="disputo-forum-signature">' . wp_kses_post($signature) . '</div>';
    }
}

$disputo_bbpress_signature = get_theme_mod('disputo_bbpress_signature');

if ($disputo_bbpress_signature) {
    add_filter('bbp_theme_after_reply_content', 'disputo_reply_forum_signature', 98, 2);
    add_filter('bbp_theme_after_topic_content', 'disputo_topic_forum_signature', 98, 2);
}

/* ---------------------------------------------------------
Default Avatar
----------------------------------------------------------- */
function disputo_default_avatar ($avatar_defaults) {
    $default_avatar = get_theme_mod('disputo_default_avatar');
    if ($default_avatar) {
        $avatar_defaults[$default_avatar] = 'Disputo Avatar';
    }
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'disputo_default_avatar' );

/* ---------------------------------------------------------
Check verified user
----------------------------------------------------------- */

function disputo_verified_check($disputo_user_id) {
    global $wpdb;   
    $query = $wpdb->get_var( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}usermeta 
					WHERE meta_key = 'disputo_verified_user'
					AND meta_value = 'yes' AND user_id = '%s'", $disputo_user_id ) );	
    if ($query) {
        $return = 'verified';
    }
    else {
        $return = 'no-verified'; 
    }
    return $return;
}

/* ---------------------------------------------------------
Custom Avatar
----------------------------------------------------------- */

$disputo_bbpress_user_img = get_theme_mod('disputo_bbpress_user_img');
$disputo_bbpress_user_avatar = get_theme_mod('disputo_bbpress_user_avatar');
$disputo_bbpress_visual_media = get_theme_mod('disputo_bbpress_visual_media');

function disputo_gravatar_filter($avatar, $id_or_email, $size, $default, $alt) {
    $email = is_object( $id_or_email ) ? $id_or_email->comment_author_email : $id_or_email;
	if( is_email( $email ) && ! email_exists( $email ) ) {
		return $avatar;
    }
	
	$custom_avatar = get_user_meta($id_or_email, 'disputo_cmb2_user_avatar' );
    $custom_avatar_img = wp_get_attachment_image_src( get_user_meta( $id_or_email, 'disputo_cmb2_user_avatar_id', 1 ), 'thumbnail' );
    
	if ($custom_avatar) {
        $return = '<img class="avatar" src="' . $custom_avatar_img[0] . '" width="' . $size . '" height="' . $size . '" alt="' . $alt . '" />';
    } elseif ($avatar) {
		$return = $avatar;
    } else {
		$return = '<img class="avatar" src="' . $default . '" width="' . $size . '" height="' . $size . '" alt="' . $alt . '" />';
    }
	return $return;
}

if ($disputo_bbpress_user_avatar) {
    add_filter('get_avatar', 'disputo_gravatar_filter', 10, 5);
}

/* ---------------------------------------------------------
Show only current user attachments
----------------------------------------------------------- */
function disputo_show_current_user_attachments( $query = array() ) {
    $user_id = get_current_user_id();
    if (!user_can( $user_id, 'publish_posts' )) {
        if($user_id) {
            $query['author'] = $user_id;
        }
        return $query;
    } else {
        return $query;
    }
}

/* ---------------------------------------------------------
Allow user uploads
----------------------------------------------------------- */			
function disputo_allow_user_uploads() {
    if ( current_user_can('subscriber') && !current_user_can('upload_files') ){
        $subscriber = get_role('subscriber');
        $subscriber->add_cap('upload_files');
    }
}

if ($disputo_bbpress_user_img || $disputo_bbpress_user_avatar || $disputo_bbpress_visual_media) {
    add_filter( 'ajax_query_attachments_args', 'disputo_show_current_user_attachments', 10, 1 );
    add_action('init', 'disputo_allow_user_uploads');
}

/* ---------------------------------------------------------
bbPress enable tinymce
----------------------------------------------------------- */

function disputo_bbp_tinymce_paste_plain_text( $plugins = array() ) {
    $plugins[] = 'paste';
    return $plugins;
}
add_filter( 'bbp_get_tiny_mce_plugins', 'disputo_bbp_tinymce_paste_plain_text' );

function disputo_bbp_visual_editor( $args = array() ) {
    $disputo_bbpress_visual = get_theme_mod('disputo_bbpress_visual');
    $disputo_bbpress_visual_teeny = get_theme_mod('disputo_bbpress_visual_teeny');
    $disputo_bbpress_visual_media = get_theme_mod('disputo_bbpress_visual_media');
    $disputo_bbpress_visual_html = get_theme_mod('disputo_bbpress_visual_html', 1);

    if ($disputo_bbpress_visual) {
        $disputo_bbpress_visual = true;
    } else {
        $disputo_bbpress_visual = false;
    }

    if ($disputo_bbpress_visual_teeny) {
        $disputo_bbpress_visual_teeny = true;
    } else {
        $disputo_bbpress_visual_teeny = false;
    }

    if ($disputo_bbpress_visual_media) {
        $disputo_bbpress_visual_media = true;
    } else {
        $disputo_bbpress_visual_media = false;
    }

    if ($disputo_bbpress_visual_html) {
        $disputo_bbpress_visual_html = true;
    } else {
        $disputo_bbpress_visual_html = false;
    }
    
    $args['tinymce'] = $disputo_bbpress_visual;
    $args['teeny'] = $disputo_bbpress_visual_teeny;
    $args['media_buttons'] = $disputo_bbpress_visual_media;
    $args['quicktags'] = $disputo_bbpress_visual_html;
    return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'disputo_bbp_visual_editor' );

/* ---------------------------------------------------------
bbPress Custom KSES Allowed Tags
----------------------------------------------------------- */

function disputo_bbpress_custom_kses_allowed_tags() {
	return array(
		// Links
		'a'          => array(
			'class'    => true,
			'href'     => true,
			'title'    => true,
			'rel'      => true,
			'class'    => true,
			'target'    => true,
		),
		// Quotes
		'blockquote' => array(
			'cite'     => true,
		),
		
		// Div
		'div' => array(
			'class'     => true,
		),
		
		// Span
		'span'             => array(
			'class'     => true,
		),
		
		// Code
		'code'       => array(),
		'pre'        => array(
			'class'  => true,
		),
		// Formatting
		'em'         => array(),
		'strong'     => array(),
		'del'        => array(
			'datetime' => true,
		),
		// Lists
		'ul'         => array(),
		'ol'         => array(
			'start'    => true,
		),
		'li'         => array(),
		// Images
		'img'        => array(
			'class'    => true,
			'src'      => true,
			'border'   => true,
			'alt'      => true,
			'height'   => true,
			'width'    => true,
		),
		// Tables
		'table'      => array(
			'align'    => true,
			'bgcolor'  => true,
			'border'   => true,
		),
		'tbody'      => array(
			'align'    => true,
			'valign'   => true,
		),
		'td'         => array(
			'align'    => true,
			'valign'   => true,
		),
		'tfoot'      => array(
			'align'    => true,
			'valign'   => true,
		),
		'th'         => array(
			'align'    => true,
			'valign'   => true,
		),
		'thead'      => array(
			'align'    => true,
			'valign'   => true,
		),
		'tr'         => array(
			'align'    => true,
			'valign'   => true,
		)
	);
}

add_filter( 'bbp_kses_allowed_tags', 'disputo_bbpress_custom_kses_allowed_tags' );

/* ---------------------------------------------------------
Ajax Filters
----------------------------------------------------------- */

function disputo_subcribe_ajax ($args = array() ) {
    if (bbp_is_single_topic()) {
        $args['after'] = '';
        $args['before'] = '';
    }
    return $args;
} 

add_filter('bbp_before_get_user_subscribe_link_parse_args', 'disputo_subcribe_ajax');

function disputo_favorite_ajax ($args = array() ) {
    if (bbp_is_single_topic()) {
        $args['after'] = '';
        $args['before'] = '';
        $args['favorite'] = '<i class="fa fa-heart"></i>';  
        $args['favorited'] = '<i class="fa fa-heart"></i>';
    }
    return $args;
} 

add_filter('bbp_before_get_user_favorites_link_parse_args', 'disputo_favorite_ajax');

/* ---------------------------------------------------------
Lead Topic Activation
----------------------------------------------------------- */

function disputo_lead_topic( $show_lead ) {
  $show_lead[] = 'true';
  return $show_lead;
}

$disputo_lead_topic = get_theme_mod('disputo_lead_topic', 1);
if ($disputo_lead_topic) { 
    add_filter('bbp_show_lead_topic', 'disputo_lead_topic' );
}

/* ---------------------------------------------------------
Forum Badges
----------------------------------------------------------- */

$disputo_badges = get_theme_mod('disputo_badges', 1);

function disputo_forum_badges() {
    if( bbp_is_forum_category() ) { ?>
        <span class="badge badge-success">
            <?php esc_html_e( 'Category', 'disputo' ); ?>
        </span>
    <?php }
    if (bbp_is_forum_private()) { ?>
        <span class="badge badge-warning">
            <?php esc_html_e( 'Private', 'disputo' ); ?>
        </span>
    <?php }
    if (bbp_is_forum_closed()) { ?>
        <span class="badge badge-danger">
            <?php esc_html_e( 'Closed', 'disputo' ); ?>
        </span>
    <?php }
    if (bbp_is_forum_hidden()) { ?>
        <span class="badge badge-secondary">
            <?php esc_html_e( 'Hidden', 'disputo' ); ?>
        </span>
    <?php }
}

if ($disputo_badges) { 
    add_filter('bbp_theme_after_forum_title', 'disputo_forum_badges' );
}

/* ---------------------------------------------------------
Topic Badges
----------------------------------------------------------- */

function disputo_topic_badges() {
    if( bbp_is_topic_sticky() ) { ?>
        <span class="badge badge-success">
            <?php esc_html_e( 'Sticky', 'disputo' ); ?>
        </span>
    <?php }
    if (bbp_is_topic_closed()) { ?>
        <span class="badge badge-danger">
            <?php esc_html_e( 'Closed', 'disputo' ); ?>
        </span>
    <?php }
}

if ($disputo_badges == true) {
    add_filter('bbp_theme_after_topic_title', 'disputo_topic_badges' );
}

/* ---------------------------------------------------------
Display bbPress forum, topic and reply ids in the dashboard
----------------------------------------------------------- */

/* Forums */

add_filter( 'manage_forum_posts_columns', 'disputo_forum_id_column', 99 );
add_action( 'manage_forum_posts_custom_column', 'disputo_forum_id_column_content', 99, 2 );

function disputo_forum_id_column( $columns ) {
   $columns['disputo_forum_id'] = 'ID';
   return $columns;
}

function disputo_forum_id_column_content( $column, $id ) {
  if( 'disputo_forum_id' == $column ) {
    echo esc_html($id);
  }
}

/* Topics */

add_filter( 'manage_topic_posts_columns', 'disputo_topic_id_column', 99 );
add_action( 'manage_topic_posts_custom_column', 'disputo_topic_id_column_content', 99, 2 );

function disputo_topic_id_column( $columns ) {
   $columns['disputo_topic_id'] = 'ID';
   return $columns;
}

function disputo_topic_id_column_content( $column, $id ) {
  if( 'disputo_topic_id' == $column ) {
    echo esc_html($id);
  }
}

/* Replies */

add_filter( 'manage_reply_posts_columns', 'disputo_reply_id_column', 99 );
add_action( 'manage_reply_posts_custom_column', 'disputo_reply_id_column_content', 99, 2 );

function disputo_reply_id_column( $columns ) {
   $columns['disputo_reply_id'] = 'ID';
   return $columns;
}

function disputo_reply_id_column_content( $column, $id ) {
  if( 'disputo_reply_id' == $column ) {
    echo esc_html($id);
  }
}

/* ---------------------------------------------------------
Popular Topics
----------------------------------------------------------- */

function disputo_popular_topics() {
    $disputo_popular_topic_at_most = get_theme_mod('disputo_popular_topic_at_most', 5);
    bbp_register_view( 'disputo-popular-topics', esc_html__( 'Popular Topics', 'disputo' ), array( 
        'meta_key' => '_bbp_reply_count',
        'posts_per_page' => $disputo_popular_topic_at_most,
        'max_num_pages' => '1', 
        'orderby' => 'meta_value_num' ), false );
}

add_action( 'bbp_register_views', 'disputo_popular_topics' );

/* ---------------------------------------------------------
Removes 'private' and 'protected' prefix for forums
----------------------------------------------------------- */

function disputo_remove_private_title($title) {
	return '%s';
}

function disputo_remove_protected_title($title) {
	return '%s';
}

add_filter('protected_title_format', 'disputo_remove_protected_title');
add_filter('private_title_format', 'disputo_remove_private_title');

/* ---------------------------------------------------------
Quote Topics & Replies
----------------------------------------------------------- */

function disputo_quote_topic($content) {
    if (function_exists('disputo_do_shortcode')) {
        return '<div id="disputo-quote-' . bbp_get_topic_id() . '" class="disputo-quote-wrapper">' . disputo_do_shortcode($content) . '</div>';
    }
}

function disputo_quote_reply($content) {
    if (function_exists('disputo_do_shortcode')) {
        return '<div id="disputo-quote-' . bbp_get_reply_id() . '" class="disputo-quote-wrapper">' . disputo_do_shortcode($content) . '</div>';
    }
}

$disputo_quote_check = get_theme_mod('disputo_bbpress_quote');

if ($disputo_quote_check) {
    add_filter('bbp_get_reply_content', 'disputo_quote_reply');
    add_filter('bbp_get_topic_content', 'disputo_quote_topic');
}

/* ---------------------------------------------------------
User search query var
----------------------------------------------------------- */

function disputo_register_user_query_var( $vars ) {
	$vars[] = 'bb_user';
	return $vars;
}
add_filter( 'query_vars', 'disputo_register_user_query_var' );

/* ---------------------------------------------------------
Custom role names
----------------------------------------------------------- */

function disputo_custom_role_names() {

    $disputo_keymaster = get_theme_mod('disputo_role_keymaster');
    $disputo_moderator = get_theme_mod('disputo_role_moderator');
    $disputo_participant = get_theme_mod('disputo_role_participant');
    $disputo_spectator = get_theme_mod('disputo_role_spectator');
    $disputo_blocked = get_theme_mod('disputo_role_blocked');

    if (empty($disputo_keymaster)) {
        $disputo_keymaster = esc_html__( 'Keymaster', 'disputo');
    }

    if (empty($disputo_moderator)) {
        $disputo_moderator = esc_html__( 'Moderator', 'disputo');
    }

    if (empty($disputo_participant)) {
        $disputo_participant = esc_html__( 'Participant', 'disputo');
    }

    if (empty($disputo_spectator)) {
        $disputo_spectator = esc_html__( 'Spectator', 'disputo');
    }

    if (empty($disputo_blocked)) {
        $disputo_blocked = esc_html__( 'Blocked', 'disputo');
    }

    return array(  
        // Keymaster 
        bbp_get_keymaster_role() => array(
        'name' => $disputo_keymaster,
        'capabilities' => bbp_get_caps_for_role( bbp_get_keymaster_role() )
        ),
        
        // Moderator
        bbp_get_moderator_role() => array(
        'name' => $disputo_moderator,
        'capabilities' => bbp_get_caps_for_role( bbp_get_moderator_role() )
        ),
        
        // Participant
        bbp_get_participant_role() => array(
        'name' => $disputo_participant,
        'capabilities' => bbp_get_caps_for_role( bbp_get_participant_role() )
        ),
        
        // Spectator
        bbp_get_spectator_role() => array(
        'name' => $disputo_spectator,
        'capabilities' => bbp_get_caps_for_role( bbp_get_spectator_role() )
        ),
        
        // Blocked
        bbp_get_blocked_role() => array(
        'name' => $disputo_blocked,
        'capabilities' => bbp_get_caps_for_role( bbp_get_blocked_role() )
        )
    );
}
    
add_filter( 'bbp_get_dynamic_roles', 'disputo_custom_role_names', 999 );
?>