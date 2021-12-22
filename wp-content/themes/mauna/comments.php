<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Mauna
 * @since Mauna_Comments 1.0.0
 */
	/*
	Do not delete these lines.
	Prevent access to this file directly
	*/

	defined( 'ABSPATH' ) or die( esc_html__( 'Please do not load this page directly. Thanks!', 'mauna' ) );

	if ( post_password_required() ) { ?>
	<section id="comments">
		<div class="notice">
			<p class="bottom"><?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'mauna' ); ?></p>
		</div>
	</section>
	<?php
		return;
	}
?>

<?php
if ( comments_open() ) :
	if ( (is_page() || is_single()) && ( ! is_home() && ! is_front_page()) ) :
?>
<section>
	<h6 class="margin-bottom-lg"><?php comment_form_title( esc_html__( 'Add your thoughts', 'mauna' ) ); ?></h6>

	<?php
		if ( have_comments() ) :
			if ( (is_page() || is_single()) && ( ! is_home() && ! is_front_page()) ) :
		?>
	
		<?php
			wp_list_comments(array(
					'walker'            => new Mauna_Comments(),
					'max_depth'         => '3',
					'style'             => 'ul',
					'callback'          => null,
					'end-callback'      => null,
					'type'              => 'all',
					'page'              => '',
					'format'            => 'html5',
					'short_ping'        => true,
					'avatar_size'       => '20',
					'moderation' 	    => esc_html__( 'Your comment is awaiting moderation.', 'mauna' ),
				)
			);
			echo '<div class="paginate-comments numeric-pagination">';
			$prev = '<svg xmlns="http://www.w3.org/2000/svg" class="second-border" xmlns:xlink="http://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 100 50" preserveAspectRatio="xMidYMid meet" zoomAndPan="disable"><polygon points="30,25 60,10 60,40" style="stroke-width: 2px; vector-effect: non-scaling-stroke; fill: #171717;"></polygon></svg>';
			$next = '<svg xmlns="http://www.w3.org/2000/svg" class="second-border" xmlns:xlink="http://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 100 50" preserveAspectRatio="xMidYMid meet" zoomAndPan="disable"><polygon points="70,25 40,10 40,40" style="stroke-width: 2px; vector-effect: non-scaling-stroke; fill: #171717;"></polygon></svg>';
			paginate_comments_links(array('prev_text' => $prev, 'next_text' => $next));
			echo '</div>';

			?>
		<?php endif; ?>
	<?php else: ?>
		<p class="no-comments"><?php echo esc_html__('There are no comments, add yours', 'mauna'); ?></p>
	<?php endif; ?>

	<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
	<p><?php printf( wp_kses(__( 'You must be <a href="%s">logged in</a> to post a comment.', 'mauna' ), array('a'=>array('href'=>array()))), wp_login_url( get_permalink() ) ); ?></p>
	<?php else : ?>
	<?php
	$required_text ='';
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' =>

		'<div class="input-wrapper comment-name comment-column">
			<input value="' . esc_attr( $commenter['comment_author'] ) .'" class="comment-form-input form-name-error" type="text" placeholder="'. esc_attr__( 'name', 'mauna' ).' '.($req ? '*' : '').'" name="author" id="author" '.$aria_req.'>
		</div>',

		'email' =>'<div class="input-wrapper comment-mail comment-column">
			<input value="' . esc_attr(  $commenter['comment_author_email'] ) .
		'" class="comment-form-input form-email-error" type="text" placeholder="'.__( 'e-mail', 'mauna' ).' '.($req ? '*' : '').' " name="email" id="email" '.$aria_req.' >
		</div>',

		'url' => '<div class="input-wrapper comment-mail comment-column"><input id="url" class="comment-form-input" name="url" type="text" placeholder="'.__('website', 'mauna').'" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'" /></div>',
	);
	$args = array(
		'id_form'           => 'commentform',
		'class_form'      => 'comment-form',
		'id_submit'         => 'submit',
		'class_submit'      => 'btn form-submit',
		'name_submit'       => 'submit',
		'submit_button'     => '<span class="comment-submit"><span class="link-hover link-hover-color"><input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" /></span></span>',
		'title_reply'       => '',
		'title_reply_to'    => '',
		'cancel_reply_link' => '',
		'label_submit'      => esc_html__( 'Submit', 'mauna' ),
		'format'            => 'xhtml',

		'comment_field' =>  '<textarea id="comment" name="comment" rows="4" class="comment-form-input form-message-error" placeholder="'.esc_attr__('comment', 'mauna').'" aria-required="true"></textarea>',
		'must_log_in' => '',
		'logged_in_as' => '',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	);

	comment_form($args);
	?>
	<?php endif; // If registration required and not logged in. ?>


</section>
<?php
	endif; // If you delete this the sky will fall on your head.
	endif; // If you delete this the sky will fall on your head.


