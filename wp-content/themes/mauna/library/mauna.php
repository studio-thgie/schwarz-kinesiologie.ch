<?php
/**
 * Mauna PHP template
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

// Pagination.
if ( ! function_exists( 'mauna_pagination' ) ) :
function mauna_pagination() {
	global $wp_query;

	$big = 999999999;
	$paginate_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5,
		'prev_next' => true,
		'prev_text' => esc_html__( '&laquo;', 'mauna' ),
		'next_text' => esc_html__( '&raquo;', 'mauna' ),
		'type' => 'list',
	) );

	$paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination'>", $paginate_links );
	$paginate_links = str_replace( '<li><span class="page-numbers dots">', "<li><a href='#'>", $paginate_links );
	$paginate_links = str_replace( "<li><span class='page-numbers current'>", "<li class='current'><a href='#'>", $paginate_links );
	$paginate_links = str_replace( '</span>', '</a>', $paginate_links );
	$paginate_links = str_replace( "<li><a href='#'>&hellip;</a></li>", "<li><span class='dots'>&hellip;</span></li>", $paginate_links );
	$paginate_links = preg_replace( '/\s*page-numbers/', '', $paginate_links );

	if ( $paginate_links ) {
		echo '<div class="pagination-centered">';
		echo $paginate_links;
		echo '</div><!--// end .pagination -->';
	}
}
endif;

/**
 * A fallback when no navigation is selected by default.
 */

if ( ! function_exists( 'mauna_menu_fallback' ) ) :
function mauna_menu_fallback() {
	echo '<div class="alert-box secondary">';
	// Translators 1: Link to Menus, 2: Link to Customize.
	printf( esc_html__( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', 'mauna' ),
		sprintf(  wp_kses(__( '<a href="%s">Menus</a>', 'mauna' ), array('a'=>array('href'=>array()))), get_admin_url( get_current_blog_id(), 'nav-menus.php' ) ),
		sprintf(  wp_kses(__( '<a href="%s">Customize</a>', 'mauna' ), array('a'=>array('href'=>array()))), get_admin_url( get_current_blog_id(), 'customize.php' ) )
	);
	echo '</div>';
}
endif;


if ( ! function_exists( 'mauna_active_nav_class' ) ) :
function mauna_active_nav_class( $classes, $item ) {
	if ( 1 == $item->current || true == $item->current_item_ancestor ) {
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'mauna_active_nav_class', 10, 2 );
endif;


if ( ! function_exists( 'mauna_active_list_pages_class' ) ) :
function mauna_active_list_pages_class( $input ) {

	$pattern = '/current_page_item/';
	$replace = 'current_page_item active';

	$output = preg_replace( $pattern, $replace, $input );

	return $output;
}
add_filter( 'wp_list_pages', 'mauna_active_list_pages_class', 10, 2 );
endif;

if ( ! class_exists( 'Mauna_Comments' ) ) :
class Mauna_Comments extends Walker_Comment{

	// Init classwide variables.
	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	/** CONSTRUCTOR
	 * You'll have to use this if you plan to get to the top of the comments list, as
	 * start_lvl() only goes as high as 1 deep nested comments */
	function __construct() { ?>

		<ul id="recentcomments" class="comment-list margin-bottom-lg">

	<?php }

	/** START_LVL
	 * Starts the list before the CHILD elements are added. */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; ?>

				<ul class="children">
	<?php }

	/** END_LVL
	 * Ends the children list of after the elements are added. */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1; ?>

		</ul><!-- /.children -->

	<?php }

	/** START_EL */
	function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;
		$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); 
		$parent_class .= 'recentcomments margin-bottom-sm';
		?>

	   <li <?php comment_class( $parent_class ); ?> id="comment-<?php comment_ID() ?>">
			<div class="comment-header">
				<div class="comment-author-avatar"><?php echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
				<div class="comment-date"><?php comment_date(); ?> <?php esc_html_e('at','mauna'); ?> <?php comment_time(); ?></div>
				<div class="comment-author-link"><?php echo get_comment_author_link(); ?> </div>

				<span class="reply">
					<?php $reply_args = array(
						'depth' => $depth,
						'max_depth' => $args['max_depth'],
						'before' => '&mdash; ',
						);

					comment_reply_link( array_merge( $args, $reply_args ) );  ?> <?php edit_comment_link( esc_html__('(Edit)', 'mauna') ); ?>
				</span><!-- /.reply -->
			</div>
			<article id="comment-body-<?php comment_ID() ?>" class="comment-body">
				<section id="comment-content-<?php comment_ID(); ?>" class="comment">
					<?php if ( ! $comment->comment_approved ) : ?>
							<div class="notice">
					<p class="bottom"><?php esc_html_e( 'Your comment is awaiting moderation.', 'mauna'); ?></p>
				</div>
					<?php else : comment_text(); ?>
					<?php endif; ?>
				</section><!-- /.comment-content -->
			</article><!-- /.comment-body -->

	<?php }

	function end_el(& $output, $comment, $depth = 0, $args = array() ) { ?>

		</li><!-- /#comment-' . get_comment_ID() . ' -->

	<?php }

	/** DESTRUCTOR */
	function __destruct() { ?>

	</ul><!-- /#comment-list -->

	<?php }
}
endif;


add_filter('comment_reply_link', 'mauna_replace_reply_link_class');
add_filter('cancel_comment_reply_link', 'mauna_replace_cancel_reply_link_class');

function mauna_replace_reply_link_class($class){
	$class = str_replace("class='comment-reply-link", "data-djax-exclude='true' class='comment-reply-link no-rd", $class);
	return $class;
}

function mauna_replace_cancel_reply_link_class($class){
	$class = str_replace("href", "data-djax-exclude='true' href'", $class);
	return $class;
}
