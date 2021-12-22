<?php 
$redux = mauna_get_global_option_redux();
if(class_exists('WooCommerce')) {
	global $woocommerce;
	$count = $woocommerce->cart->cart_contents_count;
}
?>

<div class="large-6 columns ">
	<div class="lang-social-menu">
		<?php if(class_exists('WooCommerce')) : ?>
		<div class="cart-icon">
			<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" xml:space="preserve">
			<path d="M43,17v-6c0-6.065-4.935-11-11-11S21,4.935,21,11v6H9v47h46V17H43z M23,11c0-4.962,4.038-9,9-9s9,4.038,9,9v6H23V11z M53,62 H11V19h10v5h2v-5h18v5h2v-5h10V62z"/>
			</svg>
			<span class="cart-icon-count"><?php echo $count; ?></span>
		</div>
		<?php endif; ?>
		<?php if($redux['mauna_nav_show_languages'] == true) : ?>
		<div class="languages show-for-large">
			<?php mauna_language_nav(); ?>
		</div>
		<?php mauna_additional_nav('show-for-large'); ?>
		<?php endif; ?>
	</div>

</div>