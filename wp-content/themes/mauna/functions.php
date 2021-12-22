<?php
/**
 * Mauna functions and definitions
 */

/** Various clean up functions */
require_once(  get_template_directory(). '/library/global-functions.php' );
require_once(  get_template_directory(). '/library/custom-styles.php' );

/** Required for Foundation to work properly */
require_once(  get_template_directory(). '/library/mauna.php' );
require_once(  get_template_directory(). '/library/sharer.php' );

/** Register all navigation menus */
require_once(  get_template_directory(). '/library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once(  get_template_directory(). '/library/menu-walkers.php' );

/** Return entry meta information for posts */
require_once(  get_template_directory(). '/library/entry-meta.php' );

/** Enqueue scripts */
require_once(  get_template_directory(). '/library/enqueue-scripts.php' );

/** Add theme support */
require_once(  get_template_directory(). '/library/theme-support.php' );

/** Configure responsive image sizes */
require_once(  get_template_directory(). '/library/responsive-images.php' );

require_once(  get_template_directory(). '/library/class-tgm-plugin-activation.php' );

/** WooCommerce hooks change */
if(class_exists('WooCommerce')) {
	require_once(  get_template_directory(). '/library/woocommerce.php' );
}