<?php
/*
Widget Name: Disputo Single Statistic
Description: Displays a site statistic
Author: Egemenerd
Author URI: http://www.egemenerd.com
*/

class disputo_statistic_widget extends SiteOrigin_Widget {
	function __construct() {
        $form_options = array(
            'a_section' => array(
                'type' => 'section',
                'label' => esc_html__( 'Text' , 'disputo' ),
                'hide' => false,
                    'fields' => array( 
                        'title' => array(
                            'type' => 'text',
                            'label' => esc_html__('Title', 'disputo'),
                            'default' => ''
                        ),
                        'fontsize' => array(
				            'type' => 'text',
				            'label' => esc_html__('Font Size (rem)', 'disputo'),
				            'default' => '1.75'
                        ),
                        'fontcolor' => array(
				            'type' => 'color',
				            'label' => esc_html__( 'Font Color', 'disputo' ),
				            'default' => '#364253'
                        ),
                        'statistic' => array(
				            'type' => 'select',
				            'label' => esc_html__( 'Statistic', 'disputo' ),
				            'default' => 'posts',
				                'options' => array(
                                    'posts' => esc_html__( 'Posts', 'disputo' ),
                                    'comments' => esc_html__( 'Comments', 'disputo' ),
                                    'users' => esc_html__( 'Registered Users (BbPress)', 'disputo' ),
                                    'forums' => esc_html__( 'Forums (BbPress)', 'disputo' ),
                                    'topics' => esc_html__( 'Topics (BbPress)', 'disputo' ),
                                    'replies' => esc_html__( 'Replies (BbPress)', 'disputo' ),
                                    'topic_tags' => esc_html__( 'Topic Tags (BbPress)', 'disputo' ),
                                    'likes' => esc_html__( 'Likes', 'disputo' ),
                                    'dislikes' => esc_html__( 'Dislikes', 'disputo' ),
                                    'woo' => esc_html__( 'Products (Woocommerce)', 'disputo' )
                                )
                        )
                    )
            ),
            'b_section' => array(
                'type' => 'section',
                'label' => esc_html__( 'Icon' , 'disputo' ),
                'hide' => true,
                'fields' => array(
                    'icon' => array(
                        'type' => 'icon',
                        'label' => esc_html__('Select an icon', 'disputo'),
                    ),
                    'iconurl' => array(
                        'type' => 'link',
                        'label' => esc_html__('Destination Url', 'disputo'),
                        'default' => ''
                    ),
                    'iconcolor' => array(
				        'type' => 'color',
				        'label' => esc_html__( 'Icon Color', 'disputo' ),
				        'default' => '#ffffff'
                    ),
                    'iconbgcolor' => array(
				        'type' => 'color',
				        'label' => esc_html__( 'Icon Background Color', 'disputo' ),
				        'default' => '#364253'
                    ),
                    'iconfontsize' => array(
				        'type' => 'number',
				        'label' => esc_html__('Icon Font Size (px)', 'disputo'),
				        'default' => '30'
                    ),
                    'iconcontainersize' => array(
				        'type' => 'number',
				        'label' => esc_html__('Icon Container Size (px)', 'disputo'),
				        'default' => '64'
                    )
                )
            )
        );

		parent::__construct(
			'disputo-statistic',
			esc_html__('Disputo Single Statistic', 'disputo'),
			array(
				'description' => esc_html__('Displays a site statistic', 'disputo'),'panels_groups' => array('disputo'),'panels_icon' => 'dashicons dashicons-chart-area'),
            array(),
			$form_options,
			plugin_dir_path(__FILE__)
		);
	}

	function get_template_name($instance) {
        return 'disputo-statistic-template';
	}

	function get_style_name($instance) {
        return false;
	}

}
siteorigin_widget_register('disputo-statistic', __FILE__, 'disputo_statistic_widget');
?>