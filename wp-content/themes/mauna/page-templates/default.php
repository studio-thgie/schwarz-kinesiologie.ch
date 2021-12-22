<?php
/*
Template Name: Vertical split layout
*/

get_header(); 

$redux = mauna_get_global_option_redux();
$style = '';
$nav = (isset($redux['mauna_default2_navigation']) && $redux['mauna_default2_navigation'] != '') ? $redux['mauna_default2_navigation'] : 'small-light';
$cssClass = '';
?>
<section class="default-template2">
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<?php  if ( have_posts() ) :
			while ( have_posts() ) :
				the_post(); ?>
		<?php if (has_post_thumbnail( $post->ID )) :
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'mauna-large' );
			$id = $post->ID;
			$cssClass = 'default2_page_style_'.$id;

			$letterSpacing = $redux['mauna_default2_title_letter_spacing'];
			if($letterSpacing !== '' && isset($redux)) {
				$letterSpacing = intval($letterSpacing)/2;
			} else {
				$letterSpacing == '20';
			}

			if($letterSpacing !== '') {
				$style .= '<style scoped>
					.'.$cssClass.' .default-header-2 header h3 span { padding: 0 '.$letterSpacing.'px; }
				</style>';
			}
			?>
			<div class="half-overlay show-for-large"></div>
			<div class="bg-img" style="background-image: url('<?php echo esc_url($image[0]); ?>');">
				<img class="hide-for-large" src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr(get_the_title());?>" />
			</div>
		<?php endif; ?>
		<div class="bg-content"></div>
		<article class="default-content-2 row <?php echo esc_attr($cssClass); ?>">
			<div class="default-header-2 <?php echo esc_attr($cssClass); ?> small-10 small-centered columns">
				<?php if($redux['mauna_default2_title_enable'] == true || !isset($redux)) : ?>
				<header><h3 class="animate-header"><?php the_title(); ?></h3></header>
				<?php endif; ?>
					<?php if(isset($redux['mauna_default2_nav_list']) && $redux['mauna_default2_nav_list'] !== '') {
					   mauna_default_menu_nav($redux['mauna_default2_nav_list']);
					}; ?>
				<div class="content"> 
					<?php the_content(); ?>
				</div>
			</div>
		</article>

<?php
	endwhile;
endif;
?>
</section>

<?php 
	echo $style; 
	get_footer();