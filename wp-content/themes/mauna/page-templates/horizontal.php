<?php
/*
Template Name: Horizontal split layout
*/

get_header(); 
$redux = mauna_get_global_option_redux();
$style = $cssClass = '';

$nav = (isset($redux['mauna_default_navigation']) && $redux['mauna_default_navigation'] != '') ? $redux['mauna_default_navigation'] : 'small-light';
?>

<section class="default-template">
	<div class="section-overlay fixed-overlay"></div>
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<?php  if ( have_posts() ) :
			while ( have_posts() ) :
				the_post(); ?>
		<?php if (has_post_thumbnail( $post->ID )) :
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'mauna-large' );
			$id = $post->ID;
			$cssClass = 'default_page_style_'.$id;

			$letterSpacing = $redux['mauna_default_title_letter_spacing'];
			if($letterSpacing !== '' && isset($redux)) {
				$letterSpacing = intval($letterSpacing)/2;
			} else {
				$letterSpacing == '20';
			}

			if($letterSpacing !== '') {
				$style .= '<style scoped>
					.'.$cssClass.' header h3 span { padding: 0 '.$letterSpacing.'px; }
				</style>';
			}
			?>
				<div class="bg-img" style="background-image: url('<?php echo esc_url($image[0]); ?>');">
					<img class="hide" src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"/>
				</div>
		<?php endif; ?>
		<div class="default-header show-for-large <?php echo esc_attr($cssClass); ?>">
			<div class="header-wrapper">
				<div class="row">
					<div class="small-12 columns">
						<?php if($redux['mauna_default_title_enable'] == true || !isset($redux)) : ?>
							<header><h3 class="animate-header"><?php the_title(); ?></h3></header>
						<?php endif; ?>
						<?php if(isset($redux['mauna_default_nav_list']) && $redux['mauna_default_nav_list'] !== '') {
							mauna_default_menu_nav($redux['mauna_default_nav_list']);
						}; ?>
						<?php if($redux['mauna_default_circle_enable'] == true) : ?>
							<?php if($redux['mauna_default_type_decoration'] == 'circle') : ?>
							<div class="circle-decoration decoration <?php echo esc_attr($redux['mauna_default_circle_position']); ?>">
								<svg height="400" width="400">
								  <circle cx="200" cy="200" r="190" stroke-width="20" fill="none" />
								</svg>
							</div>
							<?php elseif($redux['mauna_default_type_decoration'] == 'triangle') : ?>
							<div class="triangle-decoration decoration <?php echo esc_attr($redux['mauna_default_circle_position']); ?>">
								<svg height="400" width="400">
									<polygon fill="none" points="20,300 380,380 300,20"/>
								</svg>
							</div>
							<?php elseif($redux['mauna_default_type_decoration'] == 'square') : ?>
							<div class="square-decoration decoration <?php echo esc_attr($redux['mauna_default_circle_position']); ?>">
								<svg height="400" width="400">
									<polygon fill="none" points="200,20 20,200 200,380 380,200"/>
								</svg>
							</div>
							<?php elseif($redux['mauna_default_type_decoration'] == 'custom') : ?>
							<div class="custom-decoration decoration <?php echo esc_attr($redux['mauna_default_circle_position']); ?>">
								<?php $svg = $redux['mauna_default_type_decoration_custom'];
									$svg = $svg['id'];
									$svg = get_attached_file($svg);
									echo file_get_contents($svg);
								; ?>
							</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="default-content-wrapper <?php echo esc_attr($cssClass); ?>">
			<div class="default-content">
				<div class="row">
					<div class="small-12 columns hide-for-large default-header">        
						<header><h3><?php the_title(); ?></h3></header>
					</div>
				</div>
				<div class="row">
					<div class="small-12 medium-10 large-8 columns small-centered content">
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
		<?php
	endwhile;
endif;
?>
</section>
<?php echo $style; 
get_footer();