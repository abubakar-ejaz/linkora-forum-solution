<?php
/*
Widget Name: Disputo Accordion
Description: Displays an accordion
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_accordion_widget extends SiteOrigin_Widget {
	function __construct() {
        $form_options = array(
            'a_repeater' => array(
                'type' => 'repeater',
                'label' => esc_html__( 'Accordion' , 'disputo' ),
                'item_name'  => esc_html__( 'Accordion item', 'disputo' ),
                'fields' => array(
                    'title' => array(
                        'type' => 'text',
                        'label' => esc_html__( 'Title', 'disputo' )
                    ),
                    'icon' => array(
                        'type' => 'icon',
                        'label' => esc_html__('Select an icon', 'disputo'),
                    ),
                    'text' => array(
				        'type' => 'tinymce',
				        'label' => esc_html__( 'Text', 'disputo' ),
				        'default' => '',
				        'rows' => 10
			         ),
                    'status' => array(
				        'type' => 'checkbox',
				        'label' => esc_html__( 'Opened by default', 'disputo' ),
				            'default' => false
                    ),
                )
            )
        );

		parent::__construct(
			'disputo-accordion',
			esc_html__('Disputo Accordion', 'disputo'),
			array(
				'description' => esc_html__('Displays an accordion', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-editor-justify'),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-accordion-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-accordion', __FILE__, 'disputo_accordion_widget');
?>