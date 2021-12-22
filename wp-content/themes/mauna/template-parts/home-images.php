<?php
global $redux;

$sliderOptions = '';
$parallaxDepth = '0';
$parallaxClass = '';
$sliderTransition = 'data-transition="'.esc_attr($redux['mauna_home_slides_transition']).'"';
$sliderDelay = 'data-delay="'.esc_attr($redux['mauna_home_slides_duration']).'"';
$sliderTransitionDuration = 'data-transition-duration="'.esc_attr($redux['mauna_home_slides_transition_duration']).'"';
if($redux['mauna_home_background_type'] == 'slider' && $redux['mauna_home_slides_animation'] == 'none') {

} elseif ($redux['mauna_home_background_type'] == 'slider' && $redux['mauna_home_slides_animation'] == 'parallax') {
	$parallaxDepth = '0.10';
	$parallaxClass = 'parallax-image';
} elseif ($redux['mauna_home_background_type'] == 'slider' && $redux['mauna_home_slides_animation'] == 'kenburn') {
	$sliderOptions = 'data-animation="random"';
} elseif ($redux['mauna_home_background_type'] == 'static') {
	$parallaxDepth = '0.10';
}
?>
	
<?php if($redux['mauna_home_background_type'] == 'static' || $redux['mauna_home_background_type'] == 'slider' || !isset($redux)) : ?>
<div class="layer <?php echo esc_attr($parallaxClass); ?>" data-depth="<?php echo esc_attr($parallaxDepth); ?>">
	<div class="parallax-slides <?php if($redux['mauna_home_background_type'] == 'slider') { echo 'slides-multiple'; } ?>" <?php echo $sliderOptions; ?> <?php echo $sliderTransition; ?> <?php echo $sliderDelay; ?> <?php echo $sliderTransitionDuration; ?> >
		<?php
		if($redux['mauna_home_background_type'] == 'static' || $redux['mauna_home_background_type'] == '') {
			$img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'mauna_home2');
			echo '<div class="home-slide" style="background-image: url('.esc_url($img[0]).');"></div>';
		} elseif($redux['mauna_home_background_type'] == 'slider') {
			$slides = $redux['mauna_home_background_images'];
			if($slides != false && $slides != '') {
				$slides = explode(',', $slides);
				foreach($slides as $s) {
					$img = wp_get_attachment_image_src( $s, 'mauna_home2');
					echo '<span class="single-slide" data-slide="'.esc_url($img[0]).'"></span>';
				}
			}
		} ?>

	</div>

	<div class="home-overlay" style="background-color: <?php echo esc_attr($redux['mauna_home_color_overlay']); ?>"></div>
</div>
<?php endif; ?>