<?php
/*
Template Name: Home 2
*/

get_header(); 
$redux = mauna_get_global_option_redux();

$themeLocations = get_nav_menu_locations();
if(isset($themeLocations['home-nav2'])) {
	$menuObj = get_term( $themeLocations['home-nav2'], 'nav_menu' );
	if(isset($menuObj->name)) {

	$menuName = $menuObj->name;

	$homeNav = $menuName;
	$homeNav = wp_get_nav_menu_items($homeNav);
	}
} else {
	$homeNav = array();
}

$footerContent = $redux['mauna_footer2_text'];

$style = $bgNoImage = '';
if (!has_post_thumbnail( $post->ID )) {
	$bgNoImage = 'bg-no-img';
}
$noNav = '';
if($redux['mauna_home2_navigation'] == 'none') {
	$noNav = 'no-nav';
} 


$nav = (isset($redux['mauna_home2_navigation']) && $redux['mauna_home2_navigation'] != '') ? $redux['mauna_home2_navigation'] : 'large-light';

$meta = get_post_meta(get_the_ID(), 'mauna_home2_navigation', true);;
?>

<section class="homepage2">
	<div class="home-overlay" style="background-color: <?php echo esc_attr($redux['mauna_home2_color_overlay']); ?>"></div>
	<?php if (has_post_thumbnail( $post->ID )) :
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'mauna_home2' );

        $id = $post->ID;
        $cssClass = 'home2_page_style_'.$id;

    ?>
    <div class="bg-img" style="background-image: url('<?php echo esc_url($image[0]); ?>');">
        <img class="hide" src="<?php echo esc_url($image[0]); ?>" alt="" />
    </div>
  
    <?php endif; ?>
    <div class="home-nav-items <?php echo esc_attr($bgNoImage); ?> <?php echo esc_attr($noNav); ?>">
    <?php
    	$i = 0;
    	if(isset($homeNav) && is_array($homeNav)) {

			foreach ( $homeNav as $image ) {
				
				$imgID = $image->thumbnail_id;
				$img = wp_get_attachment_image_src($imgID, 'mauna_home2');
				$navUrl = $image->url;
				if(isset($image->attr_title) && $image->attr_title !== '') {
					$title = $image->attr_title;
				} else {
					$title = $image->title;
				}

				$i++;
				?>
				<div class="home-nav-item">
					<div class="bg-img-hover" data-bg="<?php echo esc_url($img[0]); ?>" style="background-image: url('<?php echo esc_url($img[0]); ?>');"></div>
					<a href="<?php echo esc_url($navUrl); ?>"><div class="item-wrapper"><span><?php echo esc_html($title) ; ?></span></div></a>
				</div>
	<?php }
		}
	?>

	</div>
	<?php mauna_get_page_navigation($nav); ?>
	<?php get_template_part('template-parts/header-overlay'); ?>
	<?php if(isset($footerContent) && $footerContent !== '') : ?>
	<footer class="home2-footer">
		<?php if(isset($footerContent) && $footerContent != '') : ?>
		<div class="footer-content">
			<?php echo apply_filters('the_content', $footerContent); ?>
		</div>
		<?php endif; ?>
	</footer>
	<?php endif; ?>
</section>

<?php get_footer(); ?>