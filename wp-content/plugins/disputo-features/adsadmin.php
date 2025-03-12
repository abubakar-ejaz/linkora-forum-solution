<?php
class disputoads_Admin {
	private $key = 'disputo_ads';
	private $metabox_id = 'disputoads_option_metabox';
	protected $title = '';
	protected $options_page = '';
	public function __construct() {
		$this->title = esc_html__( 'Disputo Ads Manager', 'disputo' );
        $this->menutitle = esc_html__( 'Ads Manager', 'disputo' );
	}

	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'disputo_add_ads_page' ) );
		add_action( 'cmb2_init', array( $this, 'disputo_add_ads_page_metabox' ) );
	}

	public function init() {
		register_setting( $this->key, $this->key );
	}

	public function disputo_add_ads_page() {
		$this->options_page = add_menu_page( $this->title, $this->menutitle, 'manage_options', $this->key, array( $this, 'disputo_admin_ads_display' ), 'dashicons-editor-table' );
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	public function disputo_admin_ads_display() {
		?>
    <div class="wrap cmb2-options-page <?php echo esc_html($this->key); ?>">
        <div id="disputo-social-wrapper">
            <h1 class="disputo-social-title"><span><span class="dashicons dashicons-editor-table"></span> <?php echo esc_html( get_admin_page_title() ); ?></span></h1>
                <?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
        </div>
    </div>
    <?php
	}

	function disputo_add_ads_page_metabox() {
        $prefix = 'disputo_ads_';

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
            'name' => '',
            'desc' => esc_html__( 'Enable Ads Manager', 'disputo' ),
            'id'   => $prefix . 'enable',
            'type' => 'checkbox',
        ) );
        
        $cmb->add_field(
            array(
            'id' => $prefix . 'imageads',
            'type' => 'group',
            'options' => array(
                'group_title'   => esc_html__( 'Image {#}', 'disputo' ),
                'add_button' => esc_html__( 'Add Another Image', 'disputo' ),
                'remove_button' => esc_html__( 'Remove Image', 'disputo' ),
                'sortable' => true,
                'closed'     => true,
            ),
            'fields' => array(
                array(
                    'name' => esc_html__( 'Select Field:', 'disputo'),
                    'id' => $prefix . 'field',
                    'desc' => esc_html__( 'Select a field to display this ad.', 'disputo'),
                    'type' => 'select',
                    'options' => array(
                        'none' => esc_html__( 'None', 'disputo' ),
                        'bbp_template_before_forums_index' => esc_html__( 'Before Forum Index', 'disputo' ),
                        'bbp_template_after_forums_index' => esc_html__( 'After Forum Index', 'disputo' ),
                        'bbp_template_before_search' => esc_html__( 'Before Search Results', 'disputo' ),
                        'bbp_template_after_search_results' => esc_html__( 'After Search Results', 'disputo' ),
                        'bbp_template_before_single_forum' => esc_html__( 'Before Single Forum', 'disputo' ),
                        'bbp_template_after_single_forum' => esc_html__( 'After Single Forum', 'disputo' ),
                        'bbp_template_before_single_topic' => esc_html__( 'Before Single Topic', 'disputo' ),
                        'bbp_template_after_single_topic' => esc_html__( 'After Single Topic', 'disputo' ),
                        'bbp_template_before_lead_topic' => esc_html__( 'Before Lead Topic', 'disputo' ),
                        'bbp_template_after_lead_topic' => esc_html__( 'After Lead Topic', 'disputo' ),
                        'disputo_before_single_post' => esc_html__( 'Before Single Blog Post', 'disputo' ),
                        'disputo_after_single_post' => esc_html__( 'After Single Blog Post', 'disputo' ),
                        'disputo_before_footer' => esc_html__( 'Before Footer', 'disputo' )
                    ),
                ),
                array(
                    'name'    => esc_html__( 'Image:', 'disputo'),
                    'desc'    => esc_html__( 'Upload an image or enter an URL.', 'disputo'),
                    'id'      => $prefix . 'image',
                    'type'    => 'file',
                    'text'    => array(
                        'add_upload_file_text' => esc_html__( 'Upload Image', 'disputo')
                    ),
                    'query_args' => array(
                        'type' => array('image/gif','image/jpeg','image/png'),
                    ),
                    'preview_size' => 'medium',
                ),
                array(
                    'name' => esc_html__( 'Destination URL:', 'disputo'),
                    'desc' => esc_html__( 'Example; http://www.egemenerd.com', 'disputo'),
                    'id' => $prefix . 'destination',
                    'type' => 'text_url'
                ),
            ),
        ));
        
        $cmb->add_field(
            array(
            'id' => $prefix . 'codeads',
            'type' => 'group',
            'options' => array(
                'group_title'   => esc_html__( 'Code {#}', 'disputo' ),
                'add_button' => esc_html__( 'Add Another Code', 'disputo' ),
                'remove_button' => esc_html__( 'Remove Code', 'disputo' ),
                'sortable' => true,
                'closed'     => true,
            ),
            'fields' => array(
                array(
                    'name' => esc_html__( 'Select Field:', 'disputo'),
                    'id' => $prefix . 'field',
                    'desc' => esc_html__( 'Select a field to display this ad.', 'disputo'),
                    'type' => 'select',
                    'options' => array(
                        'none' => esc_html__( 'None', 'disputo' ),
                        'bbp_template_before_forums_index' => esc_html__( 'Before Forum Index', 'disputo' ),
                        'bbp_template_after_forums_index' => esc_html__( 'After Forum Index', 'disputo' ),
                        'bbp_template_before_search' => esc_html__( 'Before Search Results', 'disputo' ),
                        'bbp_template_after_search_results' => esc_html__( 'After Search Results', 'disputo' ),
                        'bbp_template_before_single_forum' => esc_html__( 'Before Single Forum', 'disputo' ),
                        'bbp_template_after_single_forum' => esc_html__( 'After Single Forum', 'disputo' ),
                        'bbp_template_before_single_topic' => esc_html__( 'Before Single Topic', 'disputo' ),
                        'bbp_template_after_single_topic' => esc_html__( 'After Single Topic', 'disputo' ),
                        'bbp_template_before_lead_topic' => esc_html__( 'Before Lead Topic', 'disputo' ),
                        'bbp_template_after_lead_topic' => esc_html__( 'After Lead Topic', 'disputo' ),
                        'disputo_before_single_post' => esc_html__( 'Before Single Blog Post', 'disputo' ),
                        'disputo_after_single_post' => esc_html__( 'After Single Blog Post', 'disputo' ),
                        'disputo_before_footer' => esc_html__( 'Before Footer', 'disputo' )
                    ),
                ),
                array(
                    'name' => esc_html__( 'Code:', 'disputo'),
                    'desc' => esc_html__( 'Paste your code snippet in the textbox above', 'disputo'),
                    'id' => $prefix . 'code',
                    'type' => 'textarea_code'
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

function disputoads_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new disputoads_Admin();
		$object->hooks();
	}

	return $object;
}

function disputoads_get_option( $key = '' ) {
	return cmb2_get_option( disputoads_admin()->key, $key );
}

disputoads_admin();
?>