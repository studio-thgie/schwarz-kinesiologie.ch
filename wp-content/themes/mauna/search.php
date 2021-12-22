<?php
/**
 * The template for displaying search results pages.
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

get_header(); 
$redux = mauna_get_global_option_redux();
$nav = (isset($redux['mauna_other_pages_navigation']) && $redux['mauna_other_pages_navigation'] != '') ? $redux['mauna_other_pages_navigation'] : 'small-dark';
?>

<?php mauna_get_page_navigation($nav); ?>
<?php get_template_part('template-parts/header-overlay'); ?>
<div class="row blog">
	<div class="small-12 large-8 columns small-centered " role="main">

		<?php do_action( 'mauna_before_content' ); ?>
		<div class="text-center margin-bottom-lg">	
		<h2><?php esc_html_e( 'Search Results for', 'mauna' ); ?> "<?php echo get_search_query(); ?>"</h2>
	</div>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
		<?php endwhile; ?>
		<?php else : ?>
			<div class="text-center">
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			</div>
	<?php endif;?>
	<?php do_action( 'mauna_before_pagination' ); ?>
	<?php if ( function_exists( 'mauna_pagination' ) ) { mauna_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( esc_html__( '&larr; Older posts', 'mauna' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( esc_html__( 'Newer posts &rarr;', 'mauna' ) ); ?></div>
		</nav>
	<?php } ?>
	<?php do_action( 'mauna_after_content' ); ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer();


