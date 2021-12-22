<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */
$redux = mauna_get_global_option_redux();

?>

</div>
</div>


<?php if(class_exists('WooCommerce')) : ?>
<div class="cart-offcanvas">
	<?php
	global $woocommerce;
	$shop_page_url = wc_get_page_permalink('shop');
	$cart_url = $woocommerce->cart->get_cart_url();
	$checkout_url = $woocommerce->cart->get_checkout_url();

	$after = '';
		$after .= '<div class="cart-offcanvas-close">'.esc_html__('Close cart', 'mauna').'</div><ul class="show-cart">';
	
		if ( sizeof( $woocommerce->cart->cart_contents ) == 0 ) {
			$after .= '<li class="product cart-empty">'. esc_html__( 'Your cart is currently empty.', 'mauna').'</li></ul><div class="summation">
				<div class="summation-subtotal">
					<span>'.__('Subtotal', 'woocommerce').':</span>
					<span class="amount header-font-family">' . WC()->cart->get_cart_subtotal() . '</span>
				</div>
				<div class="btn-cart">
					<a href="'.esc_url($shop_page_url).'">'.esc_html__('Go to shop', 'mauna').'</a>
					<a href="'.add_query_arg('empty-cart','', $woocommerce->cart->get_cart_url()).'">'.esc_html__('Empty cart', 'mauna').'</a>
					<a href="'.esc_url($cart_url).'">'.esc_html__('View cart', 'mauna').'</a>
					<a href="'.esc_url($checkout_url).'">'.esc_html__('Go to checkout', 'mauna').'</a>
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

				// var_dump($_product);
				$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($_product->get_id()), 'menu_thumb' );
				
				if(empty($thumb_url)) {
					$thumb_url = '';
				} else {
					$thumb_url = $thumb_url[0];
				}
				$after .= '<li class="product">
					<a href="'.$_product->get_permalink().'" class="img-product">
						<figure><img src="'.$thumb_url.'" alt="" /></figure>
					</a>

					<div class="list-product">
						<a href="' . $_product->get_permalink() . '"><h5>' . $_product->get_title() . '</h5></a>
						<div class="quantity buttons_added header-font-family">' . $product_quantity . '</div>
						<div class="price-product header-font-family">' . strip_tags(WC()->cart->get_product_price( $_product )) . '</div>
						<a class="remove-product" title="'.__( 'Remove this item', 'mauna').'" href="'.esc_url( WC()->cart->get_remove_url( $cart_item_key ) ).'"><i class="icon-close"></i></a>
					</div>
				</li>';
			}

			// subtotal

			$after .= '<li class="summation">
				<div class="summation-subtotal">
					<span>'.esc_html__('Subtotal', 'woocommerce').':</span>
					<span class="amount header-font-family">' . WC()->cart->get_cart_subtotal() . '</span>
				</div>
				<div class="btn-cart">
					<a href="'.esc_url($shop_page_url).'">'.esc_html__('Go to shop', 'mauna').'</a>
					<a href="'.add_query_arg('empty-cart','', $woocommerce->cart->get_cart_url()).'">'.esc_html__('Empty cart', 'mauna').'</a>
					<a href="'.esc_url($cart_url).'">'.esc_html__('View cart', 'mauna').'</a>
					<a href="'.esc_url($checkout_url).'">'.esc_html__('Go to checkout', 'mauna').'</a>
				</div>
			</li>';
			}
		$after .= '</ul></li>';
		echo $after;
	?>
</div>
<?php endif; ?>


<?php if($redux['mauna_general_arrow_top'] == '1' || $redux['mauna_general_arrow_top'] == '') : ?>
<a id="scroll-up" class="no-rd scroll-up hide-for-small-only">
	<div class="arrow-slide next-slide">
		<svg viewBox="0 0 50 7">
			<g fill="none" stroke="" stroke-width="2">
				<path class="lineAB" stroke-linecap="round" d="M16 0 l8 10" />
				<path class="lineBC" stroke-linecap="round" d="M32 0 l-8 10" />
			</g>
		</svg>
	</div>
</a>
<?php endif; ?>
<div class="page-mask"></div>
<?php wp_footer(); ?>

</body>
</html>
