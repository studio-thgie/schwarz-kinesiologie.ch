<?php 

get_header(); 
$class = '';
$categoryId = $wp_query->get_queried_object_id();
$redux = mauna_get_global_option_redux();
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
$nav = (isset($redux['mauna_other_pages_navigation']) && $redux['mauna_other_pages_navigation'] != '') ? $redux['mauna_other_pages_navigation'] : 'small-dark';
?>

<section class="blog"> 
	<?php mauna_get_page_navigation($nav); ?>
    <?php get_template_part('template-parts/header-overlay'); ?>
	<div class="row">
		<div class="small-12 medium-10 medium-centered columns">
			<header class="archive-header"><h3>
				<?php if ( is_category() ) :
						echo esc_html__( 'Category: ', 'mauna');
						echo '<span>' . single_cat_title() . '</span>';

						elseif ( is_tag() ) :
							echo esc_html__( 'Tag: ', 'mauna');
							echo '<span>' . single_tag_title() . '</span>';

						elseif ( is_author() ) :
							
							printf( wp_kses( __( 'Author: %s', 'mauna'), array('span'=>array('class'=>array()))), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( esc_html__( 'Day: %s', 'mauna'), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( esc_html__( 'Month: %s', 'mauna'), '<span>' . get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'mauna') ) . '</span>' );

						elseif ( is_year() ) :
							printf( esc_html__( 'Year: %s', 'mauna'), '<span>' . get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'mauna') ) . '</span>' );
					endif;
				?>
			</h3></header>
		</div>
	</div> 
	<div class="blog-posts archive-blog margin-top-lg">

		<?php 
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
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
		<div class="row  post-columns">
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
								<ul class="post-category">
									<?php echo $cat ;?>
								</ul>
								<div class="post-date"><a href="<?php echo esc_url(get_permalink());?>"><?php echo get_the_date(); ?></a></div>
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
							<ul class="post-category">
								<?php echo $cat ;?>
							</ul>
							<div class="post-date"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo get_the_date(); ?></a></div>
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

			if($wp_query->max_num_pages > $paged) {
				echo '<div class="blog-load-more-wrapper margin-bottom-xl btn btn-blog-load"><a class="blog-load-more link-hover link-hover-color" href="'.esc_url(next_posts($wp_query->max_num_pages, false )).'" data-djax-exclude="true">'.esc_html__('Load more','mauna').'</a></div>';
			}
	?>


	</div>
	<?php if(isset($redux['mauna_blog_footer_text']) && $redux['mauna_blog_footer_text'] !== '' ) : ?>
	<footer class="footer blog-footer margin-bottom-standard">
		<div class="row">
			<div class="small-12 columns">
				<div class="footer-content margin-bottom-standard">
					<span><?php echo apply_filters('the_content', $redux['mauna_blog_footer_text']); ?></span>
				</div>
			</div>
		</div>
	</footer>
</section>
	<?php endif; ?>
<?php get_footer(); ?>