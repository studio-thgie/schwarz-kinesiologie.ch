<?php
/**
 * The template for displaying search form
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

do_action( 'mauna_before_searchform' ); ?>
<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url( '/' )); ?>">
	<?php do_action( 'mauna_searchform_top' ); ?>
	<div class="input-group">
		<input type="text" class="input-group-field" value="" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'mauna' ); ?>">
		<?php do_action( 'mauna_searchform_before_search_button' ); ?>
		<div class="input-group-button">
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'mauna' ); ?>" class="button secondary hollow">
		</div>
	</div>
	<?php do_action( 'mauna_searchform_after_search_button' ); ?>
</form>
<?php do_action( 'mauna_after_searchform' );
