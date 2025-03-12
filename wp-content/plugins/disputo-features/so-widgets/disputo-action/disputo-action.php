<?php
/*
Widget Name: Disputo Call to Action
Description: A simple call-to-action widget
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_action_widget extends SiteOrigin_Widget {
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
            'text' => array(
                'type' => 'textarea',
				'label' => esc_html__( 'Text', 'disputo' ),
				'default' => '',
				'rows' => 5
			 ),
            'buttontext' => array(
                'type' => 'text',
                'label' => esc_html__('Button Text', 'disputo'),
                'default' => esc_html__( 'CLICK HERE', 'disputo' )
            ),
            'destination' => array(
                'type' => 'link',
                'label' => esc_html__('Destination Url (To disable button, leave it blank)', 'disputo'),
                'default' => ''
            ),
            'newtab' => array(
                'type' => 'checkbox',
				'label' => esc_html__( 'Open in link in a new tab', 'disputo' ),
				'default' => false
			 ),
            'position' => array(
                'type' => 'radio',
                'label' => esc_html__( 'Button Alignment', 'disputo' ),
                'default' => 'horizontal',
                'options' => array(
                    'horizontal' => esc_html__( 'Horizontal', 'disputo' ),
                    'vertical' => esc_html__( 'Vertical', 'disputo' )
                )
            ),
            'buttonstyle' => array(
				'type' => 'select',
				'label' => esc_html__( 'Button Style', 'disputo' ),
				'default' => 'h1',
				'options' => array(
                    'primary' => esc_html__( 'Primary', 'disputo' ),
                    'info' => esc_html__( 'Info', 'disputo' ),
                    'success' => esc_html__( 'Success', 'disputo' ),
                    'warning' => esc_html__( 'Warning', 'disputo' ),
                    'danger' => esc_html__( 'Danger', 'disputo' )
                )
            ),
        );

		parent::__construct(
			'disputo-action',
			esc_html__('Disputo Call to Action', 'disputo'),
			array(
				'description' => esc_html__('A simple call-to-action widget', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-megaphone'),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-action-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-action', __FILE__, 'disputo_action_widget');
?>