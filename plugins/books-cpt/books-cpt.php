<?php
/**
* Plugin Name: Books CPT
* Plugin URI:  https://github.com/jtsternberg/CMB2-WPSessions-Demo/
* Description: Adds a 'Book' CPT to WordPress and corresponding CMB2 custom fields
* Version:     0.1.0
* Author:      jtsternberg
* Author URI:  http://dsgnwrks.pro
* Donate link: http://dsgnwrks.pro
* License:     GPLv2
* Text Domain: books-cpt
* Domain Path: /languages
*/

function bookscpt_includes() {
	$dir = plugin_dir_path( __FILE__ );

	include $dir . '/cpt.php';
	include $dir . '/taxonomy.php';
}

// Include our includes!
bookscpt_includes();

/**
 * Flush rewrite rules when this plugin is activated
 */
function bookcpt_rewrite_flush() {
	/*
	 * First, we "add" the custom post type via the above written function.
	 * Note: "add" is written with quotes, as CPTs don't get added to the DB,
	 * They are only referenced in the post_type column with a post entry,
	 * when you add a post of this CPT.
	 */
	bookcpt_register();

	/*
	 * ATTENTION: This is *only* done during plugin activation hook in this example!
	 * You should *NEVER EVER* do this on every page load!!
	 */
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'bookcpt_rewrite_flush' );

