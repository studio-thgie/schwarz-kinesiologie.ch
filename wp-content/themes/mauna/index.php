<?php
/*
Template Name: Blog
*/

get_header(); 
$redux = mauna_get_global_option_redux();
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
?>

<section class="blog">
	<?php mauna_get_page_navigation($redux['mauna_blog_navigation']); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<div class="blog-posts margin-top-lg">
		<?php
			$query_params = array(
				'posts_per_page'=>intval($redux['mauna_blog_posts_per_page']),
				'post_type' => 'post',
				'paged' => $paged,

			);

			$postsQuery = new WP_Query( $query_params );

			if ( $postsQuery->have_posts() ) :
				while ( $postsQuery->have_posts() ) :
					$postsQuery->the_post(); 
					$full = '';
					$excerpt = false;
					if(has_excerpt()) {
						$excerpt = true;
					}

					$cat = '';
					$postCats = get_the_category(); 
					if (is_array($postCats)) {
						$length = count($postCats) - 1;
						$comma = ', ';
						foreach ($postCats as $c => $category) {
							if ($length == $c) {
								$comma = '';
							}
							$cat .= '<li><a class="link-hover link-hover-color" href="' . esc_attr(get_category_link($category->term_id)) . '" title="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a></li>' . $comma . ' ';
						}
					}
					if(has_post_thumbnail()) {
						$postClass = 'post-with-img';
						$postColumn = 'large-12';
					} else {
						$postClass = 'post-without-img';
						$postColumn = 'large-8 large-centered';
					};
		   
		?>
		<div class="row post-columns">
		<div class="small-12 medium-10 medium-centered <?php echo esc_attr($postColumn); ?> columns">
			<article class="blog-content post margin-bottom-xxl <?php echo esc_attr($postClass); ?>">
				<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-image">
					<figure>
						<a href="<?php echo esc_url(get_permalink()); ?>">
							<?php the_post_thumbnail('mauna_blog'); ?>
						</a>
						<div class="post-meta">
							<?php if(is_sticky()) {
								echo '&#9652; <em> ';
								esc_html_e('Sticky', 'mauna');
								echo ' &mdash; </em> ';
							} ?>
							<?php if($redux['mauna_blog_show_cat'] == true || !isset($redux)) : ?>
							<ul class="post-category <?php if($redux['mauna_blog_date'] == true) {echo 'post-cat-separator'; }; ?>">
								<?php echo $cat ;?>
							</ul>
							<?php endif;?>
							<?php if($redux['mauna_blog_date'] == true || !isset($redux)) : ?>
							<div class="post-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></div>
							<?php endif;?>
						</div>
					</figure>
				</div>
				<?php else : ?>
				<div class="header-without-img">
					<div class="post-meta">
						<?php if(is_sticky()) {
							echo '&#9652; <em> ';
							esc_html_e('Sticky', 'mauna');
							echo ' &mdash; </em> ';
						} ?>
						<?php if($redux['mauna_blog_show_cat'] == true || !isset($redux)) : ?>
						<ul class="post-category <?php if($redux['mauna_blog_date'] == true) {echo 'post-cat-separator'; }; ?>">
							<?php echo $cat ;?>
						</ul>
						<?php endif;?>
						<?php if($redux['mauna_blog_date'] == true || !isset($redux)) : ?>
						<div class="post-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></div>
						<?php endif;?>
					</div>
				</div>
				<?php endif; ?>
				<div class="post-content">
					<header><h5><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h5></header>
					<div class="content">
						<?php 
							if($excerpt === true) {
								the_excerpt();
								echo '<a href="'.esc_url(get_permalink()).'" class="more-link"><span class="read-more">'.esc_html__( 'Read more', 'mauna' ).'</span></a>';
							} else {
								the_content( '<span class="read-more">'.esc_html__( 'Read more', 'mauna' ).'</span>' ); 
							}
						?>
					</div>
				</div>
			</article>
		</div>
		</div>
		<?php
	endwhile;
endif;
		if($postsQuery->max_num_pages > $paged) {
			echo '<div class="blog-load-more-wrapper margin-bottom-xl btn btn-blog-load"><a class="blog-load-more link-hover link-hover-color" href="'.esc_url(next_posts($postsQuery->max_num_pages, false )).'" data-djax-exclude="true">Load more</a></div>';
		}
?>


	</div>
	<?php if(isset($redux['mauna_blog_footer_text']) && $redux['mauna_blog_footer_text'] !== '' ) : ?>
	<footer class="footer blog-footer">
		<div class="row">
			<div class="small-12 columns">
				<div class="footer-content margin-bottom-standard">
					<div class="footer-inner"><?php echo apply_filters('the_content', $redux['mauna_blog_footer_text']); ?></div>
				</div>
			</div>
		</div>
	</footer>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
