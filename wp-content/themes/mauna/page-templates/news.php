<?php
/*
Template Name: Announcements
*/

get_header(); 
$redux = mauna_get_global_option_redux();
$categories = (isset($redux['mauna_promotion_categories']) && $redux['mauna_promotion_categories'] != '') ? $redux['mauna_promotion_categories'] : '';
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
$cssClass = '';
$maxPages = 1;
$postsPerPage = (isset($redux['mauna_promotion_posts_per_page']) && $redux['mauna_promotion_posts_per_page'] != '') ? $redux['mauna_promotion_posts_per_page'] : -1;
$style = '';
$nav = (isset($redux['mauna_promotion_navigation']) && $redux['mauna_promotion_navigation'] != '') ? $redux['mauna_promotion_navigation'] : 'small-light';
?>

<section class="promotion-news">
	<div class="promotion-news-overlay"></div>
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<?php  if ( have_posts() ) :
			while ( have_posts() ) :
				the_post(); ?>
		<?php if (has_post_thumbnail( $post->ID )) :
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'mauna-large' );

			$id = $post->ID;
			$cssClass = 'promotion_page_style_'.$id;

			$letterSpacing = $redux['mauna_promotion_title_letter_spacing'];
			if($letterSpacing !== '') {
				$letterSpacing = intval($letterSpacing)/2;
			} else {
				$letterSpacing == '';
			}

			if($letterSpacing !== '') {
				$style .= '<style scoped>
					.'.$cssClass.' header h3 span { padding: 0 '.$letterSpacing.'px; }
				</style>';
			   
			}    
			?>
				<div class="bg-img" style="background-image: url('<?php echo esc_url($image[0]); ?>');">
					<img class="hide" src="<?php echo esc_url($image[0]); ?>" />
				</div>
		<?php endif; ?>
	<div class="promotion-news-header default-header <?php echo esc_url($cssClass); ?>">
		<div class="header-wrapper">
			<div class="row">
				<div class="small-12 columns">
					<?php if($redux['mauna_promotion_title_enable'] == true) : ?>
						<header><h3 class="animate-header"><?php the_title(); ?></h3></header>
					<?php endif; ?>
					<?php if(isset($redux['mauna_promotion_nav_list']) && $redux['mauna_promotion_nav_list'] !== '') {
							mauna_default_menu_nav($redux['mauna_promotion_nav_list']);
						}; ?>
					<?php if($redux['mauna_promotion_circle_enable'] == true) : ?>
					<div class="layer" data-depth="0.50">

						<?php if($redux['mauna_promotion_type_decoration'] == 'circle') : ?>
						<div class="circle-decoration decoration <?php echo esc_attr($redux['mauna_promotion_circle_position']); ?>">
							<svg height="400" width="400">
							  <circle cx="200" cy="200" r="190" stroke-width="20" fill="none" />
							</svg>
						</div>
						<?php elseif($redux['mauna_promotion_type_decoration'] == 'triangle') : ?>
						<div class="triangle-decoration decoration <?php echo esc_attr($redux['mauna_promotion_circle_position']); ?>">
							<svg height="400" width="400">
								<polygon fill="none" points="20,300 380,380 300,20"/>
							</svg>
						</div>
						<?php elseif($redux['mauna_promotion_type_decoration'] == 'square') : ?>
						<div class="square-decoration decoration <?php echo esc_attr($redux['mauna_promotion_circle_position']); ?>">
							<svg height="400" width="400">
								<polygon fill="none" points="200,20 20,200 200,380 380,200"/>
							</svg>
						</div>
					<?php elseif($redux['mauna_promotion_type_decoration'] == 'custom') : ?>
						<div class="custom-decoration decoration <?php echo esc_attr($redux['mauna_promotion_circle_position']); ?>">
							<?php $svg = $redux['mauna_promotion_type_decoration_custom'];
								$svg = $svg['id'];
								$svg = get_attached_file($svg);
								echo file_get_contents($svg);
							?>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endwhile; ?>
<?php endif; ?>
	<div class="promotion-news-wrapper">
		<div class="promotion-news-carousel">
			<div class="swiper-wrapper promotion-new-row">
				<div class="swiper-slide" style="float: left; ">
					<div class="promotion-inner">
			<?php
				$query_params = array(
				'post_type'=>'mauna_promotion_item',
				'posts_per_page'=> $postsPerPage,
				'paged' => $paged,
			);

			if($categories != '') {
				$query_params['tax_query'] = array(array(
					'taxonomy'=>'mauna_promotion_categories',
					'terms'    => $categories,
					'operator' => 'IN',
				));
			}

			$query_images = new WP_Query( $query_params );
			$images = array();
			foreach ( $query_images->posts as $post ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mauna-medium');
				$title = get_post_meta($post->ID, 'mauna_promotion_item_title', true);
				$description = get_post_meta($post->ID, 'mauna_promotion_item_desc', true);
				$customLink = get_post_meta($post->ID, 'mauna_promotion_item_link_custom', true);
				$postLink = get_post_meta($post->ID, 'mauna_promotion_item_link', true);
				$linkClass = '';
				if($postLink == 'link_post' || $postLink == '') {
					$link = get_permalink();
				} elseif($postLink == 'custom_link') {
					$link = $customLink;
				} else {
					$link = '';
					$linkClass = 'no-link';
				}
				$maxPages = 1;
				?>
					<div class="promotion-item hover-basic">
						<a class="<?php echo esc_attr($linkClass); ?>" href="<?php echo esc_url($link); ?>" <?php if($linkClass == 'no-link') {echo 'data-djax-exclude="true"'; }?>>
							<img data-src="<?php echo esc_url($image[0]); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>"/>
							<?php if($title !== '' || $description !== '') : ?>
							<div class="promotion-news-content-wrapper">
								<div class="promotion-news-content">
									<div class="content">
										<?php echo apply_filters('the_content', $title); ?>
										<?php echo apply_filters('the_content', $description); ?>
									</div>
								</div>
							</div>
							<?php endif; ?>
						</a>
					</div>
				<?php
			} ?>
		</div>
			</div>
		</div>
			<?php if($redux['mauna_promotion_arrow'] == true) : ?>
			<div class="portfolio-slide-next portfolio-arrow">
				<div class="arrow-slide next-slide">
					<svg viewBox="0 0 25 50">
						<g fill="none" stroke="" stroke-width="3" preserveAspectRatio="xMidYMid slice" >
							<path class="lineAB" stroke-linecap="round" d="M4 4 l21 21"></path>
							<path class="lineBC" stroke-linecap="round" d="M25 25 l-21 23"></path>
						</g>
					</svg>
				</div>
			</div>
			<div class="portfolio-slide-prev portfolio-arrow">
				<div class="arrow-slide prev-slide">
					<svg viewBox="0 0 25 50">
						<g fill="none" stroke="" stroke-width="3" preserveAspectRatio="xMidYMid slice">
							<path class="lineAB" stroke-linecap="round" d="M23 4 l-21 21"></path>
							<path class="lineBC" stroke-linecap="round" d="M3 26 l21 21"></path>
						</g>
					</svg>
				</div>
			</div>  
			<?php endif; ?>        
		</div>
	</div>
</section>
<?php echo $style; ?>
<?php get_footer(); ?>
