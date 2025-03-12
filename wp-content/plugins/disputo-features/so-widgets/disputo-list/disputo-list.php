<?php
/*
Widget Name: Disputo List
Description: Displays forums, topics, replies, posts, products or pages in a list
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_post_list_widget extends SiteOrigin_Widget {
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
                    )
        );

		parent::__construct(
			'disputo-list',
			esc_html__('Disputo List', 'disputo'),
			array(
				'description' => esc_html__('Displays forums, topics, replies, posts, products or pages in a list', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-admin-post '),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-list-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-list', __FILE__, 'disputo_post_list_widget');
?>