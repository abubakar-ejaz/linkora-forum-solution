<?php
/* ---------------------------------------------------------
Page Title
----------------------------------------------------------- */

function disputo_page_title_cmb2 ( $meta_boxes ) {
    $prefix = 'disputo_cmb2'; // Prefix for all fields
    $meta_boxes['disputo_pagetitle'] = array(
        'id' => 'disputo_pagetitle',
        'title' => esc_html__( 'Show Title', 'disputo'),
        'object_types' => array('page','post'), // post type
        'context' => 'side', // normal or side
        'priority' => 'high', // default or high
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name'    => esc_html__( 'Show title', 'disputo'),
                'desc'    => '',
                'id'      => $prefix . '_pagetitle',
                'type'    => 'radio_inline',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'disputo' ),
                    'no'   => esc_html__( 'No', 'disputo' ),
                ),
                'default' => 'yes'
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'disputo_page_title_cmb2' );

/* ---------------------------------------------------------
Hide featured image
----------------------------------------------------------- */

function disputo_hide_featured_cmb2 ( $meta_boxes ) {
    $prefix = 'disputo_cmb2'; // Prefix for all fields
    $meta_boxes['disputo_hide_fe'] = array(
        'id' => 'disputo_hide_fe',
        'title' => esc_html__( 'Hide featured image', 'disputo'),
        'object_types' => array('page','post'), // post type
        'context' => 'side', // normal or side
        'priority' => 'default', // default or high
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name'    => esc_html__( 'Hide featured image', 'disputo'),
                'desc'    => '',
                'id'      => $prefix . '_hide_featured',
                'type'    => 'radio_inline',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'disputo' ),
                    'no'   => esc_html__( 'No', 'disputo' ),
                ),
                'default' => 'no'
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'disputo_hide_featured_cmb2' );

/* ---------------------------------------------------------
Subtitle
----------------------------------------------------------- */

