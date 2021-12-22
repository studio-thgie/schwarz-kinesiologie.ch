<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

$shareData = array();
$redux = mauna_get_global_option_redux();
get_header(); 


$nav = (isset($redux['mauna_post_navigation']) && $redux['mauna_post_navigation'] != '') ? $redux['mauna_post_navigation'] : 'small-dark';
?>

<section id="single-post" role="main" class="blog single-post">
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
			$shareData = array('title'=>get_the_title(), 'url'=>esc_url(get_permalink()));
			$shareImage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			if(isset($shareImage[0])) {
				$shareImage = $shareImage[0];
				$shareData['image'] = $shareImage;
			}
			$postCats = get_the_category(); 
			if (is_array($postCats)) {
				$length = count($postCats) - 1;
				$comma = ', ';
				foreach ($postCats as $c => $category) {
					if ($length == $c) {
						$comma = '';
					}
					$cat .= '<li><a class="link-hover link-hover-color" href="' . esc_url(get_category_link($category->term_id)) . '" title="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a></li>' . $comma . ' ';
				}
			} ?>  
			<article class="blog-content post margin-bottom-xl <?php echo esc_attr($postClass); ?>">
				<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-image">
					<figure>
						<?php the_post_thumbnail('mauna_blog'); ?>
						 <?php if($redux['mauna_post_show_shares'] == true || !isset($redux)) : ?>
						<div class="post-share margin-top-lg show-for-large">
							<div class="share-header"><?php esc_html_e( 'Share on', 'mauna');?></div>
							<ul class="shares">
								<?php echo mauna_get_share_links($shareData); ?>
							</ul>
						</div>
						<?php endif;?>
						<div class="post-meta">
							<?php if($redux['mauna_post_show_cat'] == true || !isset($redux)) : ?>
							<ul class="post-category <?php if($redux['mauna_post_date'] == true) {echo 'post-cat-separator'; }; ?>">
								<?php echo $cat ;?>
							</ul>
							<?php endif;?>
							<?php if($redux['mauna_post_date'] == true || !isset($redux)) : ?>
							<div class="post-date"><?php echo get_the_date(); ?></div>
							<?php endif;?>
						</div>
						
					</figure>
				</div>
				<div class="post-content">
					<header><h5><?php the_title(); ?></h5></header>
					<div class="content">
						<?php the_content(); ?>
					</div>
					<?php if($redux['mauna_post_tag'] == true || !isset($redux)) : ?>
					 <?php the_tags( '<div class="post-tags margin-top-lg"><span>Tags: </span>', // before 
					', ', // separator 
					'</div>' // after
					); ?>
					<?php endif; ?> 
				</div>
					<?php if($redux['mauna_post_show_shares'] == true || !isset($redux)) : ?>
					<div class="post-footer">
						<div class="post-share margin-top-lg hide-for-large">
							<div class="share-header mobile-share"><a href="#" data-djax-exclude="true" class="link-hover link-hover-color"><?php esc_html_e( 'Share on', 'mauna');?></a></div>
							<ul class="shares">
								<?php echo mauna_get_share_links($shareData); ?>
							</ul>
						</div>
					</div>
					<?php endif; ?>
				<?php else : ?>
				<div class="header-without-img">
					<div class="post-meta">
						<div class="post-meta">
							<?php if($redux['mauna_post_show_cat'] == true || !isset($redux)) : ?>
							<ul class="post-category <?php if($redux['mauna_post_date'] == true) {echo 'post-cat-separator'; }; ?>">
								<?php echo $cat ;?>
							</ul>
							<?php endif;?>
							<?php if($redux['mauna_post_date'] == true || !isset($redux)) : ?>
							<div class="post-date"><?php echo get_the_date(); ?></div>
							<?php endif;?>
						</div>
					</div>
				</div>
				<div class="post-content">
					<header><h5><?php the_title(); ?></h5></header>
					<div class="content">
						<?php the_content(); ?>
					</div>
						<?php $args = array(
							'before'           => '<div class="page-link-next-prev post-pagination">',
							'after'            => '</div>',
							'link_before'      => '',
							'link_after'       => '',
							'next_or_number'   => 'next',
							'nextpagelink'     => '<div class="next">'.esc_html__('Continue reading', 'mauna').'</div>',
							'previouspagelink' => '<div class="prev">'.esc_html__('Go back', 'mauna').'</div>',
							'pagelink'         => '%',
							'more_file'        => '',
							'echo'             => 1 ); ?>

						<?php wp_link_pages( $args ); ?>
					<?php the_tags( '<div class="post-tags margin-top-lg"><span>'.esc_html__('Tags:', 'mauna').' </span>', // before 
					', ', // separator 
					'</div>' // after
					); ?>
				</div>

					<?php if($redux['mauna_post_show_shares'] == true || !isset($redux)) : ?>
					<div class="post-footer">
						<div class="post-share margin-top-lg">
							<div class="share-header show-for-large"><?php esc_attr_e( 'Share on', 'mauna');?></div>
							<div class="share-header mobile-share hide-for-large"><a href="#" class="link-hover link-hover-color"><?php esc_html_e( 'Share on', 'mauna');?></a></div>
							<ul class="shares">
								<?php echo mauna_get_share_links($shareData); ?>
							</ul>
						</div>
					</div>
					<?php endif; ?> 
			   
				<?php endif; ?> 

			</article>           
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
	<?php if($redux['mauna_post_show_related'] == true) : ?>
	<div class="row related-posts">
		<?php 
		$singlePostId = get_the_ID();
		$singlePost = get_post($singlePostId);
		$relatedPostsType = $redux['mauna_post_show_related_type'];

		$post = get_post($singlePostId);
		$relatedPosts = ($relatedPostsType == 'tags') ? wp_get_post_tags($post->ID) : wp_get_post_categories($post->ID);
		if ($relatedPosts) {
			$related_ids = array();
			if ($relatedPostsType == 'tags') {
				foreach($relatedPosts as $relatedPost) {
					$related_ids[] = $relatedPost->term_id;
				}

				$args = array(
					'tag__in' => $related_ids,
					'post__not_in' => array($singlePostId),
					'posts_per_page' => 1,
					'ignore_sticky_posts'=>1,
					'orderby' => 'rand'
				);
			} else {
				
				$args = array(
					'category__in' => $relatedPosts,
					'post__not_in' => array($singlePostId),
					'posts_per_page' => 1,
					'ignore_sticky_posts'=>1,
					'orderby' => 'rand'
				);
			}
			$related_query = new WP_Query($args);
			
			while ($related_query->have_posts()) {	
				$related_query->the_post();
				$relatedPost = $related_query->post;
				if(has_post_thumbnail()) {
					$postRealtedClass = 'post-with-img';
					$postRealtedColumn = 'large-12';
				} else {
					$postRealtedClass = 'post-without-img';
					$postRealtedColumn = 'large-8 large-centered';
				};

				$circle = '';
				if($redux['mauna_blog_circle_enable'] == true) {
					if($redux['mauna_blog_type_decoration'] == 'circle') {
						$circle = '<div class="circle-decoration decoration margin-bottom-xl '.esc_attr($redux['mauna_blog_circle_position']).'">
							<svg height="300" width="300">
							  <circle cx="150" cy="150" r="140" stroke-width="20" fill="none" />
							</svg>
						</div>';
					} elseif($redux['mauna_blog_type_decoration'] == 'triangle') {
						$circle = '<div class="triangle-decoration decoration margin-bottom-xl '.esc_attr($redux['mauna_blog_circle_position']).'">
							<svg height="400" width="400">
								<polygon fill="none" points="20,300 380,380 300,20"/>
							</svg>
						</div>';
					} elseif($redux['mauna_blog_type_decoration'] == 'square') {
						$circle = '<div class="square-decoration decoration margin-bottom-xl '.esc_attr($redux['mauna_blog_circle_position']).'">
							<svg height="400" width="400">
								<polygon fill="none" points="200,20 20,200 200,380 380,200"/>
							</svg>
						</div>';
					} elseif($redux['mauna_blog_type_decoration'] == 'custom') {
						$svg = $redux['mauna_blog_type_decoration_custom'];
						$svg = $svg['id'];
						$svg = get_attached_file($svg);
						$circle = '<div class="custom-decoration decoration '.esc_attr($redux['mauna_blog_circle_position']).'">'.file_get_contents($svg).'</div>';
					}
				}

				$output = '';
				$output .= '<div class="small-12 columns '.esc_attr($postRealtedColumn).'">'.$circle.'
							<article class="blog-content post '.esc_attr($postRealtedClass).' margin-bottom-lg">';
							if ( has_post_thumbnail($relatedPost->ID) ) {
								$output .= '<div class="post-image">
									<figure><a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($relatedPost->ID, 'mauna_blog').'</a></figure>
								</div>';
							}

					$output .= '<div class="post-content">
									<header><h5><a href="'.esc_url(get_permalink($relatedPost->ID)).'">'.get_the_title($relatedPost->ID).'</a></h5></header>
								</div>
							</article>
						</div>';
				echo $output;
			}
		}
		

		?>

	</div>
	<?php endif; ?>
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
	<?php endwhile;?>
</section>
<?php get_footer();
