<?php

/**
 * If on singular post, add book meta to the content output
 */
function bookscpt_maybe_filter_content( $content ) {

	if ( is_singular( 'book' ) ) {
		$post_id = get_the_ID();

		$content = bookscpt_pre_content_meta( $post_id ) . $content . bookscpt_post_content_meta( $post_id );
	}

	return $content;
}
add_filter( 'the_content', 'bookscpt_maybe_filter_content' );

/**
 * Get book meta to be output at the beginning of the content field
 */
function bookscpt_pre_content_meta( $post_id ) {

	$content = '';

	if ( $author_name = get_post_meta( $post_id, '_bookcpt_author', 1 ) ) {

		$author_name = esc_html( $author_name );

		if ( $author_url = get_post_meta( $post_id, '_bookcpt_author_url', 1 ) ) {
			$author_name = sprintf( '<a href="%s">%s</a>', esc_url( $author_url ), $author_name );
		}

		$author_name = sprintf( _x( 'Submitted by: %s', 'book byline', 'wpsessions' ), $author_name );

		$content .= sprintf( '<p class="book-author">%s</p>', $author_name );
	}

	$content .= get_the_term_list( $post_id, 'genre', '<p class="book-genre-list">'. __( 'Genres: ', 'wpsessions' ), ', ', '</p>' );

	return $content;
}

/**
 * Get book meta to be output at the end of the content field
 */
function bookscpt_post_content_meta( $post_id ) {

	$content = '';

	if ( $submitter_name = get_post_meta( $post_id, '_bookcpt_submitter', 1 ) ) {

		$submitter_name = esc_html( $submitter_name );

		if ( $submitter_url = get_post_meta( $post_id, '_bookcpt_submitter_url', 1 ) ) {
			$submitter_name = sprintf( '<a href="%s">%s</a>', esc_url( $submitter_url ), $submitter_name );
		}

		$submitter_name = sprintf( _x( 'Submitted by: %s', 'book byline', 'wpsessions' ), $submitter_name );

		$content .= sprintf( '<p class="book-submitter"><em>%s</em></p>', $submitter_name );
	}

	return $content;
}

/**
 * Replace prev nav with related links
 */
function bookscpt_maybe_filter_previous_post_link( $html ) {

	if ( is_singular( 'book' ) ) {

		$html = '';

		if ( $related_ids = get_post_meta( get_the_ID(), '_bookcpt_related', 1 ) ) {

			$related_ids = array_map( 'trim', explode( ',', $related_ids ) );

			foreach ( (array) $related_ids as $related_id ) {
				$html .= sprintf(
					'<li><a href="%s" rel="related">%s</a></li>',
					esc_url( get_permalink( $related_id ) ),
					esc_html( get_the_title( $related_id ) )
				);
			}

			$html = sprintf( '<h6>%s</h6><ul>%s</ul>', __( 'Related Books:', 'wpsessions' ), $html );
		}

		return $html;
	}

	return $html;
}
add_filter( 'previous_post_link', 'bookscpt_maybe_filter_previous_post_link' );

/**
 * Remove next nav on singular books
 */
function bookscpt_maybe_filter_next_post_link( $html ) {

	if ( is_singular( 'book' ) ) {
		return '';
	}

	return $html;
}
add_filter( 'next_post_link', 'bookscpt_maybe_filter_next_post_link' );
