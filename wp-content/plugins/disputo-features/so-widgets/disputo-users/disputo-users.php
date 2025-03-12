<?php
/*
Widget Name: Disputo Users
Description: Displays users in a grid
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_users_widget extends SiteOrigin_Widget {
	function __construct() {
        $form_options = array(
            'a_section' => array(
                'type' => 'section',
                'label' => esc_html__( 'Title & Subtitle' , 'disputo' ),
                'hide' => true,
                    'fields' => array(
                        'heading' => array(
                            'type' => 'text',
                            'label' => esc_html__('Heading', 'disputo'),
                            'default' => ''
                        ),
                        'headinglevel' => array(
				            'type' => 'select',
				            'label' => esc_html__( 'Heading Level', 'disputo' ),
				            'default' => 'h1',
				            'options' => array(
                                'h1' => esc_html__( 'Heading 1', 'disputo' ),
                                'h2' => esc_html__( 'Heading 2', 'disputo' ),
                                'h3' => esc_html__( 'Heading 3', 'disputo' ),
                                'h4' => esc_html__( 'Heading 4', 'disputo' ),
                                'h5' => esc_html__( 'Heading 5', 'disputo' ),
                                'h6' => esc_html__( 'Heading 6', 'disputo' )
				                )
			                 )    
                        )
                    ),
                    'b_section' => array(
                        'type' => 'section',
                        'label' => esc_html__( 'Settings' , 'disputo' ),
                        'hide' => false,
                        'fields' => array(
                            'columns' => array(
				                'type' => 'select',
				                'label' => esc_html__( 'Layout', 'disputo' ),
				                'default' => 'disputo-three-columns',
				                'options' => array(
                                    'disputo-one-column' => esc_html__( '1 Column (Masonry Grid)', 'disputo' ),
                                    'disputo-two-columns' => esc_html__( '2 Column (Masonry Grid)', 'disputo' ),
                                    'disputo-three-columns' => esc_html__( '3 Column (Masonry Grid)', 'disputo' ),
                                    'disputo-four-columns' => esc_html__( '4 Column (Masonry Grid)', 'disputo' ),
                                    'disputo-five-columns' => esc_html__( '5 Column (Masonry Grid)', 'disputo' ),
                                    'thumbnail-grid-12' => esc_html__( 'Thumbnail Grid (12-6-4)', 'disputo' ),
                                    'thumbnail-grid-10' => esc_html__( 'Thumbnail Grid (10-5-5)', 'disputo' ),
                                    'thumbnail-grid-9' => esc_html__( 'Thumbnail Grid (9-6-6)', 'disputo' ),
                                    'thumbnail-grid-8' => esc_html__( 'Thumbnail Grid (8-6-4)', 'disputo' ),
                                    'thumbnail-grid-6' => esc_html__( 'Thumbnail Grid (6-4-3)', 'disputo' ),
                                    'thumbnail-grid-4' => esc_html__( 'Thumbnail Grid (4-2-2)', 'disputo' ),
				                )
                            ),
                            'thumb_size' => array(
				                'type' => 'select',
				                'label' => esc_html__( 'Thumbnail Size', 'disputo' ),
				                'default' => 512,
				                'options' => array(
                                    512 => esc_html__( '512px', 'disputo' ),
                                    300 => esc_html__( '300px', 'disputo' ),
                                    150 => esc_html__( '150px', 'disputo' )
				                )
                            ),
                            'thumb_border_radius' => array(
				                'type' => 'select',
				                'label' => esc_html__( 'Thumbnail Border Radius', 'disputo' ),
				                'default' => 'circle',
				                'options' => array(
                                    'square' => esc_html__( 'Square', 'disputo' ),
                                    'rounded' => esc_html__( 'Rounded', 'disputo' ),
                                    'circle' => esc_html__( 'Circle', 'disputo' )
				                )
                            ),
                            'thumbnail_grid_gap' => array(
                                'type' => 'number',
                                'label' => esc_html__('Thumbnail Gap  (Thumbnail Grid)', 'disputo'),
                                'default' => 0
                            ),
                            'orderby' => array(
				                'type' => 'select',
				                'label' => esc_html__( 'Order by', 'disputo' ),
				                'default' => 'titleasc',
				                'options' => array(
                                    'titleasc' => esc_html__( 'Alphabetical ASC (All Users)', 'disputo' ),
                                    'titledesc' => esc_html__( 'Alphabetical DESC (All Users)', 'disputo' ),
                                    'new' => esc_html__( 'New (All Users)', 'disputo' ),
                                    'old' => esc_html__( 'Old (All Users)', 'disputo' ),
                                    'topics' => esc_html__( 'Most Topics', 'disputo' ),
                                    'replies' => esc_html__( 'Most Replies', 'disputo' ),
                                    'active' => esc_html__( 'Active', 'disputo' ),
                                    'online' => esc_html__( 'Online', 'disputo' )
				                )
                            ),
                            'limit' => array(
                                'type' => 'number',
                                'label' => esc_html__('Limit', 'disputo'),
                                'default' => 12
                            ),
                            'pagination' => array(
				                'type' => 'checkbox',
				                'label' => esc_html__( 'Pagination ("orderby" must be Alphabetical, New or Old)', 'disputo' ),
				                'default' => false
                            ),
                            'exclude' => array(
                                'type' => 'text',
                                'label' => esc_html__('Exclude users by ID', 'disputo'),
                                'description' => esc_html__( 'You can find user IDs at Users page. To exclude multiple users, add comma between IDs.', 'disputo' )
                            ),
                            'verified' => array(
				                'type' => 'checkbox',
				                'label' => esc_html__( 'Only Verified Users', 'disputo' ),
				                'default' => false
                            ),
                        )
                    ),
            'c_section' => array(
                'type' => 'section',
                'label' => esc_html__( 'Fields (Masonry Grid)' , 'disputo' ),
                'hide' => true,
                    'fields' => array(
                        'avatar' => array(
				            'type' => 'checkbox',
				            'label' => esc_html__( 'Avatar', 'disputo' ),
				            'default' => true
                        ),
                        'role' => array(
				            'type' => 'checkbox',
				            'label' => esc_html__( 'Role', 'disputo' ),
				            'default' => true
                        ),
                        'bio' => array(
				            'type' => 'checkbox',
				            'label' => esc_html__( 'Biography', 'disputo' ),
				            'default' => false
                        ),
                        'statistics' => array(
				            'type' => 'checkbox',
				            'label' => esc_html__( 'Statistics', 'disputo' ),
				            'default' => true
                        ),
                        'flag' => array(
				            'type' => 'checkbox',
				            'label' => esc_html__( 'Flag', 'disputo' ),
				            'default' => false
                        ),
                        'register' => array(
				            'type' => 'checkbox',
				            'label' => esc_html__( 'Register date', 'disputo' ),
				            'default' => true
                        ),
                    )
                ),
        );

		parent::__construct(
			'disputo-users',
			esc_html__('Disputo Users', 'disputo'),
			array(
				'description' => esc_html__('Displays users in a masonry grid', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-admin-users '),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-users-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-users', __FILE__, 'disputo_users_widget');
?>