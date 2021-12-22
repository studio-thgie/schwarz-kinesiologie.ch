<?php
/**
 * Register Menus
 *
 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus#Examples
 * @package Mauna
 * @since Mauna 1.0.0
 */

register_nav_menus(array(
	'home-nav' => esc_html__('Home navigation', 'mauna'),
	'home-nav2' => esc_html__('Home 2 navigation', 'mauna'),
	'burger-nav'  => esc_html__('Overlay navigation (burger)', 'mauna'),
	'burger-nav-second'  => esc_html__('Overlay secondary navigation (burger)', 'mauna'),
	'additional-nav' => esc_html__('Additional navigation (top right corner)', 'mauna'),
	'mobile-nav' => esc_html__('Mobile navigation', 'mauna'),
	'language-nav' => esc_html__('Languages', 'mauna'),
));


/**
 * Desktop navigation - right top bar
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( 'mauna_top_bar_r' ) ) {
	function mauna_top_bar_r() {
		wp_nav_menu( array(
			'container'      => false,
			'menu_class'     => 'menu',
			'items_wrap'     => '<ul id="%1$s" class="%2$s nav">%3$s</ul>',
			'theme_location' => 'home-nav',
			'depth'          => 1,
			'fallback_cb'    => false,
			'walker'         => new Mauna_Top_Bar_Walker(),
		));
	}
}

function mauna_overlay_nav() {
	wp_nav_menu( array(
		'container'      => false,
		'menu_class'     => 'nav margin-bottom-standard',
		'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'theme_location' => 'burger-nav',
		'depth'          => 3,
		'fallback_cb'    => false,
		'walker'         => new Mauna_Top_Bar_Walker(),
	));
}

function mauna_language_nav() {
	wp_nav_menu(array(
		'container'      => false,
		'menu_class'     => 'menu',
		'items_wrap'     => '<ul id="%1$s">%3$s</ul>',
		'theme_location' => 'language-nav',
		'depth'          => 1,
		'fallback_cb'    => false,
		'walker'         => new Mauna_Top_Bar_Walker(),
	));
}

function mauna_additional_nav($class = '') {
	wp_nav_menu( array(
		'container'      => false,
		'menu_class'     => 'social-profiles',
		'items_wrap'     => '<ul id="%1$s" class="%2$s '.$class.'">%3$s</ul>',
		'theme_location' => 'additional-nav',
		'depth'          => 1,
		'fallback_cb'    => false,
		'walker'         => new Mauna_Top_Bar_Walker(),
	));
}

function mauna_overlay_additional_nav($class = '') {
	wp_nav_menu( array(
		'container'      => false,
		'menu_class'     => 'social-profiles',
		'items_wrap'     => '<ul id="%1$s" class="%2$s '.$class.'">%3$s</ul>',
		'theme_location' => 'burger-nav-second',
		'depth'          => 1,
		'fallback_cb'    => false,
		'walker'         => new Mauna_Top_Bar_Walker(),
	));
}

/**
 * Mobile navigation - topbar (default) or offcanvas
 */
if ( ! function_exists( 'mauna_mobile_nav' ) ) {
	function mauna_mobile_nav() {
		wp_nav_menu( array(
			'container'      => false,                         // Remove nav container
			// 'menu'           => esc_html__( 'mobile-nav', 'mauna' ),
			'menu_class'     => 'vertical menu',
			'theme_location' => 'mobile-nav',
			'items_wrap'     => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
			'fallback_cb'    => false,
			'walker'         => new Mauna_Mobile_Walker(),
		));
	}
}

function mauna_default_menu_nav($menu) {
	wp_nav_menu( array(
		'menu'	         => $menu,
		'container'      => false,
		'menu_class'     => 'menu',
		'items_wrap'     => '<ul id="%1$s" class="%2$s menu-default">%3$s</ul>',
		'depth'          => 1,
		'fallback_cb'    => false,
	));
}

/**
 * Add support for buttons in the top-bar menu:
 * 1) In WordPress admin, go to Apperance -> Menus.
 * 2) Click 'Screen Options' from the top panel and enable 'CSS CLasses' and 'Link Relationship (XFN)'
 * 3) On your menu item, type 'has-form' in the CSS-classes field. Type 'button' in the XFN field
 * 4) Save Menu. Your menu item will now appear as a button in your top-menu
*/
if ( ! function_exists( 'mauna_add_menuclass' ) ) {
	function mauna_add_menuclass( $ulclass ) {
		$find = array('/<a rel="button"/', '/<a title=".*?" rel="button"/');
		$replace = array('<a rel="button" class="button"', '<a rel="button" class="button"');

		return preg_replace( $find, $replace, $ulclass, 1 );
	}
	add_filter( 'wp_nav_menu','mauna_add_menuclass' );
}
