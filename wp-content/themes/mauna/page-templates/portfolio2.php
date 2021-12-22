<?php
/*
Template Name: Portfolio full slider
*/

get_header();
$redux = mauna_get_global_option_redux();
$categories = (isset($redux['mauna_portfolio2_categories']) && $redux['mauna_portfolio2_categories'] != '') ? $redux['mauna_portfolio2_categories'] : '';
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

$carouselClass = '';
if((isset($redux['mauna_portfolio2_nav_list']) && $redux['mauna_portfolio2_nav_list'] !== '') || (isset($redux['mauna_portfolio2_caption']) && $redux['mauna_portfolio2_caption'] == true)) {
	$carouselClass = 'carousel-bottom-margin';
}
$pageTitle = get_the_title();
$nav = (isset($redux['mauna_portfolio2_navigation']) && $redux['mauna_portfolio2_navigation'] != '') ? $redux['mauna_portfolio2_navigation'] : 'small-light';

$portfolioClass = $portfolioUrl = $portfolioRel = $galleryClass = $galleryUrl = '';
?>

<section class="portfolio2">
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<div class="portfolio-carousel2 swiper-container <?php echo esc_attr($carouselClass); ?>">
		<div class="swiper-wrapper">

		<?php
		if($redux['mauna_portfolio2_type'] == 'posts_gallery') {
			$query_params = array(
				'post_type'=>'mauna_portfolio_item',
				'posts_per_page'=> -1,
				'paged' => $paged,
			);
			if($categories != '') {
				$query_params['tax_query'] = array(array(
					'taxonomy'=>'mauna_portfolio_categories',
					'terms'    => $categories,
					'operator' => 'IN',
				));
			}

			$query_images = new WP_Query( $query_params );

			$images = array();
			foreach ( $query_images->posts as $post ) {

				$hoverImage = $gallery_output = $video_output = '';
				$hoverImage = get_post_meta( $post->ID, 'mauna_portfolio_item_hover-image_thumbnail_id', true );
				$showFirst = get_post_meta( $post->ID, 'mauna_portfolio_single_show_first', true);
				if($hoverImage != false && $hoverImage !== '') {
					$hoverImage = wp_get_attachment_image_src( $hoverImage, 'mauna-large');
				}
				$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mauna-large');
				$portfolio_posts = get_post_meta($post->ID, 'mauna_portfolio_item_gallery', true);
				
				$image_lightbox = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mauna-large');
				$image_lightbox = $image_lightbox[0];
				$attachments = array_filter( explode( ',', $portfolio_posts ) );
				$maxPages = 1;

				$hoverImageStyle = '';
				$class = 'class="portfolio-item2 hover-basic"';
				if($hoverImage !== false && $hoverImage !== '') {
					$class = 'class="portfolio-item2"';
					$hoverImageStyle = 'style="background-image: url('.esc_url($hoverImage[0]).')"';
				}

				if($redux['mauna_portfolio2_caption'] == true ) {
					$attachment_caption = 'title="'.$post->post_title.'"';
				} else {
					$attachment_caption = '';
				}

				$videoLinks = get_post_meta($post->ID ,'mauna_portfolio_video', true); 

				$videoIcon = '';
				if(isset($videoLinks) && $videoLinks !== '' && !empty($videoLinks)) {
					if(isset($videoLinks[0]) && !empty($videoLinks[0])) {
						$videoIcon = '<div class="play portfolio-video-control">
							<svg height="80" width="80" viewbox="0 0 200 200">
						 		<circle class="circle-light" cx="100" cy="100" r="80" stroke-width="28" fill="none" />
						 		<circle class="circle-dark" cx="100" cy="100" r="66"></circle>
						 		<polygon points="85,75 85,125 125,100"/>
						 	</svg>
						 </div>';
					}
				}
				
				?>
					<div <?php echo $class; ?>>
						<?php
						if($redux['mauna_portfolio2_single_open'] == 'lightbox') {
							if(!empty($attachments)) {
								foreach ($attachments as $gallery_lightbox) {
									if($gallery_lightbox != '') {
										$attachment_meta = wp_prepare_attachment_for_js($gallery_lightbox);
										if($redux['mauna_portfolio2_caption'] == true) {
											$gallery_attachment_caption = $attachment_meta['caption'];
											$gallery_attachment_caption = 'title="'.esc_attr($gallery_attachment_caption).'"';
										} else {
											$gallery_attachment_caption = '';
										}
										$gallery_lightbox = wp_get_attachment_image_src( $gallery_lightbox, 'mauna-large');
										$gallery_lightbox = $gallery_lightbox[0];
										$gallery_output .= '<a href="'.esc_url($gallery_lightbox).'" class="swipebox2" data-rel="portfolio_group'.esc_attr($post->ID).'" '.$gallery_attachment_caption.'></a>';
									}
								}
							}
							if(isset($videoLinks) && $videoLinks !== '') {
								foreach ($videoLinks as $video_lightbox) { 
									if($video_lightbox != '') {
										$video_output .= '<a href="'.esc_url($video_lightbox).'" class="swipebox2" data-rel="portfolio_group'.esc_attr($post->ID).'"></a>';
									}
								}
							}	
							


							
							if (!empty($attachments) || !empty($videoLinks)) {
								$portfolioUrl = $image_lightbox;
								$portfolioClass = 'single-portfolio-item swipebox2';
							} else {
								$portfolioUrl = '#';
								$portfolioClass = 'single-portfolio-item';
							}
							$portfolioRel = 'data-rel="portfolio_group'.esc_attr($post->ID).'" '.$attachment_caption.'';
						} else {
							$portfolioClass = 'single-portfolio-item';
							$portfolioUrl = get_permalink();
						}
						
						if($portfolioUrl == '') {
							$portfolioUrl = '#';
						}
						?>
						<a class="<?php echo esc_attr($portfolioClass); ?>" href="<?php echo esc_url($portfolioUrl); ?>" <?php echo $portfolioRel; ?>>
							<img src="<?php echo esc_url($image[0]); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" alt="<?php echo esc_attr($pageTitle); ?>"/>
							<?php
							if($hoverImageStyle != '') {
								echo '<span class="img-bg-2" '.$hoverImageStyle.'></span>';
							}
							echo $videoIcon;
							?>
						</a>
						<?php
							if(isset($showFirst) && $showFirst == 'video') {
								echo $video_output;
								echo $gallery_output; 
							} else {
								echo $gallery_output; 
								echo $video_output;
							}
						 ?>
					</div>
				<?php
			}
		} else {
			$portfolio_images = $redux['mauna_portfolio2_custom'];
			if(isset($portfolio_images)) {
				$attachments = array_filter( explode( ',', $portfolio_images ) );
				foreach ( $attachments as $attachment_id ) {
					$image = wp_get_attachment_image_src( $attachment_id, 'mauna-medium');
					$attachment_meta = wp_prepare_attachment_for_js($attachment_id);
					if($redux['mauna_portfolio2_caption'] == true && $attachment_meta['caption'] != '') {
						$attachment_caption = $attachment_meta['caption'];
						$attachment_caption = 'title="'.esc_attr($attachment_caption).'"';
					} else {
						$attachment_caption = '';
					}
					$image_lightbox = wp_get_attachment_image_src($attachment_id, 'mauna-medium');
					$image_lightbox = $image_lightbox[0];
					$galleryClass = 'swipebox';
					$galleryUrl = esc_url($image[0]);
					?>
						<div class="portfolio-item2 hover-basic">
							<a href="<?php echo $galleryUrl; ?>" class="<?php echo esc_attr($galleryClass); ?>" <?php echo $attachment_caption; ?> >
								<img src="<?php echo esc_url($image[0]); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" alt="<?php echo esc_attr($pageTitle); ?>"/>
							</a>

						</div>
					<?php
				}
			}
		}
		?>
		</div>
		<?php if((isset($redux['mauna_portfolio2_nav_list']) && $redux['mauna_portfolio2_nav_list'] !== '') || (isset($redux['mauna_portfolio2_caption']) && $redux['mauna_portfolio2_caption'] == true)) {
			echo '<div class="portfolio2-filters"><div class="menu-wrapper">';
			if(isset($redux['mauna_portfolio2_nav_list']) && $redux['mauna_portfolio2_nav_list'] !== '') {
        		mauna_default_menu_nav($redux['mauna_portfolio2_nav_list']);
			}
        	echo '</div></div>';
        }; ?>
		<div class="swiper-pagination"></div>
		<?php if($redux['mauna_portfolio2_arrow'] == true) : ?>
		<div class="portfolio-slide-next portfolio-arrow show-for-large">
			<div class="arrow-slide next-slide">
				<svg viewBox="0 0 25 50">
					<g fill="none" stroke="" stroke-width="3">
						<path class="lineAB" stroke-linecap="round" d="M4 4 l21 21"></path>
						<path class="lineBC" stroke-linecap="round" d="M25 25 l-21 23"></path>
					</g>
				</svg>
			</div>
		</div>
		<div class="portfolio-slide-prev portfolio-arrow show-for-large">
			<div class="arrow-slide prev-slide">
				<svg viewBox="0 0 25 50">
					<g fill="none" stroke="" stroke-width="3">
						<path class="lineAB" stroke-linecap="round" d="M23 4 l-21 21"></path>
						<path class="lineBC" stroke-linecap="round" d="M3 26 l21 21"></path>
					</g>
				</svg>
			</div>
		</div>
		<?php endif; ?>
	</div>
	
</section>

<?php get_footer(); ?>