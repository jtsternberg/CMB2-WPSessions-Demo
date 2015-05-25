<?php
/**
 * Twenty Fourteen -- BOOKS!
 */

function twentyfourteenbooks_includes() {
	$dir = get_stylesheet_directory();

	include $dir . '/includes/custom-cmb-field-types.php';
	include $dir . '/includes/cmb-fields.php';
	include $dir . '/includes/theme-options-cmb.php';
}

// Include our includes!
twentyfourteenbooks_includes();


/**
 * Replaces the page title on the homepage with the custom slogan field (if it exists)
 *
 * @param  string  $title Page title
 *
 * @return string         Maybe-modified page title
 */
function twentyfourteenbooks_replace_homepage_title_with_slogan( $title ) {
	// If we're not on the homepage, just pass the title back
	if ( ! is_front_page() ) {
		return $title;
	}

	// If we find a slogan on the homepage, use that instead.
	if ( $slogan = get_post_meta( get_the_ID(), '_twentyfourteenbooks_front_slogan', 1 ) ) {
		return $slogan;
	}

	return $title;
}
add_filter( 'the_title', 'twentyfourteenbooks_replace_homepage_title_with_slogan' );

/**
 * Display frontpage random splash image
 * @link https://github.com/WebDevStudios/CMB2/wiki/Field-Types#file_list Example/Docs
 */
function twentyfourteenbook_splash_image() {
	$images = get_post_meta( get_the_ID(), '_twentyfourteenbooks_front_splash_images', 1 );

	// If we saved data, it will be an array
	if ( is_array( $images ) ) {
		// Get random attachment ID
		$attach_id = array_rand( $images );

		// And display the image
		printf( '<p class="front-page-splash">%s</p>', wp_get_attachment_image( $attach_id, 'large' ) );
	}
}

/**
 * Display frontpage video embed
 * @link https://github.com/WebDevStudios/CMB2/wiki/Field-Types#oembed Example/Docs
 */
function twentyfourteenbook_video_and_desc() {
	$video = get_post_meta( get_the_ID(), '_twentyfourteenbooks_front_embed', 1 );

	// Check if we have a video
	if ( ! empty( $video ) ) {
		echo '<div class="front-page-embed">';
		// Display embed
		echo wp_oembed_get( esc_url( $video ) );
		if ( $desc = get_post_meta( get_the_ID(), '_twentyfourteenbooks_front_embed_desc', 1 ) ) {
			printf( '<p class="front-page-embed-description">%s</p>', $desc );
		}
		echo '</div>';
	}
}


/**
 * Show the address if the address field is not empty
 */
function twentyfourteenbooks_address_field() {
	$address = twentyfourteenbooks_get_option( 'address' );
	if ( empty( $address ) ) {
		return;
	}

	// Set default values for each address key
	$address = wp_parse_args( $address, array(
	    'address-1' => '',
	    'address-2' => '',
	    'city'      => '',
	    'state'     => '',
	    'zip'       => '',
	) );

	?>
	<div class="business-address">
		<h6><?php _e( 'Address:', 'wpsessions' ); ?></h6>
		<p>
			<?php echo esc_html( $address['address-1'] ); ?>
			<?php if ( $address['address-2'] ) : ?>
				<br><?php echo esc_html( $address['address-2'] ); ?>
			<?php endif; ?>
		</p>
		<p><?php echo esc_html( $address['city'] ); ?>, <?php echo esc_html( $address['state'] ); ?> <?php echo esc_html( $address['zip'] ); ?></p>
	</div>
	<?php
}

function twentyfourteenbooks_footer_info() {
	twentyfourteenbooks_address_field();

	if ( $phone = twentyfourteenbooks_get_option( 'phone' ) ) {
		printf( '<p class="business-phone"><h6>%s</h6>%s</p>', __( 'Phone', 'wpsessions' ), $phone );
	}

	if ( $email = twentyfourteenbooks_get_option( 'email' ) ) {
		printf( '<p class="business-email"><h6>%s</h6>%s</p>', __( 'Email', 'wpsessions' ), $email );
	}

	if ( $hours = twentyfourteenbooks_get_option( 'hours' ) ) {
		printf( '<p class="business-hours"><h6>%s</h6>%s</p>', __( 'Hours of Operation', 'wpsessions' ), $hours );
	}

	if ( $footer_text = twentyfourteenbooks_get_option( 'footer_text' ) ) {
		printf( '<div class="business-footer-text">%s</div>', wpautop( $footer_text ) );
	}
}
add_action( 'twentyfourteen_credits', 'twentyfourteenbooks_footer_info' );
