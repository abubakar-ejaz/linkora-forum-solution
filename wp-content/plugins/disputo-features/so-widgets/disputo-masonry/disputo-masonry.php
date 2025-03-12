<?php
/*
Widget Name: Disputo Masonry
Description: Displays forums, topics, replies, products, posts or pages in a grid
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_masonry_widget extends SiteOrigin_Widget {
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
                        'label' => esc_html__( 'Post Settings' , 'disputo' ),
                        'hide' => false,
                        'fields' => array(
                            'posts' => array(
				                'type' => 'posts',
                                'label' => esc_html__('Select Posts', 'disputo')
                             ),
                             'verified' => array(
				                'type' => 'checkbox',
				                'label' => esc_html__( 'Only Verified Users', 'disputo' ),
				                'default' => false
                            ),
                            'columns' => array(
				                'type' => 'select',
				                'label' => esc_html__( 'Columns', 'disputo' ),
				                'default' => 'disputo-three-columns',
				                'options' => array(
                                    'disputo-one-column' => esc_html__( '1 Column', 'disputo' ),
                                    'disputo-two-columns' => esc_html__( '2 Column', 'disputo' ),
                                    'disputo-three-columns' => esc_html__( '3 Column', 'disputo' ),
                                    'disputo-four-columns' => esc_html__( '4 Column', 'disputo' )
				                )
                            )
                        )
                    ),
                    'c_section' => array(
                        'type' => 'section',
                        'label' => esc_html__( 'Button Settings' , 'disputo' ),
                        'hide' => true,
                        'fields' => array(
                            'buttontext' => array(
                                'type' => 'text',
                                'label' => esc_html__('Button Text', 'disputo'),
                                'default' => esc_html__( 'VIEW ALL', 'disputo' )
                            ),
                            'viewmore' => array(
                                'type' => 'link',
                                'label' => esc_html__('Destination Url (To disable button, leave it blank)', 'disputo'),
                                'default' => ''
                            )
                        )
                    )
        );

		parent::__construct(
			'disputo-masonry',
			esc_html__('Disputo Masonry', 'disputo'),
			array(
				'description' => esc_html__('Displays forums, topics, replies, products, posts or pages in a grid', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-admin-post '),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-masonry-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-masonry', __FILE__, 'disputo_masonry_widget');
?>