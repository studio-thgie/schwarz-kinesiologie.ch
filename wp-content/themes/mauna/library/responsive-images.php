<?php
/**
 * Configure responsive images sizes
 *
 * @package WordPress
 * @subpackage Mauna
 * @since Mauna 2.6.0
 */

// Add additional image sizes
add_image_size( 'mauna-small', 640 );
add_image_size( 'mauna-medium', 1024 );
add_image_size( 'mauna-large', 1200 );

// Register the new image sizes for use in the add media modal in wp-admin
add_filter( 'image_size_names_choose', 'mauna_custom_sizes' );
function mauna_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'mauna-small'  => esc_html__( 'Mauna Small', 'mauna' ),
		'mauna-medium' => esc_html__( 'Mauna Medium', 'mauna' ),
		'mauna-large'  => esc_html__( 'Mauna Large', 'mauna' ),
	) );
}

// Add custom image sizes attribute to enhance responsive image functionality for content images
function mauna_adjust_image_sizes_attr( $sizes, $size ) {

	// Actual width of image
	$width = $size[0];

	// Full width page template
	if ( is_page_template( 'page-templates/page-full-width.php' ) ) {
		1200 < $width && $sizes = '(max-width: 1199px) 98vw, 1200px';
		1200 > $width && $sizes = '(max-width: 1199px) 98vw, ' . $width . 'px';

	// Default 3/4 column post/page layout
	} else {
		770 < $width && $sizes = '(max-width: 639px) 98vw, (max-width: 1199px) 64vw, 770px';
		770 > $width && $sizes = '(max-width: 639px) 98vw, (max-width: 1199px) 64vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'mauna_adjust_image_sizes_attr', 10 , 2 );

// Remove inline width and height attributes for post thumbnails
function mauna_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	if(function_exists('is_product')) {
		if(is_product()) {
			return $html;
		}
	}
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
	return $html;
}

add_filter( 'post_thumbnail_html', 'mauna_remove_thumbnail_dimensions', 10, 3 );