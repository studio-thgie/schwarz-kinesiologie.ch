<?php
/**
 * Enqueue all styles and scripts
 *
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

if ( ! function_exists( 'mauna_scripts' ) ) :
	function mauna_scripts() {
		wp_enqueue_style( 'mauna-main-stylesheet', get_template_directory_uri() . '/assets/stylesheets/mauna.css', array(), '1.2.1', 'all' );

		if(!class_exists('Mauna_Utility_Plugin')) {
			wp_enqueue_style( 'mauna-theme-stylesheet', get_template_directory_uri() . '/assets/css/mauna-theme.css', array(), '1.2.1', 'all' );
		}
		wp_enqueue_script( 'mauna-js', get_template_directory_uri() . '/assets/javascript/mauna.js', array('jquery'), '1.2.1', true );

		// Add the comment-reply library on pages where it is necessary
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$redux = mauna_get_global_option_redux();
		$customStyles = mauna_get_custom_user_css();
		wp_add_inline_style ( 'mauna-main-stylesheet', $customStyles );
		$result = '';
		if ( isset($redux['mauna_custom_user_js']) && $redux['mauna_custom_user_js'] && isset($redux) ) {
			wp_add_inline_script( 'mauna-js', $redux['mauna_custom_user_js'] );
		}


	}

	add_action( 'wp_enqueue_scripts', 'mauna_scripts' );
endif;


function mauna_admin_scripts() {
	wp_enqueue_style( 'mauna-admin-main-stylesheet', get_template_directory_uri() . '/assets/stylesheets/admin.css', array(), '1.0.0', 'all' );
	wp_enqueue_script( 'mauna-admin-js', get_template_directory_uri() . '/assets/javascript/admin.js', array('jquery'), '2.6.1', true );
}

add_action( 'admin_enqueue_scripts', 'mauna_admin_scripts' );