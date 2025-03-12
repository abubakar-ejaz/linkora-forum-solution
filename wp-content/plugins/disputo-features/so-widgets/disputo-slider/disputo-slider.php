<?php
/*
Widget Name: Disputo Slider
Description: Displays forums, posts, products or pages in a slider
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_post_slider_widget extends SiteOrigin_Widget {
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
                            'headinglevel' => array(
				                'type' => 'select',
				                'label' => esc_html__( 'Heading Level', 'disputo' ),
				                'default' => 'h3',
				                'options' => array(
                                    'h1' => esc_html__( 'Heading 1', 'disputo' ),
                                    'h2' => esc_html__( 'Heading 2', 'disputo' ),
                                    'h3' => esc_html__( 'Heading 3', 'disputo' ),
                                    'h4' => esc_html__( 'Heading 4', 'disputo' ),
                                    'h5' => esc_html__( 'Heading 5', 'disputo' ),
                                    'h6' => esc_html__( 'Heading 6', 'disputo' )
                                )
                            )
                        ),
                    ),
                    'c_section' => array(
                        'type' => 'section',
                        'label' => esc_html__( 'Slider Settings' , 'disputo' ),
                        'hide' => true,
                        'fields' => array(
                            'size' => array(
				                'type' => 'select',
				                'label' => esc_html__( 'Image Size', 'disputo' ),
				                'default' => 'disputo-hero',
				                'options' => array(
                                    'disputo-hero' => esc_html__( '1300x650 px', 'disputo' ),
                                    'disputo-thumbnail' => esc_html__( '640x480 px', 'disputo' ),
                                    'full' => esc_html__( 'Full', 'disputo' ),
                                    'large' => esc_html__( 'Large', 'disputo' ),
                                    'medium' => esc_html__( 'Medium', 'disputo' )
				                )
			                 ),
                            'autoplay' => array(
				                'type' => 'checkbox',
				                'label' => esc_html__( 'Autoplay on', 'disputo' ),
				                'default' => false
			                 ),
                            'duration' => array(
                                'type' => 'number',
                                'label' => esc_html__('Autoplay Duration (Seconds)', 'disputo'),
                                'default' => '5'
                            ),
                            'fade' => array(
				                'type' => 'checkbox',
				                'label' => esc_html__( 'Fade Animation', 'disputo' ),
				                'default' => false
			                 ),
                        )
                    ),
                    'd_section' => array(
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
			'disputo-slider',
			esc_html__('Disputo Slider', 'disputo'),
			array(
				'description' => esc_html__('Displays forums, posts, products or pages in a slider', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-admin-post '),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-slider-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-slider', __FILE__, 'disputo_post_slider_widget');
?>