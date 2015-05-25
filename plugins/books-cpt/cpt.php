<?php

/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function bookcpt_register() {
	$labels = array(
		'name'               => _x( 'Books', 'post type general name', 'books-cpt' ),
		'singular_name'      => _x( 'Book', 'post type singular name', 'books-cpt' ),
		'menu_name'          => _x( 'Books', 'admin menu', 'books-cpt' ),
		'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'books-cpt' ),
		'add_new'            => _x( 'Add New', 'book', 'books-cpt' ),
		'add_new_item'       => __( 'Add New Book', 'books-cpt' ),
		'new_item'           => __( 'New Book', 'books-cpt' ),
		'edit_item'          => __( 'Edit Book', 'books-cpt' ),
		'view_item'          => __( 'View Book', 'books-cpt' ),
		'all_items'          => __( 'All Books', 'books-cpt' ),
		'search_items'       => __( 'Search Books', 'books-cpt' ),
		'parent_item_colon'  => __( 'Parent Books:', 'books-cpt' ),
		'not_found'          => __( 'No books found.', 'books-cpt' ),
		'not_found_in_trash' => __( 'No books found in Trash.', 'books-cpt' ),
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-book-alt',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
	);

	register_post_type( 'book', $args );
}
add_action( 'init', 'bookcpt_register' );

/**
 * Book update messages.
 *
 * See /wp-admin/edit-form-advanced.php
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function bookcpt_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['book'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Book updated.', 'books-cpt' ),
		2  => __( 'Custom field updated.', 'books-cpt' ),
		3  => __( 'Custom field deleted.', 'books-cpt' ),
		4  => __( 'Book updated.', 'books-cpt' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Book restored to revision from %s', 'books-cpt' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Book published.', 'books-cpt' ),
		7  => __( 'Book saved.', 'books-cpt' ),
		8  => __( 'Book submitted.', 'books-cpt' ),
		9  => sprintf(
			__( 'Book scheduled for: <strong>%1$s</strong>.', 'books-cpt' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'books-cpt' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Book draft updated.', 'books-cpt' )
	);

	if ( $post_type_object->publicly_queryable ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View book', 'books-cpt' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview book', 'books-cpt' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}
add_filter( 'post_updated_messages', 'bookcpt_updated_messages' );
