<?php
/*
Widget Name: Disputo You Tube TV
Description: Displays your You Tube Channel Videos
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_ytv_widget extends SiteOrigin_Widget {
	function __construct() {
        $form_options = array(
            'apikey' => array(
				'type' => 'text',
				'label' => esc_html__('Api Key (Required)', 'disputo'),
                'description' => '<a href="http://help.wp4life.com/2017/07/21/get-tube-api-key/" target="_blank">' . esc_html__('How to get a You Tube API key?', 'disputo') . '</a>',
				'default' => ''
            ),
            'username' => array(
				'type' => 'text',
				'label' => esc_html__('You Tube Username', 'disputo'),
				'default' => ''
            ),
            'channelid' => array(
				'type' => 'text',
				'label' => esc_html__('You Tube Channel ID', 'disputo'),
				'default' => ''
            ),
            'maxvideo' => array(
				'type' => 'number',
				'label' => esc_html__('Maximum number of the videos', 'disputo'),
				'default' => '10'
            ),
            'playlist' => array(
				'type' => 'radio',
				'label' => esc_html__( 'Activate Playlist', 'disputo' ),
				'default' => 'false',
				    'options' => array(
                        'true' => esc_html__( 'Yes', 'disputo' ),
                        'false' => esc_html__( 'No', 'disputo' )
				    )
            ),
            'maxplaylist' => array(
				'type' => 'number',
				'label' => esc_html__('Maximum number of the playlists', 'disputo'),
				'default' => '20'
            ),
            'height' => array(
				'type' => 'number',
				'label' => esc_html__('Height (px)', 'disputo'),
				'default' => '552'
            ),
		);

		parent::__construct(
			'disputo-ytv',
			esc_html__('Disputo You Tube TV', 'disputo'),
			array(
				'description' => esc_html__('Displays your You Tube Channel Videos', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-format-video'),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-ytv-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-ytv', __FILE__, 'disputo_ytv_widget');
?>