function disputo_subtitle_cmb2 ( $meta_boxes ) {
    $prefix = 'disputo_cmb2'; // Prefix for all fields
    $meta_boxes['disputo_subtitle'] = array(
        'id' => 'disputo_subtitle',
        'title' => esc_html__( 'Subtitle', 'disputo'),
        'object_types' => array('page','post'), // post type
        'context' => 'normal', // normal or side
        'priority' => 'high', // default or high
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name'    => esc_html__( 'Subtitle (Optional)', 'disputo'),
                'desc'    => '',
                'id'      => $prefix . '_subtitle',
                'type'    => 'text'
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'disputo_subtitle_cmb2' );

/* ---------------------------------------------------------
Header Image
----------------------------------------------------------- */

function disputo_bg_image_cmb2 ( $meta_boxes ) {
    $prefix = 'disputo_cmb2'; // Prefix for all fields
    $meta_boxes['disputo_bg_image'] = array(
        'id' => 'disputo_bg_image',
        'title' => esc_html__( 'Cover Image', 'disputo'),
        'object_types' => array('post','page','forum','product'), // post type
        'context' => 'normal', // normal or side
        'priority' => 'default', // default or high
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name' => esc_html__( 'Image', 'disputo'),
                'desc' => esc_html__( 'You can change default background image from theme settings.', 'disputo'),
                'id' => $prefix . '_bg_image',
                'type' => 'file'
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'disputo_bg_image_cmb2' );

/* ---------------------------------------------------------
Cover Image
----------------------------------------------------------- */

function disputo_cat_cover_cmb2 ( $meta_boxes ) {
    $prefix = 'disputo_cmb2'; // Prefix for all fields
    $meta_boxes['disputo_catcover'] = array(
        'id' => 'disputo_catcover',
        'title' => esc_html__( 'Cover Image', 'disputo'),
        'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
        'taxonomies' => array( 'category', 'product_cat' ), // Tells CMB2 which taxonomies should have these fields
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name' => esc_html__( 'Cover Image', 'disputo'),
                'desc' => '',
                'id' => $prefix . '_cat_cover_image',
                'type' => 'file'
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'disputo_cat_cover_cmb2' );

/* ---------------------------------------------------------
User Images
----------------------------------------------------------- */

function disputo_user_cover_cmb2 () {
    $disputo_bbpress_user_img = get_theme_mod('disputo_bbpress_user_img');
    $disputo_bbpress_flags = get_theme_mod('disputo_bbpress_flags');
    $disputo_bbpress_user_avatar = get_theme_mod('disputo_bbpress_user_avatar');
    $disputo_bbpress_social_icons = get_theme_mod('disputo_bbpress_social_icons');
    $disputo_bbpress_signature = get_theme_mod('disputo_bbpress_signature');
    $prefix = 'disputo_cmb2'; // Prefix for all fields
    $disputo_cmb2 = new_cmb2_box( array(
        'id' => 'disputo_usercover',
        'title' => esc_html__( 'Cover Image', 'disputo'),
        'object_types' => array( 'user' ),
        'show_names' => true, // Show field names on the left
        'cmb_styles' => true
    ));
    $disputo_cmb2->add_field( array(
		'name'     => esc_html__( 'Additional Fields', 'disputo'),
		'id'       => $prefix . 'additional_title',
		'type'     => 'title',
		'on_front' => false,
	));
    $disputo_cmb2->add_field( array(
        'name' => esc_html__( 'Date of Birth', 'disputo'),
        'id'   => $prefix . '_date_of_birth',
        'type' => 'text_date',
        'attributes' => array(
            'data-datepicker' => json_encode( array(
			'yearRange' => '1950:'. date( 'Y' )
            ))
        ),
    ));
    $disputo_cmb2->add_field( array(
        'name'    => esc_html__( 'Gender', 'disputo'),
        'desc'    => '',
        'id'      => $prefix . '_gender',
        'type'    => 'radio_inline',
        'options' => array(
            'male' => esc_html__( 'Male', 'disputo' ),
            'female'   => esc_html__( 'Female', 'disputo' ),
        ),
        'default' => ''
    ));
    $disputo_cmb2->add_field( array(
        'name'    => esc_html__( 'Location', 'disputo'),
        'desc'    => '',
        'id'      => $prefix . '_location',
        'type'    => 'text'
    ));
    if (($disputo_bbpress_flags) && (function_exists( 'disputo_flags_array' ))) {
        $disputo_cmb2->add_field( array(
        'name'    => esc_html__( 'Flag', 'disputo'),
        'desc'    => '',
        'id'      => $prefix . '_flag',
        'type'    => 'select',
        'options' => disputo_flags_array(),
        'default' => ''
        ));
    }
    if ($disputo_bbpress_user_avatar) {
    $disputo_cmb2->add_field( array(
        'name' => esc_html__( 'Avatar', 'disputo'),
        'desc' => esc_html__( 'Recommended avatar size is 150x150 px.', 'disputo'),
        'id' => $prefix . '_user_avatar',
        'type' => 'file',
        'options' => array(
            'url' => false
        ),
        'text'    => array(
            'add_upload_file_text' => esc_html__( 'Upload Image', 'disputo')
        ),
        'preview_size' => 'thumbnail',
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png'
                ) 
            ),
        )
    );
    }
    if ($disputo_bbpress_user_img) {
    $disputo_cmb2->add_field( array(
        'name' => esc_html__( 'Cover Image', 'disputo'),
        'desc' => '',
        'id' => $prefix . '_user_cover_image',
        'type' => 'file',
        'options' => array(
            'url' => false
        ),
        'text'    => array(
            'add_upload_file_text' => esc_html__( 'Upload Image', 'disputo')
        ),
        'preview_size' => 'medium',
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png'
                ) 
            ),
        )
    );
    }
    if ($disputo_bbpress_signature) {
    $disputo_cmb2->add_field( array(
        'name' => esc_html__( 'Forum Signature', 'disputo'),
        'id'   => $prefix . '_forum_signature',
        'type'    => 'wysiwyg',
        'options' => array(
            'wpautop' => true,
            'media_buttons' => false,
            'teeny' => true,
            'textarea_rows' => 10,
            'quicktags' => false
	   ),
    ));
    }
    if ($disputo_bbpress_social_icons) {
    $disputo_cmb2->add_field( array(
		'name'     => esc_html__( 'Social Media Icons', 'disputo'),
		'id'       => $prefix . 'social_title',
		'type'     => 'title',
		'on_front' => true,
	) );
    $disputo_cmb2->add_field(
            array(
            'id' => $prefix . 'user_icons',
            'type' => 'group',
            'options' => array(
                'group_title'   => esc_html__( 'Icon {#}', 'disputo' ),
                'add_button' => esc_html__( 'Add Another Icon', 'disputo' ),
                'remove_button' => esc_html__( 'Remove Icon', 'disputo' ),
                'sortable' => true,
                'closed'     => true,
            ),
            'fields' => array(
				array(
                    'name' => esc_html__( 'Select Icon:', 'disputo'),
                    'id' => $prefix . 'iconimg',
                    'desc' => '',
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Select Icon', 'disputo' ),
                        'facebook-f' => esc_html__( 'Facebook', 'disputo' ),
                        'twitter' => esc_html__( 'Twitter', 'disputo' ),
                        'google-plus' => esc_html__( 'Google +', 'disputo' ),
                        'google' => esc_html__( 'Google', 'disputo' ),
                        'linkedin' => esc_html__( 'Linkedin', 'disputo' ),
                        'instagram' => esc_html__( 'Instagram', 'disputo' ),
                        'vimeo' => esc_html__( 'Vimeo', 'disputo' ),
                        'youtube' => esc_html__( 'You Tube', 'disputo' ),
                        'apple' => esc_html__( 'Apple', 'disputo' ),
                        'android' => esc_html__( 'Android', 'disputo' ),
                        'dribbble' => esc_html__( 'Dribbble', 'disputo' ),
                        'flickr' => esc_html__( 'Flickr', 'disputo' ),
                        'pinterest' => esc_html__( 'Pinterest', 'disputo' ),
                        'vk' => esc_html__( 'VK', 'disputo' ),
                        'codepen' => esc_html__( 'Codepen', 'disputo' ),
                        'snapchat-ghost' => esc_html__( 'Snapchat', 'disputo' ),
                        'delicious' => esc_html__( 'Delicious', 'disputo' ),
                        'github' => esc_html__( 'Github', 'disputo' ),
                        'reddit-alien' => esc_html__( 'Reddit', 'disputo' ),
                        'tumblr' => esc_html__( 'Tumblr', 'disputo' ),     
                        'twitch' => esc_html__( 'Twitch', 'disputo' ),
                        'tripadvisor' => esc_html__( 'Trip Advisor', 'disputo' ),
                        'vine' => esc_html__( 'Vine', 'disputo' ),
                        'foursquare' => esc_html__( 'Foursquare', 'disputo' ),
                        'lastfm' => esc_html__( 'Lastfm', 'disputo' ),
                        'soundcloud' => esc_html__( 'Soundcloud', 'disputo' ),
                        'deviantart' => esc_html__( 'Deviantart', 'disputo' ),
                        'odnoklassniki' => esc_html__( 'Odnoklassniki', 'disputo' ),
                        'spotify' => esc_html__( 'Spotify', 'disputo' ),
                        'xing' => esc_html__( 'Xing', 'disputo' ),
                        'amazon' => esc_html__( 'Amazon', 'disputo' ),
                        'digg' => esc_html__( 'Digg', 'disputo' ),
                        'etsy' => esc_html__( 'Etsy', 'disputo' ),
                        'behance' => esc_html__( 'Behance', 'disputo' ),
                        'slack' => esc_html__( 'Slack', 'disputo' ),
                        'paper-plane' => esc_html__( 'Email', 'disputo' ),
                    ),
                ),
                array(
                    'name' => esc_html__( 'Link:', 'disputo'),
                    'desc' => esc_html__( 'Example; http://www.facebook.com', 'disputo'),
                    'id' => $prefix . 'iconlink',
                    'type' => 'text_url'
                ),
            ),
        ));
    }
}

add_action( 'cmb2_init', 'disputo_user_cover_cmb2' );

/* ---------------------------------------------------------
Topic verified user restriction
----------------------------------------------------------- */

function disputo_topic_verified_cmb2 ( $meta_boxes ) {
    $prefix = 'disputo_cmb2'; // Prefix for all fields
    $meta_boxes['disputo_topic_verified'] = array(
        'id' => 'disputo_topic_verified',
        'title' => esc_html__( 'Only for Verified Users', 'disputo'),
        'object_types' => array('forum','topic'), // post type
        'context' => 'side', // normal or side
        'priority' => 'default', // default or high
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name'    => esc_html__( 'Hide featured image', 'disputo'),
                'desc'    => '',
                'id'      => $prefix . '_topic_verified',
                'type'    => 'radio_inline',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'disputo' ),
                    'no'   => esc_html__( 'No', 'disputo' ),
                ),
                'default' => 'no'
            )
        ),
    );

    return $meta_boxes;
}

add_filter( 'cmb2_meta_boxes', 'disputo_topic_verified_cmb2' );
?>