<?php
/*
Widget Name: Disputo Tabs
Description: Displays a tabs
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_tabs_widget extends SiteOrigin_Widget {
	function __construct() {
        $form_options = array(
            'a_repeater' => array(
                'type' => 'repeater',
                'label' => esc_html__( 'Tabs' , 'disputo' ),
                'item_name'  => esc_html__( 'Tab', 'disputo' ),
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
			         )
                )
            )
        );

		parent::__construct(
			'disputo-tabs',
			esc_html__('Disputo Tabs', 'disputo'),
			array(
				'description' => esc_html__('Displays a tabs', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-index-card'),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-tabs-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-tabs', __FILE__, 'disputo_tabs_widget');
?>