<?php
/**
 * Include and setup custom metaboxes and fields for the book cpt.
 *
 * @category Book CPT
 * @package  Custom Fields
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Hook in and add our book metabox
 */
function bookcpt_register_demo_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_bookcpt_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Book Info', 'books-cpt' ),
		'object_types'  => array( 'book', ), // Post type
		'show_on_cb'    => 'bookcpt_show_if_front_page', // function should return a bool value
	) );

	$cmb->add_field( array(
		'name'     => __( 'Select Genre', 'books-cpt' ),
		'id'       => $prefix . 'genres',
		'type'     => 'taxonomy_multicheck',
		'taxonomy' => 'genre', // Taxonomy Slug
	) );

	$cmb->add_field( array(
		'name'       => __( 'Author Name', 'books-cpt' ),
		'id'         => $prefix . 'author',
		'type'       => 'text',
	) );

	$cmb->add_field( array(
		'name'       => __( 'Author URL', 'books-cpt' ),
		'id'         => $prefix . 'author_url',
		'type'       => 'text_url',
	) );

	$cmb->add_field( array(
		'name'       => __( 'Submitter Name', 'books-cpt' ),
		'desc'       => __( 'Name of person who submitted this book (if applicable)', 'books-cpt' ),
		'id'         => $prefix . 'submitter',
		'type'       => 'text',
	) );

	$cmb->add_field( array(
		'name'       => __( 'Submitter URL', 'books-cpt' ),
		'desc'       => __( 'URL of person who submitted this book (if applicable)', 'books-cpt' ),
		'id'         => $prefix . 'submitter_url',
		'type'       => 'text_url',
	) );

	$cmb->add_field( array(
		'name'      => __( 'Select Related Books', 'books-cpt' ),
		'id'        => $prefix . 'related',
		'type'      => 'post_search_text',
		'post_type' => 'book',
	) );

}
add_action( 'cmb2_init', 'bookcpt_register_demo_metabox' );
