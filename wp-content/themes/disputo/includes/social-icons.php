<?php
class disputosocial_Admin {
	private $key = 'disputosocial_options';
	private $metabox_id = 'disputosocial_option_metabox';
	protected $title = '';
	protected $options_page = '';
	public function __construct() {
		// Set our title
		$this->title = esc_html__( 'Footer Icons', 'disputo' );
        $this->menutitle = esc_html__( 'Footer Icons', 'disputo' );
	}

	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'disputo_add_social_page' ) );
		add_action( 'cmb2_init', array( $this, 'disputo_add_social_page_metabox' ) );
	}

	public function init() {
		register_setting( $this->key, $this->key );
	}

	public function disputo_add_social_page() {
		$this->options_page = add_theme_page( $this->title, $this->menutitle, 'manage_options', $this->key, array( $this, 'disputo_admin_social_display' ), null );

		// Include CMB CSS in the head to avoid FOUT
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	public function disputo_admin_social_display() {
		?>
    <div class="wrap cmb2-options-page <?php echo esc_html($this->key); ?>">
        <div id="disputo-social-wrapper">
            <h1 class="disputo-social-title"><span><span class="dashicons dashicons-twitter"></span> <?php echo esc_html( get_admin_page_title() ); ?></span></h1>
            <p class="disputo-social-subitle"><?php esc_html_e( 'These icons will be displayed in the footer.', 'disputo' ); ?></p>
                <?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
            <div id="disputo-delete-social">
                <form action="admin.php?page=disputosocial_options" method="post">
                <input id="isg_delete_icons" name="isg_delete_icons" type="submit" onclick="return confirm('<?php esc_html_e( 'Are you sure you want to delete all icons?', 'disputo') ?>')" class="button" value="<?php esc_html_e( 'Reset', 'disputo') ?>" />
                </form>
                </div>
            <?php
            if (isset($_POST["isg_delete_icons"])) {
                echo "<meta http-equiv='refresh' content='0'>";
                delete_option("disputosocial_options");
            }
            ?>
        </div>
    </div>
    <?php
	}

	function disputo_add_social_page_metabox() {
        $prefix = 'disputo';

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
        
        $cmb->add_field(
            array(
            'desc' => esc_attr__( 'Open links in a new tab', 'disputo'),
            'id' => $prefix . 'socialiconstab',
            'type' => 'checkbox'
            )
        );
        
        $cmb->add_field(
            array(
            'id' => $prefix . 'socialicons',
            'type' => 'group',
            'options' => array(
                'group_title'   => esc_html__( 'Icon {#}', 'disputo' ),
                'add_button' => esc_html__( 'Add Another Icon', 'disputo' ),
                'remove_button' => esc_html__( 'Remove Icon', 'disputo' ),
                'sortable' => true,
                'closed'     => true,
            ),
            'fields' => array(
				array(
                    'name' => esc_html__( 'Select Icon:', 'disputo'),
                    'id' => $prefix . 'iconimg',
                    'desc' => '',
                    'type' => 'select',
                    'options' => array(
                        'facebook-f' => esc_html__( 'Facebook', 'disputo' ),
                        'twitter' => esc_html__( 'Twitter', 'disputo' ),
                        'google-plus' => esc_html__( 'Google +', 'disputo' ),
                        'google' => esc_html__( 'Google', 'disputo' ),
                        'linkedin' => esc_html__( 'Linkedin', 'disputo' ),
                        'instagram' => esc_html__( 'Instagram', 'disputo' ),
                        'vimeo' => esc_html__( 'Vimeo', 'disputo' ),
                        'youtube' => esc_html__( 'You Tube', 'disputo' ),
                        'apple' => esc_html__( 'Apple', 'disputo' ),
                        'android' => esc_html__( 'Android', 'disputo' ),
                        'dribbble' => esc_html__( 'Dribbble', 'disputo' ),
                        'flickr' => esc_html__( 'Flickr', 'disputo' ),
                        'pinterest' => esc_html__( 'Pinterest', 'disputo' ),
                        'vk' => esc_html__( 'VK', 'disputo' ),
                        'codepen' => esc_html__( 'Codepen', 'disputo' ),
                        'snapchat-ghost' => esc_html__( 'Snapchat', 'disputo' ),
                        'delicious' => esc_html__( 'Delicious', 'disputo' ),
                        'github' => esc_html__( 'Github', 'disputo' ),
                        'reddit-alien' => esc_html__( 'Reddit', 'disputo' ),
                        'tumblr' => esc_html__( 'Tumblr', 'disputo' ),
                    ),
                ),
                array(
                    'name' => esc_html__( 'Title:', 'disputo'),
                    'id' => $prefix . 'icontooltip',
                    'desc' => esc_html__( 'The text when you hover over the icon (Optional).', 'disputo'),
                    'type' => 'text'
                ),
                array(
                    'name' => esc_html__( 'Link:', 'disputo'),
                    'desc' => esc_html__( 'Example; http://www.egemenerd.com', 'disputo'),
                    'id' => $prefix . 'iconlink',
                    'type' => 'text_url'
                ),
            ),
        ));

	}

	public function __get( $field ) {
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

function disputosocial_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new disputosocial_Admin();
		$object->hooks();
	}

	return $object;
}

function disputosocial_get_option( $key = '' ) {
	return cmb2_get_option( disputosocial_admin()->key, $key );
}

disputosocial_admin();
?>