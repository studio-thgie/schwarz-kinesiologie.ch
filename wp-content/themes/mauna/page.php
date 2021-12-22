<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

get_header(); 
$redux = mauna_get_global_option_redux();
$style = $cssClass = '';

$nav = (isset($redux['mauna_page_navigation']) && $redux['mauna_page_navigation'] != '') ? $redux['mauna_page_navigation'] : 'small-light';

$intro = get_post_meta($post->ID, 'mauna_page_intro', true);
if($intro == '') {
	$intro = true;
}
if($intro == true && has_post_thumbnail()) {
	$rowClass = 'margin-top-intro';
} else {
	$rowClass = 'margin-top-lg';
}
if($redux['mauna_page_navigation'] == 'small-dark' || $redux['mauna_page_navigation'] == 'large-dark') {
	$titleColor = 'dark-title';
} else {
	$titleColor = 'light-title';
}
?>

<section class="page-template default-page-template">
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<?php  if ( have_posts() ) :
		while ( have_posts() ) :
			the_post(); ?>
	<?php if($intro == true && has_post_thumbnail()) : ?>
	<div class="default-template-intro">
		<?php if($redux['mauna_page_title'] == true) : ?>
		<?php 
			$id = $post->ID;
			$cssClass = 'default_template_style_'.$id;

			$letterSpacing = $redux['mauna_page_title_letter_spacing'];
			if($letterSpacing !== '' && isset($redux)) {
				$letterSpacing = intval($letterSpacing)/2;
			} else {
				$letterSpacing = '20';
			}

			// if($letterSpacing !== '') {
				$style .= '<style scoped>
					.'.$cssClass.' header h3 span { padding: 0 '.$letterSpacing.'px; }
				</style>';
			// }
		;?>
		
		<div class="default-template-title <?php echo esc_attr($cssClass); ?>  <?php echo esc_attr($titleColor); ?>">
			<div class="row">
				<div class="small-12 columns">
					<header><h3 class="animate-header"><?php the_title(); ?></h3></header>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="nav-slider-arrows show-for-large default-arrow-intro">
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
	<?php if($intro == true && has_post_thumbnail()) : ?>
	<div class="page-content-wrapper">
	<?php else : ?>
	<div class="page-content-wrapper margin-top-xl">
	<?php endif; ?>
		<div class="page-content">

			<div class="row <?php echo $rowClass; ?>">
				<div class="small-12 medium-10 columns small-centered content">
				 <?php the_content(); ?>

				</div>

			</div>
		<?php if (comments_open()) : ?>

			<div class="row blog-comments">
				<div class="small-10 small-centered medium-6 large-5 medium-centered large-centered columns">
					<div class="post-comments margin-bottom-lg">
						<?php comments_template(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		</div>
	</div>
	<?php endwhile; ?>
<?php endif; ?>
</section>
<?php echo $style; 
get_footer();