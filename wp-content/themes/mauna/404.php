<?php
get_header(); 
$redux = mauna_get_global_option_redux();
$nav = (isset($redux['mauna_other_pages_navigation']) && $redux['mauna_other_pages_navigation'] != '') ? $redux['mauna_other_pages_navigation'] : 'small-dark';
$style = '';
?>

<section class="default-template">
	<?php mauna_get_page_navigation($nav); ?>
    <?php get_template_part('template-parts/header-overlay'); ?>
<div class="row">
	<div class="small-12 large-8 columns small-centered text-center" role="main">

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h3><?php esc_html_e( 'File Not Found', 'mauna' ); ?></h3>
			</header>
			<div class="entry-content">
				<div class="error">
					<p class="bottom"><?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'mauna' ); ?></p>
				</div>
				<p><?php esc_html_e( 'Please try the following:', 'mauna' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'Check your spelling', 'mauna' ); ?></li>
					<li><?php echo sprintf( wp_kses( __( 'Return to the <a href="%s">home page</a>', 'mauna' ), array('a'=>array('href'=>array()))), esc_url(home_url('/')) ); ?></li>
					<li><?php esc_html_e( 'Click the button', 'mauna' ); ?> <a href="javascript:history.back()"><?php esc_html_e('Back', 'mauna');?></a> <?php esc_html_e('button', 'mauna'); ?> </li>
				</ul>
			</div>
		</article>

	</div>
	<?php get_sidebar(); ?>
</div>
</section>

<?php get_footer();
