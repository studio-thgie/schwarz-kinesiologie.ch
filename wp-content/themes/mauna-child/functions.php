<?php
/**
 * Enqueues child theme stylesheet, loading first the parent theme stylesheet.
 */
function mauna_custom_enqueue_child_theme_styles() {
	wp_enqueue_style('child-style', get_stylesheet_uri(), array('main-stylesheet'));
}

add_action('wp_enqueue_scripts', 'mauna_custom_enqueue_child_theme_styles', 11);

/*
Insert here your custom functions
*/
?>