<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
	<?php
		twentyfourteenbook_splash_image();

		the_title( '<h1 class="entry-title">', '</h1>' );
	?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			twentyfourteenbook_video_and_desc();

			the_content();

			edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
