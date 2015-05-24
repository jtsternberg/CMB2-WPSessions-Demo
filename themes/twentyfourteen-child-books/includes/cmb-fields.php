<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * Be sure to replace all instances of 'twentyfourteenbooks_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category Twenty Fourteen -- BOOKS!
 * @package  Theme fields
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Conditionally displays a metabox if on the front-page template
 *
 * @param  CMB2 object $cmb CMB2 object
 *
 * @return bool             True if metabox should show
 */
function twentyfourteenbooks_show_if_front_page_template( $cmb ) {
	// Don't show this metabox if it's not the front page template
	if ( $cmb->object_id !== get_option( 'page_on_front' ) ) {
		return false;
	}
	return true;
}

/**
 * Hook in and add a metabox for the front-page.
 */
function twentyfourteenbooks_register_frontpage_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_twentyfourteenbooks_front_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Homepage Details', 'wpsessions' ),
		'object_types'  => array( 'page', ), // Post type
		'show_on_cb'    => 'twentyfourteenbooks_show_if_front_page_template', // function should return a bool value
	) );

	$cmb->add_field( array(
		'name'    => __( 'Slogan', 'wpsessions' ),
		'desc'    => __( 'If the slogan is entered, it will replace the page title in the template. This markup will be within the title <code>H1</code> tags.', 'wpsessions' ),
		'id'      => $prefix . 'slogan',
		'type'    => 'wysiwyg',
		'options' => array( 'textarea_rows' => 5, ),
	) );

	$cmb->add_field( array(
		'name'         => __( 'Random Splash Images', 'wpsessions' ),
		'desc'         => __( 'A random image from this list will display with every page-load.', 'wpsessions' ),
		'id'           => $prefix . 'splash_images',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );

	$cmb->add_field( array(
		'name' => __( 'Video Embed', 'wpsessions' ),
		'desc' => __( 'Enter a youtube or vimeo URL. Other Supported services are listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'wpsessions' ),
		'id'   => $prefix . 'embed',
		'type' => 'oembed',
	) );

	$cmb->add_field( array(
		'name' => __( 'Video Description', 'wpsessions' ),
		'desc' => __( '(optional)', 'wpsessions' ),
		'id'   => $prefix . 'embed_desc',
		'type' => 'textarea_small',
	) );

}
add_action( 'cmb2_init', 'twentyfourteenbooks_register_frontpage_metabox' );
