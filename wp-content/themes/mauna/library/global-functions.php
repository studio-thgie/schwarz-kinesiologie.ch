<?php

function mauna_get_global_option_redux() {
	global $mauna_redux;
	if ( function_exists('icl_object_id') ) {
		global $sitepress;
		$default_language = $sitepress->get_default_language();
		if ( ICL_LANGUAGE_CODE != $default_language ) {
			if ( isset($GLOBALS['mauna_redux_'.ICL_LANGUAGE_CODE]) ) {
				$mauna_redux = $GLOBALS['mauna_redux_'.ICL_LANGUAGE_CODE];
			}
		}
	}
	return $mauna_redux;

}

function mauna_get_option_redux() {
	$mauna_redux = 'mauna_redux';
	if ( function_exists('icl_object_id') ) {
		global $sitepress;
		$default_language = $sitepress->get_default_language();
		if ( ICL_LANGUAGE_CODE != $default_language ) {
			$mauna_redux = 'mauna_redux_'. ICL_LANGUAGE_CODE;
		}
	}
	$mauna_redux = get_option($mauna_redux);
	return $mauna_redux;
}


// Logo header
function mauna_get_page_header_logo($redux) {
	$logo = isset($redux['mauna_header_logo']) ? $redux['mauna_header_logo'] : '';
	if(isset($logo['url']) && $logo['url'] != '') {

	echo '<div class="page-header-logo">
		<a href="'.esc_url( home_url( '/' )) .'" class=" show-in-viewport">
			<img src="'.esc_url($logo['url']).'" alt=""/>
		</a>
	</div>';
	}
}


function mauna_get_page_navigation($nav) {
	if(is_null($nav)) {
		$nav = 'small-dark';
	}
	get_template_part('template-parts/header-'.$nav);
}

function mauna_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__('Mauna Theme Plugin', 'mauna'),
			'slug'               => 'mauna-theme-plugin',
			'source'             =>  get_template_directory() . '/library/plugins/mauna-theme-plugin.zip',
			'required'           => true,
			'version'            => '1.2.2',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'               => esc_html__('Revolution Slider', 'mauna'),
			'slug'               => 'revslider',
			'source'             => get_template_directory() . '/library/plugins/revslider.zip',
			'required'           => false,
			'version'            => '5.3.1.5',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'      => 'SVG Support',
			'slug'      => 'svg-support',
			'required'  => false,
		),
	);

	$config = array(
		'id'           => 'mauna', 
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins', 
		'parent_slug'  => 'themes.php', 
		'capability'   => 'edit_theme_options', 
		'has_notices'  => true,  
		'dismissable'  => true,  
		'dismiss_msg'  => '',
		'is_automatic' => false,  
		'message'      => '',

	);

	tgmpa( $plugins, $config );


}
add_action('tgmpa_register', 'mauna_register_required_plugins');

function mauna_filter_columns($content) {
	
	return $content;
}
add_filter('the_content', 'mauna_filter_columns', 15);

function mauna_wrap_readmore($more_link) {
	return '<div class="post-readmore">'.$more_link.'</div>';
}
add_filter('the_content_more_link', 'mauna_wrap_readmore', 10, 1);

function mauna_get_custom_user_css() {
	$redux = mauna_get_global_option_redux();
	$result = '';
	if ( isset($redux['mauna_custom_user_css']) && $redux['mauna_custom_user_css'] && isset($redux) ) {
		$result = $redux['mauna_custom_user_css'];
	}

	return $result;
}

function mauna_add_body_class($classes) {
	$redux = mauna_get_global_option_redux();

	if(isset($redux) && isset($redux['mauna_general_enable_ajax']) && $redux['mauna_general_enable_ajax'] == 0) {
		if ( !isset( $classes['no-ajax-load'] ) ) {
			$classes[] = 'no-ajax-load';
		}
	}

	if(class_exists('WooCommerce') || class_exists('SitePress')) {
		if ( !isset( $classes['no-ajax-load'] ) ) {
			$classes[] = 'no-ajax-load';
		}
	}
	return $classes;
}
add_filter( 'body_class', 'mauna_add_body_class');


add_filter( 'the_password_form', 'mauna_custom_password_form' );
function mauna_custom_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form class="protected-post-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '	" method="post">
    ' . esc_html__( 'This content is password protected. To view it please enter your password below:', 'mauna' ) . '
    <label class="pass-label" for="' . $label . '">' . esc_html__( "PASSWORD:" , 'mauna') . ' </label><div class="input-group"><input name="post_password" id="' . $label . '" type="password" class="input-group-field" /><div class="input-group-button"><input type="submit" name="Submit" class="button secondary hollow" value="' . esc_attr__( "Submit", 'mauna') . '" /></div></div>
    </form>
    ';
    return $o;
}


