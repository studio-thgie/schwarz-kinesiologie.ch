<?php

	function mauna_get_share_links($data = array()) {
	$redux = mauna_get_global_option_redux();
	if(isset($redux['mauna_social_share_services']) || !isset($redux)) {
		$s = $redux['mauna_social_share_services'];
		$title = $url = $description = $image = '';
		$title       = isset( $data['title'] ) ? $data['title'] : '';
		$url         = isset( $data['url'] ) ? $data['url'] : '';
		$description = isset( $data['description'] ) ? $data['description'] : '';
		$image       = isset( $data['image'] ) ? $data['image'] : '';
		if(is_array($image)) {
			if(isset($image[0])) {
				$image = $image[0];
			} else {
				$image = '';
			}
		}

		$facebookParams = array(
			'u' => $url,
		);

		$twitterParams = array(
			'text' => $title,
		);

		$googleParams = array(
			'url' => $url,
		);

		$tumblrParams = array(
			'url' => $url,
			'name' => $title,
			'description' => $description
		);

		$pinterestParams = array(
			'media' => $image,
			'url' => $url,
			'is_video' => '0',
			'description' => $description,
		);


		$facebookUrl = 'https://www.facebook.com/sharer/sharer.php?'.http_build_query($facebookParams);
		$twitterUrl = 'https://www.twitter.com/share?'.http_build_query($twitterParams);
		$googleUrl = 'https://plus.google.com/share?'.http_build_query($googleParams);
		$tumblrUrl = 'http://www.tumblr.com/share/link?'.http_build_query($tumblrParams);
		$pinterestUrl = 'https://pinterest.com/pin/create/bookmarklet/?'.http_build_query($pinterestParams);


		$output = '
		'.(((isset($s['facebook']) && $s['facebook'] == '1') || !isset($redux)) ? '<li><a href="'.esc_url($facebookUrl).'" class="no-rd social-share" data-djax-exclude="true">Facebook</a></li>' : '').'
		'.(((isset($s['twitter']) && $s['twitter'] == '1') || !isset($redux)) ? '<li><a href="'.esc_url($twitterUrl).'" class="no-rd social-share" data-djax-exclude="true">Twitter</a></li>' : '').'
		'.(((isset($s['google']) && $s['google'] == '1') || !isset($redux)) ? '<li><a href="'.esc_url($googleUrl).'" class="no-rd social-share" data-djax-exclude="true">Google+</a></li>' : '').'
		'.(((isset($s['tumblr']) && $s['tumblr'] == '1') || !isset($redux)) ? '<li><a href="'.esc_url($tumblrUrl).'" class="no-rd social-share" data-djax-exclude="true">Tumblr</a></li>' : '').'
		'.(((isset($s['pinterest']) && $s['pinterest'] == '1') || !isset($redux)) ? '<li><a href="'.esc_url($pinterestUrl).'" class="no-rd social-share" data-djax-exclude="true">Pinterest</a></li>' : '');
		return trim($output);
	}
}