<?php
class disputorating_Admin {
	private $key = 'disputo_like_dislike';
	private $metabox_id = 'disputorating_option_metabox';
	protected $title = '';
	protected $options_page = '';
	public function __construct() {
		$this->title = esc_html__( 'Disputo Rating System', 'disputo' );
        $this->menutitle = esc_html__( 'Rating System', 'disputo' );
	}

	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'disputo_add_rating_page' ) );
		add_action( 'cmb2_init', array( $this, 'disputo_add_rating_page_metabox' ) );
	}

	public function init() {
		register_setting( $this->key, $this->key );
	}

	public function disputo_add_rating_page() {
		$this->options_page = add_menu_page( $this->title, $this->menutitle, 'manage_options', $this->key, array( $this, 'disputo_admin_rating_display' ), 'dashicons-thumbs-up' );
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	public function disputo_admin_rating_display() {
		?>
    <div class="wrap cmb2-options-page <?php echo esc_html($this->key); ?>">
        <div id="disputo-social-wrapper">
            <h1 class="disputo-social-title"><span><span class="dashicons dashicons-thumbs-up"></span> <?php echo esc_html( get_admin_page_title() ); ?></span></h1>
                <?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
        </div>
    </div>
    <?php
	}

	function disputo_add_rating_page_metabox() {
        $dir = plugin_dir_url( __FILE__ );

		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => true,
			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
        
        $cmb->add_field( array(
            'name'    => esc_html__( 'Turn on like or dislike for posts', 'disputo'),
            'id'      => 'v-switch-posts',
            'type'    => 'radio_inline',
            'options' => array(
                'on' => esc_html__( 'On', 'disputo'),
                'off' => esc_html__( 'Off', 'disputo'),
            ),
            'default' => 'off',
        ));
        
        $cmb->add_field( array(
            'name'    => esc_html__( 'Turn on like or dislike for comments', 'disputo'),
            'id'      => 'v-switch-comments',
            'type'    => 'radio_inline',
            'options' => array(
                'on' => esc_html__( 'On', 'disputo'),
                'off' => esc_html__( 'Off', 'disputo'),
            ),
            'default' => 'off',
        ));
        
        $cmb->add_field( array(
            'name'    => esc_html__( 'Enable bbPress support', 'disputo'),
            'id'      => 'v_enable_bbpress',
            'type'    => 'radio_inline',
            'options' => array(
                'on' => esc_html__( 'On', 'disputo'),
                'off' => esc_html__( 'Off', 'disputo'),
            ),
            'default' => 'off',
        ));
        
        $cmb->add_field( array(
            'name'    => esc_html__( 'Button style', 'disputo'),
            'id'      => 'v_button_style',
            'type'    => 'radio_inline',
            'options' => array(
                '1' => '<img src="' . $dir. 'images/1.png" />',
                '2' => '<img src="' . $dir. 'images/2.png" />',
                '3' => '<img src="' . $dir. 'images/3.png" />',
                '4' => '<img src="' . $dir. 'images/4.png" />',
                '5' => '<img src="' . $dir. 'images/5.png" />',
                '6' => '<img src="' . $dir. 'images/6.png" />',
                '7' => '<img src="' . $dir. 'images/7.png" />',
                '8' => '<img src="' . $dir. 'images/8.png" />',
                '9' => '<img src="' . $dir. 'images/9.png" />',
                '10' => '<img src="' . $dir. 'images/10.png" />',
                '11' => '<img src="' . $dir. 'images/11.png" />',
                '12' => '<img src="' . $dir. 'images/12.png" />',
                '13' => '<img src="' . $dir. 'images/13.png" />',
                '14' => '<img src="' . $dir. 'images/14.png" />',
            ),
            'default' => '1',
        ));
        
        $cmb->add_field( array(
            'name'    => esc_html__( 'Turn on or off dislike button', 'disputo'),
            'id'      => 'v-switch-dislike',
            'type'    => 'radio_inline',
            'options' => array(
                'on' => esc_html__( 'On', 'disputo'),
                'off' => esc_html__( 'Off', 'disputo'),
            ),
            'default' => 'on',
        ));
	}

	public function __get( $field ) {
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

function disputorating_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new disputorating_Admin();
		$object->hooks();
	}

	return $object;
}

function disputorating_get_option( $key = '' ) {
	return cmb2_get_option( disputorating_admin()->key, $key );
}

disputorating_admin();
?>