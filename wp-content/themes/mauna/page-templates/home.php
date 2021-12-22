<?php
/*
Template Name: Home
*/

get_header();

$redux = mauna_get_global_option_redux();
$offCanvasContent = $redux['mauna_off_canvas_text'];
$footerContent = $redux['mauna_footer_text'];
$logoOffCanvas = isset($redux['mauna_off_canvas_logo']) ? $redux['mauna_off_canvas_logo'] : '';
$videoAutoPlay = $redux['mauna_home_video_auto_play'];
$videoUrl = $redux['mauna_home_video'];

if($redux['mauna_home_background_type'] == 'video' && $videoAutoPlay == '0') {
	$showTitle = false;
} else {
	$showTitle = true; 
}
$showControls = $redux['mauna_home_video_controls'];
$style = '';

$showBurger = $redux['mauna_home_show_burger'];
if($showBurger == 1) {
	$burger = 'show-burger';
} else {
	$burger = 'hide-burger';
}

$nav = (isset($redux['mauna_home_navigation']) && $redux['mauna_home_navigation'] != '') ? $redux['mauna_home_navigation'] : 'large-light';

?>

<section class="homepage <?php echo esc_attr($burger); ?>">
	<div class="home-overlay" style="background-color: <?php echo esc_attr($redux['mauna_home_color_overlay']); ?>"></div>
	<?php if(isset($redux['mauna_off_canvas_enable']) && $redux['mauna_off_canvas_enable'] == '1') : ?>
	<div class="open-off-canvas"><a href="#" class="link-hover" data-djax-exclude="true"><?php echo esc_html($redux['mauna_off_canvas_open']); ?></a></div>
	<div class="off-canvas-wrapper">
		<div class="off-canvas-overlay"></div>
		<div class="close-off-canvas"><a href="#" class="link-hover" data-djax-exclude="true"><?php echo esc_html($redux['mauna_off_canvas_close']); ?></a></div>
		<div class="row">
			<div class="off-canvas-content small-12 large-6 columns">
				<?php if(isset($logoOffCanvas['url']) && $logoOffCanvas['url'] != '') : ?>
				<figure class="logo-lg">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($logoOffCanvas['url']); ?>" alt=""/></a>
				</figure>
				<?php endif; ?>
				<?php if(isset($offCanvasContent) && $offCanvasContent != '') : ?>
				<div class="content">
					<?php echo apply_filters('the_content', $offCanvasContent); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>

		<?php 
		if($redux['mauna_home_background_type'] == 'revslider') {
			if(function_exists('putRevSlider')) { 
				$revslider = $redux['mauna_home_background_revslider'];
				putRevSlider($revslider);
			}
		}

		?>

	<?php if($redux['mauna_home_background_type'] != 'revslider'): ?>
	<div class="scene">
		<?php get_template_part('template-parts/home-images'); ?>
		<?php get_template_part('template-parts/home-video'); ?>
		<div class="video-mask" style="background-image: url('<?php echo esc_attr($redux['mauna_home_mask']);?>')"></div>
		<?php if($redux['mauna_home_circle_enable'] == true) : ?>
		<div class="layer" data-depth="0.50">

			<?php if($redux['mauna_home_type_decoration'] == 'circle') : ?>
			<div class="circle-decoration decoration <?php echo esc_attr($redux['mauna_home_circle_position']); ?>">
				<svg height="400" width="400">
				  <circle cx="200" cy="200" r="190" stroke-width="20" fill="none" />
				</svg>
			</div>
			<?php elseif($redux['mauna_home_type_decoration'] == 'triangle') : ?>
			<div class="triangle-decoration decoration <?php echo esc_attr($redux['mauna_home_circle_position']); ?>">
				<svg height="400" width="400">
					<polygon fill="none" points="20,300 380,380 300,20"/>
				</svg>
			</div>
			<?php elseif($redux['mauna_home_type_decoration'] == 'square') : ?>
			<div class="square-decoration decoration <?php echo esc_attr($redux['mauna_home_circle_position']); ?>">
				<svg height="400" width="400">
					<polygon fill="none" points="200,20 20,200 200,380 380,200"/>
				</svg>
			</div>
			<?php elseif($redux['mauna_home_type_decoration'] == 'custom') : ?>
			<div class="custom-decoration decoration <?php echo esc_attr($redux['mauna_home_circle_position']); ?>">
				<?php $svg = $redux['mauna_home_type_decoration_custom'];
					$svg = $svg['id'];
					$svg = get_attached_file($svg);
					echo file_get_contents($svg);
				; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php if(($redux['mauna_home_show_title'] == '1' && $showTitle == true) || !isset($redux) ) : ?>
		<?php 
			$cssClass = 'home_page_style_'.$id;

			$letterSpacing = $redux['mauna_home_title_letter_spacing'];
			if($letterSpacing !== '' && isset($redux)) {
				$letterSpacing = intval($letterSpacing)/2;
			} else {
				$letterSpacing == '20';
			}
			if($letterSpacing !== '') {
				$style .= '<style scoped>
					.'.$cssClass.' header h1 span { padding: 0 '.$letterSpacing.'px; }
				</style>';
			}    
		; ?>
		<div class="layer" data-depth="0.30">
			<div class="home-header <?php echo esc_attr($cssClass); ?>">
				<div class="header-wrapper">
					<div class="row">
						<div class="small-12 columns">
							<header><h1 class="animate-header"><?php the_title(); ?></h1></header>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if( $redux['mauna_home_background_type'] == 'video' && ($videoAutoPlay == '0' || ($videoAutoPlay == '1' && $showControls == '1'))) : ?>
		<?php 
		$controlClass = '';
		if($videoAutoPlay == '1' && $showControls == '1') {
			$controlClass = 'home-video-control-down';
		}; ?>
	<div class="home-video-controls <?php echo esc_attr($controlClass); ?>">
		<div class="play video-control show-for-large">
			<svg height="180" width="180" viewbox="0 0 200 200">
				<circle class="circle-light" cx="100" cy="100" r="80" stroke-width="28" fill="none" />
				<circle class="circle-dark" cx="100" cy="100" r="66"></circle>
				<polygon points="85,75 85,125 125,100"/>
			</svg>
		</div>
		<div class="pause hide-control video-control show-for-large">
			<svg height="100" width="100" viewbox="0 0 200 200">
				<circle class="circle-light" cx="100" cy="100" r="80" stroke-width="28" fill="none" />
				<circle class="circle-dark" cx="100" cy="100" r="66" />
				<polygon points="75,75 75,125 95,125 95,75"/>
				<polygon points="105,75 105,125 125,125 125,75"/>
			</svg>
		</div>
	</div>
	<?php endif; ?>
	<?php if($redux['mauna_home_background_type'] == 'video') : ?>
		<?php 
		$controlClass = '';
		if($videoAutoPlay == '1' && ($redux['mauna_home_show_title'] == '1' || $redux['mauna_home_circle_enable'] == true)) {
			$controlClass = 'home-mobile-control-down';
		}; ?>
	<div class="home-mobile-video-control hide-for-large <?php echo esc_attr($controlClass); ?>">
		<a class="swipebox-video" rel="video" href="<?php echo esc_url($videoUrl); ?>">
		<svg height="100" width="100" viewbox="0 0 200 200">
			<circle class="circle-light" cx="100" cy="100" r="80" stroke-width="28" fill="none" />
			<circle class="circle-dark" cx="100" cy="100" r="66"/>
			<polygon points="85,75 85,125 125,100"/>
		</svg>
		</a>
	</div>
	<?php endif; ?>
	<nav class="home-nav show-for-large">
		<div class="row">
			<div class="small-12">
				<?php mauna_top_bar_r() ;?>
			</div>
		</div>  
	</nav>
	<footer class="home-footer">
		<div class="row">
			<div class="small-12 columns">
				<?php if(isset($footerContent) && $footerContent != '') : ?>
				<div class="footer-content">
					<div class="footer-inner"><?php echo apply_filters('the_content', $footerContent); ?></div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</footer>
</section>
<?php echo $style; ?>
<?php get_footer(); ?>