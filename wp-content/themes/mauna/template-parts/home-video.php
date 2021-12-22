<?php
global $redux;
if($redux['mauna_home_background_type'] == 'video'): 
?>
<div class="layer" data-depth="0">
	<?php
		$videoUrl = $redux['mauna_home_video'];
		$videoMute = $redux['mauna_home_video_mute'];
		if($videoMute == '1') {
			$videoMute = 'true';
		} else {
			$videoMute = 'false';
		}
		$videoLoop = $redux['mauna_home_video_loop'];
		if($videoLoop == '1') {
			$videoLoop = 'true';
		} else {
			$videoLoop = 'false';
		}
		$videoAutoPlay = $redux['mauna_home_video_auto_play'];
		if($videoAutoPlay == '1') {
			$videoAutoPlay = 'true';
		} else {
			$videoAutoPlay = 'false';
		}
		$videoStartAt = ($redux['mauna_home_video_start'] == '' ) ? 0 : $redux['mauna_home_video_start'];

	?>
	<?php
		$img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fp-large');
		echo '<div class="bg-img" style="background-image: url('.esc_url($img[0]).');"><img class="hide" src="'.esc_url($img[0]).'" /></div>';
	?>
	<div class="video-home-wrapper" style="position: fixed; left: 0; right: 0; top: 0; bottom: 0;">
		<div class="video-wrapper" style="position:absolute; left: 0; top: 0; right: 0; bottom: 0; "></div>
		<div id="P1" class="player" style="display:block; margin: auto; background: rgba(0,0,0,0.5);" data-property="{videoURL:'<?php echo esc_url($videoUrl); ?>',containment:'.video-wrapper',startAt:<?php echo esc_attr($videoStartAt); ?>,mute:<?php echo esc_attr($videoMute); ?>,autoPlay:<?php echo esc_attr($videoAutoPlay); ?>,loop:<?php echo esc_attr($videoLoop); ?>,opacity:1,showControls:false}"></div>
		<div class="home-overlay"></div>
	</div>
	<div class="home-overlay" style="background-color: <?php echo esc_attr($redux['mauna_home_color_overlay']); ?>"></div>
</div>

<?php endif; ?>