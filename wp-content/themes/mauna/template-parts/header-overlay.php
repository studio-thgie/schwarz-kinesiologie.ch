<?php
	$redux = mauna_get_global_option_redux();
	$logo = isset($redux['mauna_header_overlay_logo']) ? $redux['mauna_header_overlay_logo'] : '';
	if(isset($logo['url'])) {
		$logo = $logo['url'];
	}
?>
<div class="nav-overlay"></div>
<div class="navigation-overlay">
	<div class="navbar-top navbar-top-light navbar-large navbar-fixed">
		<div class="row">
			<div class="small-12 large-6 columns">
				<div class="main-navigation">
					<div class="burger-nav">
						<svg style="position: absolute; height: 100%; width: 100%; left: 0; top:0;" viewBox="0 0 34 24">
							<g fill="none" stroke="" stroke-width="2">
								<path class="pathA" stroke-linecap="round" d="M2 2 l32 0" />
								<path class="pathB" stroke-linecap="round" d="M2 12 l32 0" />
								<path class="pathC" stroke-linecap="round" d="M2 22 l32 0" />
							</g>
						</svg>
					</div>

					<figure class="logo-sm">
						<div class="logo-lg-wrapper">
							<?php if($logo == '') :
								echo '<h1><a href="'.esc_url(home_url( '/' )).'" class="site-name">'.esc_attr(get_bloginfo('name')).'</a></h1>';
							else : ?>
								<a href="<?php echo esc_url(home_url( '/' )); ?>"><img src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr(get_bloginfo('name'));?>"/></a>
							<?php endif; ?>
						</div>
					</figure>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="small-12 columns">
			<div class="navigation-content">
				<?php mauna_overlay_nav() ;?>
				<?php mauna_overlay_additional_nav('margin-bottom-standard'); ?>
			</div>
		</div>
	</div>
</div>