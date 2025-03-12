<?php
/*
Widget Name: Disputo Popular Topics
Description: Displays popular topics
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_populartopics_widget extends SiteOrigin_Widget {
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
			 ) 
		);

		parent::__construct(
			'disputo-populartopics',
			esc_html__('Disputo Popular Topics', 'disputo'),
			array(
				'description' => esc_html__('Displays popular topics', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-bbpress-logo green-icon'),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-populartopics-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-populartopics', __FILE__, 'disputo_populartopics_widget');
?>