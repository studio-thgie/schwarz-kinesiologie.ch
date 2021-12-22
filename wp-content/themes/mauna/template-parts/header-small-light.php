<?php
	$redux = mauna_get_global_option_redux();
	$showLogo = get_post_meta(get_the_ID(), 'mauna_home_show_logo', true );
	if($showLogo == '') {
		$showLogo = '1';
	}
	$logo = isset($redux['mauna_header_light_logo_small']) ? $redux['mauna_header_light_logo_small'] : '';
	if(isset($logo['url'])) {
		$logo = $logo['url'];
	}
?>

<div class="navbar-top navbar-top-light navbar-large navbar-large-light nav-small-light">
	<div class="row">
		<div class="small-12 large-6 columns">
			<div class="main-navigation">
				<?php if(has_nav_menu('burger-nav') || has_nav_menu('burger-nav-second')) :?>
				<div class="burger-nav">
					<svg viewBox="0 0 34 24">
						<g fill="none" stroke="" stroke-width="2">
							<path class="pathA" stroke-linecap="round" d="M2 2 l32 0" />
							<path class="pathB" stroke-linecap="round" d="M2 12 l32 0" />
							<path class="pathC" stroke-linecap="round" d="M2 22 l32 0" />
						</g>
					</svg>
				</div>
				<?php else : ?>
				<div class="burger-nav invisible"></div>
				<?php endif;?>
				<?php if($showLogo == '1' && $logo != '') : ?>
				<figure class="logo-sm">
					<div class="logo-lg-wrapper">
						<?php
						if(!isset($redux)) :
							echo '<h1><a href="'.esc_url(home_url( '/' )).'" class="site-name">'.esc_attr(get_bloginfo('name')).'</a></h1>';
						else : ?>
							<a href="<?php echo esc_url(home_url( '/' )); ?>"><img src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr(get_bloginfo('name'));?>"/></a>
						<?php endif; ?>
					</div>
				</figure>
				<?php endif; ?>
			</div>
		</div>
		<?php get_template_part('template-parts/lang-social-nav'); ?>
	</div>
</div>