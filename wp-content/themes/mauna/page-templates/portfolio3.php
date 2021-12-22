<?php
/*
Template Name: Portfolio masonry
*/

get_header();
$redux = mauna_get_global_option_redux();
$categories = (isset($redux['mauna_portfolio3_categories']) && $redux['mauna_portfolio3_categories'] != '') ? $redux['mauna_portfolio3_categories'] : '';
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

$maxPages = 1;
$postsPerPage = (isset($redux['mauna_portfolio3_posts_per_page']) && $redux['mauna_portfolio3_posts_per_page'] != '') ? $redux['mauna_portfolio3_posts_per_page'] : -1;

$gridSizer = (isset($redux['mauna_portfolio3_columns_count']) && $redux['mauna_portfolio3_columns_count'] != '') ? $redux['mauna_portfolio3_columns_count'] : 4;
$pageTitle = get_the_title();

$gutter = $redux['mauna_portfolio3_item_gutter'];
$gutter = intval($gutter) / 2;
$nav = (isset($redux['mauna_portfolio3_navigation']) && $redux['mauna_portfolio3_navigation'] != '') ? $redux['mauna_portfolio3_navigation'] : 'small-light';

$overlayHover = '';
if($redux['mauna_portfolio3_title_hover'] == true) {
	$overlayHover = 'overlay-hover-title';
}

$portfolioClass = $portfolioUrl = $portfolioRel = $galleryClass = $galleryUrl = '';
?>

