<?php
/*
Widget Name: Disputo Forums
Description: Displays bbPress forums
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_forums_widget extends SiteOrigin_Widget {
	function __construct() {
        $form_options = array(
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
			 ),
            'thumbnails' => array(
                'type' => 'checkbox',
                'label' => esc_html__( 'Hide Thumbnails (Forum Index)', 'disputo' ),
                'default' => false
            ),
            'breadcrumbs' => array(
                'type' => 'checkbox',
                'label' => esc_html__( 'Hide Breadcrumb (Forum Index)', 'disputo' ),
                'default' => true
            ),
            'search' => array(
                'type' => 'checkbox',
                'label' => esc_html__( 'Hide Search Box (Forum Index)', 'disputo' ),
                'default' => true
            ),
            'maxtopics' => array(
                'type' => 'text',
                'label' => esc_html__('Maximum number of topics (Single Forum)', 'disputo'),
                'default' => '5'
            ),
            'forums' => array(
				'type' => 'forum-select',
				'label' => '',
				'default' => ''
            )
		);

		parent::__construct(
			'disputo-forums',
			esc_html__('Disputo Forums', 'disputo'),
			array(
				'description' => esc_html__('Displays bbPress forums', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-bbpress-logo green-icon'),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-forums-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-forums', __FILE__, 'disputo_forums_widget');
?>