<?php
/**
 * Register theme support for languages, menus, post-thumbnails, post-formats etc.
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

if ( ! function_exists( 'mauna_theme_support' ) ) :
function mauna_theme_support() {
	// Add language support
	load_theme_textdomain( 'mauna', get_template_directory() . '/languages' );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add menu support
	add_theme_support( 'menus' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Add post thumbnail support: http://codex.wordpress.org/Post_Thumbnails
	add_theme_support( 'post-thumbnails' );

	// RSS thingy
	add_theme_support( 'automatic-feed-links' );

	// Add post formarts support: http://codex.wordpress.org/Post_Formats
	add_theme_support( 'post-formats', array('standard') );

	// Declare WooCommerce support per http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
	add_theme_support( 'woocommerce' );
	add_image_size( 'mauna_blog', 430, 650, true);
	add_image_size( 'mauna_home2', 1920, 1080, true);

	if ( ! isset( $content_width ) ) {
		$content_width = 900;
	}
}

add_action( 'after_setup_theme', 'mauna_theme_support' );
endif;