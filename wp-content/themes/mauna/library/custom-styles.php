<?php
	function mauna_link_gradient() {
		$redux = mauna_get_global_option_redux();
		$colorOffCanvas = $redux['mauna_colors_off_canvas_hover'];
		$colorBlog = $redux['mauna_blog_hover_color'];
		$colorDefault = $redux['mauna_default_color_hover'];
		$colorAccentDefault = $redux['mauna_default_color_accent'];
		$colorDefault2 = $redux['mauna_default2_color_hover'];
		$colorPromotion = $redux['mauna_promotion_hover_post'];
		$colorPromotion2 = $redux['mauna_promotion_color_accent'];
		$colorPortfolio1 = $redux['mauna_portfolio_filters_hover'];
		$colorPortfolio2 = $redux['mauna_portfolio2_filters_hover'];
		$colorPortfolio3 = $redux['mauna_portfolio3_hover'];
		$colorPortfolio4 = $redux['mauna_portfolio4_hover'];

		$colorWoo = $redux['mauna_woo_hover_color'];

		$clear = 0;
		$clear = $redux['mauna_home_break_line'];
		$output = '.blog .content a, .blog-content header h5 a { background-image: linear-gradient(180deg,transparent 0%,'.$colorBlog.' 0); }';
		$output .= '.off-canvas-content .content a { background-image: linear-gradient(180deg,transparent 0%,'.$colorOffCanvas.' 0); }';
		$output .= '.default-template .default-content a { background-image: linear-gradient(180deg,transparent 0%,'.$colorDefault.' 0); }';
		$output .= '.default-template2 .default-content-2 a { background-image: linear-gradient(180deg,transparent 0%,'.$colorDefault2.' 0); }';
		$output .= '.default-template .header-wrapper a { background-image: linear-gradient(180deg,transparent 0%,'.$colorAccentDefault.' 0); }';
		$output .= '.promotion-news .header-wrapper a { background-image: linear-gradient(180deg,transparent 0%,'.$colorPromotion2.' 0); }';
		$output .= '.promotion-single-post .content a { background-image: linear-gradient(180deg,transparent 0%,'.$colorPromotion.' 0); }';
		$output .= '.portfolio-filters a { background-image: linear-gradient(180deg,transparent 0%,'.$colorPortfolio1.' 0); }';
		$output .= '.portfolio2-filters a { background-image: linear-gradient(180deg,transparent 0%,'.$colorPortfolio2.' 0); }';
		$output .= '.portfolio3-filters a { background-image: linear-gradient(180deg,transparent 0%,'.$colorPortfolio3.' 0); }';
		$output .= '.portfolio4-filters a { background-image: linear-gradient(180deg,transparent 0%,'.$colorPortfolio4.' 0); }';

		$output .= '.woocommerce-breadcrumb a, .woocommerce ul.products li.product h3 a, .woocommerce-page .woocommerce-MyAccount-content a { background-image: linear-gradient(180deg,transparent 0%,'.$colorWoo.' 0); }';

		if($clear != 0) {
			$output .= '.home-nav .nav li:nth-child('.$clear.'n+1){clear:left}';
		}
		wp_add_inline_style ( 'mauna-main-stylesheet', $output );
	}

	add_action('wp_enqueue_scripts', 'mauna_link_gradient', 11);
