<?php
/*
Widget Name: Disputo Carousel
Description: Displays forums, topics, replies, posts, products or pages in a carousel
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_post_carousel_widget extends SiteOrigin_Widget {
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
                        )
                    ),
                    'c_section' => array(
                        'type' => 'section',
                        'label' => esc_html__( 'Carousel Settings' , 'disputo' ),
                        'hide' => true,
                        'fields' => array(
                            'columns' => array(
				                'type' => 'select',
				                'label' => esc_html__( 'Columns', 'disputo' ),
				                'default' => 'threecolumns',
				                'options' => array(
                                    'onecolumn' => esc_html__( '1 Column', 'disputo' ),
                                    'twocolumns' => esc_html__( '2 Column', 'disputo' ),
                                    'threecolumns' => esc_html__( '3 Column', 'disputo' ),
                                    'fourcolumns' => esc_html__( '4 Column', 'disputo' ),
                                    'fivecolumns' => esc_html__( '5 Column', 'disputo' )
				                )
                            )
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
			'disputo-carousel',
			esc_html__('Disputo Carousel', 'disputo'),
			array(
				'description' => esc_html__('Displays forums, topics, replies, posts, products or pages in a carousel', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-admin-post '),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-carousel-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-carousel', __FILE__, 'disputo_post_carousel_widget');
?>