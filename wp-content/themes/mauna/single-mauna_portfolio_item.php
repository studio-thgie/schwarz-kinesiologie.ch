<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

$redux = mauna_get_global_option_redux();
$footerContent = $redux['mauna_footer_text'];
$shareData = array();
$nav = get_post_meta($post->ID, 'mauna_portfolio_single_navigation', true);
$nav = (isset($nav) && $nav != '') ? $nav : 'small-light';
$hoverImage = get_post_meta( $post->ID, 'mauna_portfolio_item_hover-image_thumbnail_id', true );
if($hoverImage != false && $hoverImage !== '') {
	$hoverImage = wp_get_attachment_image_src( $hoverImage, 'mauna-large');
}
$gallery = get_post_meta($post->ID, 'mauna_portfolio_item_gallery', true);
$videoLinks = get_post_meta($post->ID, 'mauna_portfolio_video', true);
$attachments = array_filter( explode( ',', $gallery ) );
$attachment_meta = wp_prepare_attachment_for_js(get_post_thumbnail_id($post->ID));
$attachment_caption = $attachment_meta['caption'];
$attachment_caption = 'title="'.esc_attr($attachment_caption).'"';
$openLightbox = $redux['mauna_portfolio_single_lightbox_open'];


$shareData = array('title'=>get_the_title(), 'url'=>esc_url(get_permalink()));
$shareImage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
if(isset($shareImage[0])) {
	$shareImage = $shareImage[0];
	$shareData['image'] = $shareImage;
}
$intro = get_post_meta($post->ID, 'mauna_portfolio_single_intro', true);
if($intro == '') {
	$intro = true;
}
if($intro == true && has_post_thumbnail()) {
	$rowClass = 'margin-top-intro';
} else {
	$rowClass = 'margin-top-lg';
}

if($nav == 'small-dark' || $nav == 'large-dark') {
	$titleColor = 'dark-title';
} else {
	$titleColor = 'light-title';
}
$style = "";
get_header(); ?>

<section id="portfolio-single-post" role="main" class="portfolio-single-post">
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php if($intro == true && has_post_thumbnail()) : ?>
	<div class="portfolio-single-intro">
		<?php if($redux['mauna_portfolio_single_title'] == true) : ?>
		<?php 
			$id = $post->ID;
			$cssClass = 'portfolio_single_style_'.$id;

			$letterSpacing = get_post_meta($post->ID, 'mauna_portfolio_single_title_letter_spacing', true);

			$fontSize = get_post_meta($post->ID, 'mauna_portfolio_single_title_font_size', true);
			$fontSize = $fontSize['font-size'];

			if($letterSpacing !== '' && isset($redux)) {
				$letterSpacing = intval($letterSpacing)/2;
			} else {
				$letterSpacing = '20';
			}
			if($fontSize !== '' && isset($redux)) {
				$fontSize = intval($fontSize);
			} else {
				$fontSize = '40';
			}

			// if($letterSpacing !== '') {
				$style .= '<style scoped>
					.portfolio-single-intro .'.$cssClass.' header h3 span { padding: 0 '.$letterSpacing.'px; }
					.portfolio-single-intro .'.$cssClass.' header h3 { font-size: '.$fontSize.'px}
				</style>';
			// }
		;?>
		
		<div class="portfolio-single-title <?php echo esc_attr($cssClass); ?>  <?php echo esc_attr($titleColor); ?>">
			<div class="row">
				<div class="small-12 columns">
					<header><h3 class="animate-header"><?php the_title(); ?></h3></header>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="nav-slider-arrows show-for-large portfolio-arrow-intro">
			<div class="arrow-slide next-slide">
				<svg viewBox="0 0 50 25">
					<g fill="none" stroke="" stroke-width="3">
						<path class="lineAB" stroke-linecap="round" d="M4 0 l21 23" />
						<path class="lineBC" stroke-linecap="round" d="M46 0 l-21 23" />
					</g>
				</svg>
			</div>
		</div>
		<?php if(has_post_thumbnail()) : ?>
		<div class="post-image-intro">
			<figure>
				<img class="hide" src="<?php echo esc_url(the_post_thumbnail_url()); ?>" /> 
			   	<span class="img-bg-1" style="background-image: url(<?php echo esc_url(the_post_thumbnail_url());?>)"></span>  
	        </figure>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="row <?php echo $rowClass; ?>">
		<div class="small-12 large-4 float-right columns portfolio-sidebar">
			<div class="portfolio-post-content">
				<header><h3><?php the_title(); ?></h3></header>
				<div class="content">
					<?php the_content(); ?>
<?php the_tags( '<div class="post-tags margin-top-lg"><span>Tags: </span>', // before 
					', ', // separator 
					'</div>' // after
					); ?>
				</div>
				<?php if($redux['mauna_portfolio_single_show_shares'] == true || !isset($redux)) : ?>
				<div class="post-footer">
					<div class="post-share margin-top-lg">
						<div class="share-header show-for-large"><?php esc_attr_e( 'Share on', 'mauna');?></div>
						<div class="share-header mobile-share hide-for-large"><a href="#" data-djax-exclude="true" class="link-hover link-hover-color"><?php esc_html_e( 'Share on', 'mauna');?></a></div>
						<ul class="shares">
							<?php echo mauna_get_share_links($shareData); ?>
						</ul>
					</div>
				</div>
				<?php endif; ?> 
			</div>
		</div>
		<div class="small-12 large-8 float-left columns">
			<div class="gallery-single-portfolio">
				<?php if(!empty($attachments)) {

				foreach ($attachments as $image_lightbox) {
					if($image_lightbox != '') {
					$attachment_meta = wp_prepare_attachment_for_js($image_lightbox);

					if($redux['mauna_portfolio4_caption'] == true) {
						$attachment_caption = $attachment_meta['caption'];
						$attachment_caption = 'title="'.esc_attr($attachment_caption).'"';
					} else {
						$attachment_caption = '';
					}
					$image_lightbox = wp_get_attachment_image_src( $image_lightbox, 'mauna-large');
					$image_lightbox = $image_lightbox[0];
				?>
				<div class="post-image">
					<?php if($openLightbox == true) : ?>
					<a href="<?php echo esc_url($image_lightbox);?>" data-rel="portfolio_group<?php echo esc_attr($post->ID);?>" class="swipebox" <?php echo $attachment_caption; ?>>
					<?php endif; ?>
						<figure>
							<img src="<?php echo esc_url($image_lightbox); ?>"/>
						</figure>
					<?php if($openLightbox == true) : ?>
					</a>
					<?php endif; ?>
				</div>
				<?php }}} ?>
				<?php 
					if(isset($videoLinks) && $videoLinks !== '') {
						foreach ($videoLinks as $video) { 
							if($video != '') {
								echo apply_filters('the_content', $video);
						 } }
				}; ?>
			</div>
		</div>
	</div>
	<footer class="footer blog-footer">
		<div class="row">
			<div class="small-12 columns">
				<?php if(isset($footerContent) && $footerContent != '') : ?>
				<div class="footer-content content margin-bottom-standard">
					<span><?php echo apply_filters('the_content', $footerContent); ?></span>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</footer>
	<?php endwhile;?>
</section>
<?php echo $style; 
get_footer();;
