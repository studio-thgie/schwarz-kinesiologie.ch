<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

$redux = mauna_get_global_option_redux();
$footerContent = $redux['mauna_footer_text'];
$nav = (isset($redux['mauna_promotion_single_navigation']) && $redux['mauna_promotion_single_navigation'] != '') ? $redux['mauna_promotion_single_navigation'] : 'small-dark';
get_header(); ?>

<section id="promotion-single-post" role="main" class="blog single-post promotion-single-post">
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<div class="row blog-posts margin-top-lg">
		<?php if(has_post_thumbnail()) {
				$postClass = 'post-with-img';
				$postColumn = 'large-12';
			} else {
				$postClass = 'post-without-img';
				$postColumn = 'large-8 large-centered';
			}; ?>
		<div class="small-12 medium-10 medium-centered <?php echo esc_attr($postColumn); ?> columns">
			
			<?php $cat = '';
			$postCats = get_the_category(); 
			if (is_array($postCats)) {
				$length = count($postCats) - 1;
				$comma = ', ';
				foreach ($postCats as $c => $category) {
					if ($length == $c) {
						$comma = '';
					}
					$cat .= '<li><a class="link-hover link-hover-color" href="' . esc_attr(get_category_link($category->term_id)) . '" title="' . esc_attr($category->name) . '">' . $category->name . '</a></li>' . $comma . ' ';
				}
			} ?>
			<article class="blog-content post margin-bottom-xl <?php echo esc_attr($postClass); ?>">
				<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-image">
					<figure>
						<?php the_post_thumbnail('mauna_blog'); ?>
						<div class="post-meta">
							<?php if($redux['mauna_post_date'] == true) : ?>
							<div class="post-date"><?php echo get_the_date(); ?></div>
							<?php endif;?>
						</div>
					</figure>
				</div>
				<div class="post-content">
					<header><?php echo get_post_meta($post->ID, 'mauna_promotion_item_title', true); ?></header>
					<div class="content">
						<?php the_content(); ?>
					</div>
				</div>
				<?php else : ?>
				<div class="header-without-img">
					<div class="post-meta">
						<div class="post-meta">
							<?php if($redux['mauna_post_date'] == true) : ?>
							<div class="post-date"><?php echo get_the_date(); ?></div>
							<?php endif;?>
						</div>
					</div>
				</div>
				<div class="post-content">
					<header><?php echo get_post_meta($post->ID, 'mauna_promotion_item_title', true); ?></header>
					<div class="content">
						<?php the_content(); ?>
					</div>
				</div>
				<?php endif; ?> 
			</article>
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
<?php get_footer();