<?php

/**
 * Register the genre taxonomy for the book post type.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function bookcpt_genre_taxonomy() {

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name', 'books-cpt' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'books-cpt' ),
		'search_items'      => __( 'Search Genres', 'books-cpt' ),
		'all_items'         => __( 'All Genres', 'books-cpt' ),
		'parent_item'       => __( 'Parent Genre', 'books-cpt' ),
		'parent_item_colon' => __( 'Parent Genre:', 'books-cpt' ),
		'edit_item'         => __( 'Edit Genre', 'books-cpt' ),
		'update_item'       => __( 'Update Genre', 'books-cpt' ),
		'add_new_item'      => __( 'Add New Genre', 'books-cpt' ),
		'new_item_name'     => __( 'New Genre Name', 'books-cpt' ),
		'menu_name'         => __( 'Genre', 'books-cpt' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => false, // Keep UI hidden. Will use CMB2 for selection
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);

	register_taxonomy( 'genre', array( 'book' ), $args );
}
add_action( 'init', 'bookcpt_genre_taxonomy', 0 );