<section class="portfolio3" style="padding: <?php echo esc_attr($gutter); ?>px">
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<div class="page-bg"></div>
	<div class="portfolio3-masonry <?php echo 'grid-size-'.esc_attr($gridSizer); ?>">
		<div class="portfolio-grid-sizer"></div>
		<?php
		if($redux['mauna_portfolio3_type'] == 'posts_gallery') {

			$query_params = array(
				'post_type'=>'mauna_portfolio_item',
				'posts_per_page'=> $postsPerPage,
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
			$maxPages = $query_images->max_num_pages;
			foreach ( $query_images->posts as $post ) {
				$hoverImage = $gallery_output = $video_output = '';
				$hoverImage = get_post_meta( $post->ID, 'mauna_portfolio_item_hover-image_thumbnail_id', true );
				$showFirst = get_post_meta( $post->ID, 'mauna_portfolio_single_show_first', true);
				if($hoverImage != false && $hoverImage !== '') {
					$hoverImage = wp_get_attachment_image_src( $hoverImage, 'mauna-medium');
				}
				$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mauna-medium');
				$portfolio_posts = get_post_meta($post->ID, 'mauna_portfolio_item_gallery', true);
				$image_lightbox = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mauna-large');
				$image_lightbox = esc_url($image_lightbox[0]);
				$attachments = array_filter( explode( ',', $portfolio_posts ) );
				$hoverImageStyle = '';
				$class = 'class="portfolio-item3 hover-basic"';
				if($hoverImage !== false && $hoverImage !== '') {
					$class = 'class="portfolio-item3"';
					$hoverImageStyle = 'style="background-image: url('.esc_url($hoverImage[0]).')"';
				}

				$attachment_meta = wp_prepare_attachment_for_js(get_post_thumbnail_id($post->ID));
				if($redux['mauna_portfolio3_caption'] == true && $attachment_meta['caption'] != '') {
					$attachment_caption = $attachment_meta['caption'];
					$attachment_caption = 'title="'.esc_attr($attachment_caption).'"';
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
					<div <?php echo $class; ?> style="padding: <?php echo esc_attr($gutter); ?>px">
						<?php
							if($redux['mauna_portfolio3_single_open'] == 'lightbox') {
								if(!empty($attachments)) {
									foreach ($attachments as $key => $gallery_lightbox) {
										if($gallery_lightbox != '') {
											$attachment_meta = wp_prepare_attachment_for_js($gallery_lightbox);
											if($redux['mauna_portfolio3_caption'] == true) {
												$gallery_attachment_caption = $attachment_meta['caption'];
												$gallery_attachment_caption = 'title="'.esc_attr($gallery_attachment_caption).'"';
											} else {
												$gallery_attachment_caption = '';
											}
											$gallery_lightbox = wp_get_attachment_image_src( $gallery_lightbox, 'mauna-large');
											$gallery_lightbox = $gallery_lightbox[0];

											if(($key != 0 && $showFirst != 'video') || $showFirst == 'video') {
												$gallery_output .= '<a href="'.esc_url($gallery_lightbox).'" class="swipebox" data-rel="portfolio_group'.esc_attr($post->ID).'" '.$gallery_attachment_caption.'></a>';
											}
											
										}
									}
								}
								if(isset($videoLinks) && $videoLinks !== '') {
									foreach ($videoLinks as $key => $video_lightbox) { 
										if($video_lightbox != '') {

											if((empty($attachments) && $key == 0) || $showFirst == 'video') {

											} else {
												$video_output .= '<a href="'.esc_url($video_lightbox).'" class="swipebox" data-rel="portfolio_group'.esc_attr($post->ID).'"></a>';
											}
										}
									}
								}	

								$portfolioClass = 'single-portfolio-item swipebox';
								$attachment = array('caption'=>'');	
								if (!empty($attachments) || !empty($videoLinks)) {
									if(($showFirst == 'video' || empty($attachments) ) && isset($videoLinks[0])) {
										$portfolioUrl = $videoLinks[0];
									} else {
										$portfolioUrl = wp_get_attachment_image_src( $attachments[0], 'mauna-large');
										$attachment = wp_prepare_attachment_for_js($attachments[0]);
										$portfolioUrl = $portfolioUrl[0];
									}
									if($redux['mauna_portfolio3_caption'] == true) {
										$attachment = $attachment['caption'];
										$attachment = 'title="'.esc_attr($attachment).'"';
									} else {
										$attachment = '';
									}

									$portfolioRel = 'data-rel="portfolio_group'.esc_attr($post->ID).'" '.$attachment.'';

								} else {
									$portfolioUrl = '#';
									$portfolioClass = 'single-portfolio-item';
								}
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
								echo '<span class="img-bg-2 '.$overlayHover.'" '.$hoverImageStyle.'></span>';
							}
							if($redux['mauna_portfolio3_title_hover'] == true) {
									echo '<span class="portfolio-hover-title">'.get_the_title($post->ID).'</span>';
							}
							echo $videoIcon;
							?>
						</a>
						<?php
							if($showFirst == 'video') {
								echo $video_output;
								echo $gallery_output; 
							} else {
								echo $gallery_output; 
								echo $video_output;
							}
						 ?>
						
					</div>	
			<?php }
		} else {
			$portfolio_images = $redux['mauna_portfolio3_custom'];

			if(isset($portfolio_images)) {
				$limit = $postsPerPage;

				$attachments = array_filter( explode( ',', $portfolio_images ) );
				$maxPages = 1;
				
				if(count($attachments) > $limit && $limit > 0) {
					$attachments = array_chunk($attachments, $limit);
					$maxPages = count($attachments);
					if(isset($attachments[$paged-1])) {
						$attachments = $attachments[$paged-1];
					} else {
						$attachments = $attachments[0];
					}
				}
	
				foreach ( $attachments as $attachment_id ) {
					$image = wp_get_attachment_image_src( $attachment_id, 'mauna-medium');
					$attachment_meta = wp_prepare_attachment_for_js($attachment_id);
					if($redux['mauna_portfolio3_caption'] == true && $attachment_meta['caption'] != '') {
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
						<div class="portfolio-item3 hover-basic" style="padding: <?php echo esc_attr($gutter); ?>px">
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
	<?php
		
		if($maxPages > $paged) {
			echo '<div class="portfolio-load-more-wrapper"><a class="portfolio-load-more link-hover" href="'.esc_url(next_posts($maxPages, false )).'" data-djax-exclude="true">'.esc_html__('Load more', 'mauna').'</a></div>';
		}
		
	?>
	<?php if(isset($redux['mauna_portfolio3_nav_list']) && $redux['mauna_portfolio3_nav_list'] !== '') {
		echo '<div class="portfolio3-filters"><div class="menu-wrapper">';
		if(isset($redux['mauna_portfolio3_nav_list']) && $redux['mauna_portfolio3_nav_list'] !== '') {
    		mauna_default_menu_nav($redux['mauna_portfolio3_nav_list']);
		}
    	echo '</div></div>';
    }; ?>
</section>

<?php get_footer(); ?>