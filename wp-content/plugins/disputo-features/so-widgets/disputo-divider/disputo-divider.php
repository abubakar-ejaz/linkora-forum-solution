<?php
/*
Widget Name: Disputo Divider
Description: Displays a horizontal line
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_divider_widget extends SiteOrigin_Widget {
	function __construct() {
        $form_options = array(
            'margintop' => array(
				'type' => 'number',
				'label' => esc_html__('Margin Top', 'disputo'),
				'default' => '40'
            ),
            'marginbottom' => array(
				'type' => 'number',
				'label' => esc_html__('Margin Bottom', 'disputo'),
				'default' => '40'
            ),
            'bgcolor' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color', 'disputo' ),
				'default' => '#dddddd'
			),
            'thickness' => array(
				'type' => 'slider',
				'label' => esc_html__( 'Thickness', 'disputo' ),
				'default' => 1,
				'min' => 0,
				'max' => 10
			),
            'fullwidth' => array(
                'type' => 'checkbox',
				'label' => esc_html__( 'Full Width Column', 'disputo' ),
				'default' => false
			 )
		);

		parent::__construct(
			'disputo-divider',
			esc_html__('Disputo Divider', 'disputo'),
			array(
				'description' => esc_html__('Displays a horizontal line', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-minus'),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-divider-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-divider', __FILE__, 'disputo_divider_widget');
?>