<?php

add_action('woocommerce_before_main_content', 'mauna_woocommerce_before_main_content');
function mauna_woocommerce_before_main_content() {
	$redux = mauna_get_global_option_redux();
	$nav = (isset($redux['mauna_woo_navigation']) && $redux['mauna_woo_navigation'] != '') ? $redux['mauna_woo_navigation'] : 'small-dark';
	echo '<section class="mauna-woocommerce">';
	mauna_get_page_navigation($nav);
	get_template_part('template-parts/header-overlay');
	echo '<div class="row"><div class="small-12 medium-10 medium-centered large-10 large-centered columns margin-top-lg">';
}

add_action('woocommerce_after_main_content', 'mauna_woocommerce_after_main_content');
function mauna_woocommerce_after_main_content() {
	echo '</div></div></section>';
}

add_action('woocommerce_after_single_product_summary', 'mauna_woocommerce_output_related_products', 25);
function mauna_woocommerce_output_related_products($content) {
	echo '<div style="clear: both"></div>';
}

add_action('woocommerce_before_shop_loop_item_title', 'mauna_woocommerce_shop_loop_item_wrapper_start', 9);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11);
add_action('woocommerce_before_shop_loop_item_title', 'mauna_woocommerce_shop_loop_item_wrapper_end', 12);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
add_action('woocommerce_shop_loop_item_title', 'mauna_woocommerce_template_loop_product_title');


function mauna_woocommerce_shop_loop_item_wrapper_start() {
	echo '<div class="mauna-single-product">';
}

function mauna_woocommerce_shop_loop_item_wrapper_end() {
	echo '</div>';
}

function mauna_woocommerce_template_loop_product_title() {
	echo '<h3><a href="'.esc_url(get_permalink()).'" title="'.esc_attr(get_the_title()).'">' . get_the_title() . '</a></h3>';
}

// remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' ); 
// add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');


function woocommerce_header_add_to_cart_fragment($fragments) { 
	global $woocommerce;
	$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
	$cart_url = $woocommerce->cart->get_cart_url();
	$checkout_url = $woocommerce->cart->get_checkout_url();
	$fragments['span.cart-icon-count'] = '<span class="cart-icon-count">'.$woocommerce->cart->cart_contents_count.'</span>';

	$cart_contents = '<ul class="show-cart">';
	
	if (sizeof($woocommerce->cart->cart_contents) == 0) {
		$cart_contents .= '<li class="product cart-empty">'. esc_html__( 'Your cart is currently empty.', 'mauna').'</li></ul><div class="summation">
			<div class="summation-subtotal">
				<span>'.__('Subtotal', 'woocommerce').':</span>
				<span class="amount header-font-family">' . WC()->cart->get_cart_subtotal() . '</span>
			</div>
			<div class="btn-cart">
				<a href="'.$cart_url.'">'.esc_html__('Go to shop', 'mauna').'</a>
				<a href="'.add_query_arg('empty-cart','', $woocommerce->cart->get_cart_url()).'">'.esc_html__('Empty cart', 'mauna').'</a>
				<a href="'.$cart_url.'">'.esc_html__('View cart', 'mauna').'</a>
				<a href="'.$checkout_url.'">'.esc_html__('Go to checkout', 'mauna').'</a>
			</div>
		</div>';
	} else {
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ($_product->is_sold_individually()) {
				$product_quantity = "1";
			} else {
				$product_quantity = $cart_item['quantity'];
			}

			$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($_product->id), 'menu_thumb' );
			
			if(empty($thumb_url)) {
				$thumb_url = '/img/placeholder.png';
			} else {
				$thumb_url = $thumb_url[0];
			}
			$cart_contents .= '<li class="product">
				<a href="'.$_product->get_permalink().'" class="img-product">
					<figure><img src="'.$thumb_url.'" alt="" /></figure>
				</a>

				<div class="list-product">
					<a href="' . $_product->get_permalink() . '"><h5>' . $_product->get_title() . '</h5></a>
					<div class="quantity buttons_added header-font-family">' . $product_quantity . '</div>
					<div class="price-product header-font-family">' . strip_tags(WC()->cart->get_product_price( $_product )) . '</div>
					<a class="remove-product" title="'.__( 'Remove this item', 'mauna' ).'" href="'.esc_url( WC()->cart->get_remove_url( $cart_item_key ) ).'"><i class="icon-close"></i></a>
				</div>
			</li>';		
		}

		// subtotal


		$cart_contents .= '</ul><div class="summation">
			<div class="summation-subtotal">
				<span>'.__('Subtotal', 'mauna').':</span>
				<span class="amount header-font-family">' . WC()->cart->get_cart_subtotal() . '</span>
			</div>
			<div class="btn-cart">
				<a href="'.esc_url($shop_page_url).'">'.esc_html__('Go to shop', 'mauna').'</a>
				<a href="'.add_query_arg('empty-cart','', $woocommerce->cart->get_cart_url()).'">'.esc_html__('Empty cart', 'mauna').'</a>
				<a href="'.esc_url($cart_url).'">'.esc_html__('View cart', 'mauna').'</a>
				<a href="'.esc_url($checkout_url).'">'.esc_html__('Go to checkout', 'mauna').'</a>
			</div>
		</div>';
	}

	// $cart_contents .= '</ul>';
	
	$fragments['ul.show-cart'] = $cart_contents;

	return $fragments;
}

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

add_action( 'init', 'mauna_woocommerce_clear_cart_url' );
function mauna_woocommerce_clear_cart_url() {
	global $woocommerce;
	if ( isset( $_GET['empty-cart'] ) ) {
		$woocommerce->cart->empty_cart();
	}
}

add_action( 'wp_enqueue_scripts', 'mauna_remove_woo_lightbox', 99 );
function mauna_remove_woo_lightbox() {
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
        wp_dequeue_script( 'prettyPhoto' );
        wp_dequeue_script( 'prettyPhoto-init' );
}


add_action( 'after_setup_theme', 'mauna_woocommerce_support' );

function mauna_woocommerce_support() {
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-zoom' );
}