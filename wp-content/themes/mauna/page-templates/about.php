<?php
/*
Template Name: About
*/

get_header(); 

$redux = mauna_get_global_option_redux();
$categories = get_post_meta(get_the_id(), 'mauna_about_categories', true);
$params = array(
	'post_type' => 'mauna_about_item',
	'posts_per_page' => -1,
);

if(is_array($categories) && !empty($categories)) {
	$params['tax_query'] = array(array(
		'taxonomy' => 'mauna_about_categories',
		'terms' => $categories,
		'field' => 'term_id'
	));
}
$the_query = new WP_Query($params);
$style = '';
?>

<section class="about">
	
	<?php mauna_get_page_navigation('large-dark'); ?>
	<?php mauna_get_page_navigation('large-light'); ?>
	<?php mauna_get_page_navigation('small-dark'); ?>
	<?php mauna_get_page_navigation('small-light'); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>

	<?php if($redux['mauna_about_arrow'] == true) : ?>
		<div class="nav-slider-arrows show-for-large">
			<div class="arrow-slide next-slide">
				<svg viewBox="0 0 50 25">
					<g fill="none" stroke="" stroke-width="3">
						<path class="lineAB" stroke-linecap="round" d="M4 0 l21 23" />
						<path class="lineBC" stroke-linecap="round" d="M46 0 l-21 23" />
					</g>
				</svg>
			</div>
		</div>
	<?php endif; ?>
	<div class="about-sections" data-pagination="<?php echo esc_attr($redux['mauna_about_pagination']); ?>">
		<?php
			$counter = 0;
			if ($the_query->have_posts()) :
				while ($the_query->have_posts()) :
					$the_query->the_post(); 
					$image = '';
					if (has_post_thumbnail( $post->ID )) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'mauna_home2' );
						$image = 'background-image: url('.$image[0].')';
					}
					$id = $post->ID;
					$cssClass = 'about_style_'.$id;

			$overlayColor = get_post_meta($post->ID, 'mauna_about_overlay_color', true);
			if($overlayColor == '') {
				$overlayColor = $redux['mauna_about_overlay_color'];
			}
			$contentOverlay = get_post_meta($post->ID, 'mauna_about_overlay_content_color', true);
			if($contentOverlay == '') {
				$contentOverlay = $redux['mauna_about_overlay_content_color'];
			}
			$txtColor = get_post_meta($post->ID, 'mauna_about_txt_color', true);
			if($txtColor == '') {
				$txtColor = $redux['mauna_about_txt_color'];
			}
			$elColor = get_post_meta($post->ID, 'mauna_about_txt_color2', true);
			if($elColor == '') {
				$elColor = $redux['mauna_about_txt_color2'];
			}
			$hoverColor = get_post_meta($post->ID, 'mauna_about_hover_color', true);
			if($hoverColor == '') {
				$hoverColor = $redux['mauna_about_hover_color'];
			}
			$hoverColor2 = get_post_meta($post->ID, 'mauna_about_hover_color2', true);
			if($hoverColor2 == '') {
				$hoverColor2 = $redux['mauna_about_hover_color2'];
			}
			$arrowBg = get_post_meta($post->ID, 'mauna_about_arrow_bg_color', true);
			if($arrowBg == '') {
				$arrowBg = $redux['mauna_about_arrow_bg_color'];
			}
			$classPos = get_post_meta($post->ID, 'mauna_about_content_position', true);
			if($classPos == '') {
				$classPos = 'pos_left';
			}
			$col = '';
			if($classPos == 'pos_right') {
				$col = 'large-offset-6 large-6';
			} 
			if($classPos == 'pos_left') {
				$col = 'large-uncentered large-6';
			}
			if($classPos == 'pos_center') {
				$col = 'large-8';
			}

			$openContent = get_post_meta($post->ID, 'mauna_about_open_overlay', true);
			if($openContent == 'true' || $openContent == '') {
				$openClass = 'open-content';
			} else {
				$openClass = 'close-content';
			}

			$videoUrl = get_post_meta( $post->ID, 'mauna_about_video_link', true );
			if(get_post_meta($post->ID, 'mauna_about_video_mute', true) == '1' || get_post_meta($post->ID, 'mauna_about_video_mute', true) == '') {
				$mute = 'true';
			} else {
				$mute = 'false';
			}
			$postTypeClass = '';
			if(get_post_meta($post->ID, 'mauna_about_post_type', true) == 'video') {
				$postTypeClass = 'about-video';
			}

			$videoStartAt = get_post_meta($post->ID, 'mauna_about_video_start', true);
			$videoStartAt = ($videoStartAt == '' ) ? 0 : $videoStartAt;
			$autoplay = 'false';

			$id = $post->ID;
			$cssClass = 'promotion_page_style_'.$id;

			$letterSpacing = $redux['mauna_about_title_letter_spacing'];
			if($letterSpacing !== '') {
				$letterSpacing = intval($letterSpacing)/2;
			} else {
				$letterSpacing == '';
			}

			if($letterSpacing !== '') {
				$style .= '
					.'.$cssClass.' .about-content-wrapper header h3 span { padding: 0 '.$letterSpacing.'px; }
				';
			}
			$mask = get_post_meta( $post->ID, 'mauna_about_video_mask', true );
			$navigation = get_post_meta($post->ID, 'mauna_about_navigation', true);
			if($navigation == '') {
				$navigation = 'small-light';
			}
			$style .= '

				.'.$cssClass.' .section-overlay { background-color: '.$overlayColor.'; }
				.'.$cssClass.' .half-overlay { background-color: '.$contentOverlay.'; }
				.'.$cssClass.' .about-content, .'.$cssClass.' .about-content-wrapper { color: '.$txtColor.'; }
				.'.$cssClass.' .mobile-video-controls .circle-light { stroke: '.$txtColor.'; }
				.'.$cssClass.' .mobile-video-controls polygon { fill: '.$txtColor.'}
				.'.$cssClass.' .mobile-video-controls .circle-dark { fill: '.$contentOverlay.'}
				.'.$cssClass.' .close-content-section a, .'.$cssClass.' .open-content-section a { color: '.$elColor.'; }
				.'.$cssClass.' .separator-color { background-color: '.$hoverColor.'; }
				.'.$cssClass.' .about-content a { background-image: linear-gradient(180deg,transparent 0%,'.$hoverColor.' 0); }
				.'.$cssClass.' .link-hover:before { background-color: '.$hoverColor2.'; }
			';
		?>

		<article class="section bg-img about-section <?php echo esc_attr($classPos); ?> <?php echo esc_attr($openClass); ?> <?php echo esc_attr($cssClass); ?> <?php echo esc_attr($postTypeClass); ?>" style="<?php echo esc_attr($image); ?>" data-arrow-color="<?php echo esc_attr($elColor); ?>" data-arrow-bg="<?php echo esc_attr($arrowBg); ?>" data-arrow-hover="<?php echo esc_attr($hoverColor2); ?>" data-pagination="<?php echo esc_attr($elColor); ?>" data-pagination-hover="<?php echo esc_attr($hoverColor2); ?>" data-anchor="<?php echo esc_attr($post->post_name); ?>" data-navigation="<?php echo esc_attr($navigation); ?>">
			<?php if(get_post_meta($post->ID, 'mauna_about_post_type', true) == 'video') : ?>
			<div class="video-mask" style="background-image: url('<?php echo esc_url($mask);?>')"></div>
			<div class="video-about-wrapper" style="position: absolute; left: 0; right: 0; top: 0; bottom: 0; z-index: -1; ">
				<div class="video-wrapper-<?php echo get_the_id();?>" style="position:absolute; left: 0; top: 0; right: 0; bottom: 0; "></div>
				<div id="P1-<?php echo get_the_id();?>" class="player" style="display:block; margin: auto; background: rgba(0,0,0,0.5); " data-property="{videoURL:'<?php echo ($videoUrl != '') ? $videoUrl : 'http://youtu.be/dSpQ5zdR4dE'?>',containment:'.video-wrapper-<?php echo get_the_id();?>',startAt:<?php echo esc_attr($videoStartAt); ?>,mute:<?php echo esc_attr($mute); ?>,autoPlay:<?php echo esc_attr($autoplay); ?>,loop:true,opacity:1, showControls: false}"></div>
			</div>
			<div class="mobile-video-controls">
				<a class="swipebox-video" data-rel="video" href="<?php echo esc_url($videoUrl); ?>">
					<svg height="100" width="100" viewbox="0 0 200 200">
						<circle class="circle-light" cx="100" cy="100" r="80" stroke-width="28" fill="none" />
						<circle class="circle-dark" cx="100" cy="100" r="66" />
						<polygon points="85,75 85,125 125,100"/>
					</svg>
				</a>
			</div>
			<?php endif; ?>
			<?php if($classPos !== 'pos_none') : ?>
			<div class="half-overlay"></div>
			<div class="section-overlay"></div>
			<div class="row">
				<div class="small-12 medium-10 medium-centered <?php echo esc_attr($col); ?> columns">
					<div class="about-content-wrapper">
						<header>
							<h3 class="animate-header"><?php echo get_the_title(); ?></h3>
							<div class="separator-color"></div>
						</header>
						<div class="about-content content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="close-content-section"><a href="#" class="link-hover" data-djax-exclude="true"><?php echo esc_html($redux['mauna_about_close']); ?></a></div>
			<div class="open-content-section"><a href="#" class="link-hover" data-djax-exclude="true"><?php echo esc_html($redux['mauna_about_open']); ?></a></div>
			<?php endif; ?>
		</article>
		
		<?php
			$counter++;
			endwhile; 
			endif;
		?>
	</div>
</section>
<div class="hidden custom-styles">
<?php
$style = trim(preg_replace('/\s+/', ' ', $style));
echo $style; 
?>
</div>
<?php get_footer(); ?>