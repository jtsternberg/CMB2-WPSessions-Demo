<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 * @link https://github.com/WebDevStudios/CMB2-Snippet-Library/blob/master/options-and-settings-pages/theme-options-cmb.php
 */
class Twentyfourteenbooks_Admin {

	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'twentyfourteenbooks_options';

	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'twentyfourteenbooks_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Site Options', 'wpsessions' );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}


	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );

		// Include CMB CSS in the head to avoid FOUT
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key, array( 'cmb_styles' => false ) ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {

		$cmb = new_cmb2_box( array(
			'id'      => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields

		/*
		 * Custom address field, https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types#example-4-multiple-inputs-one-field-lets-create-an-address-field
		 */
		$cmb->add_field( array(
			'name' => __( 'Business Address', 'wpsessions' ),
			'desc' => __( 'Enter the address for contact.', 'wpsessions' ),
			'id'   => 'address',
			'type' => 'address',
		) );

		$cmb->add_field( array(
			'name'       => __( 'Business Phone', 'wpsessions' ),
			'id'         => 'phone',
			'type'       => 'text',
			'attributes' => array(
				'type' => 'phone',
			),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Contact Email', 'wpsessions' ),
			'id'      => 'email',
			'type'    => 'text_email',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Hours of Operation', 'wpsessions' ),
			'id'      => 'hours',
			'type'    => 'text_medium',
			'attributes' => array(
				'placeholder' => __( 'M-F 9:30-5:00 EST', 'wpsessions' ),
			),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Footer Text', 'wpsessions' ),
			'desc'    => __( 'contains address/copyright, etc.', 'wpsessions' ),
			'id'      => 'settingstitle',
			'type'    => 'title',
		) );

		$cmb->add_field( array(
			'id'      => 'footer_text',
			'type'    => 'wysiwyg',
			'options' => array( 'textarea_rows' => 8, ),
		) );

	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

/**
 * Helper function to get/return the Twentyfourteenbooks_Admin object
 * @since  0.1.0
 * @return Twentyfourteenbooks_Admin object
 */
function twentyfourteenbooks_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new Twentyfourteenbooks_Admin();
		$object->hooks();
	}

	return $object;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function twentyfourteenbooks_get_option( $key = '' ) {
	return cmb2_get_option( twentyfourteenbooks_admin()->key, $key );
}

// Get it started
twentyfourteenbooks_admin();
