<?php
/**
 * Entry meta information for posts
 *
 * @package Mauna
 * @since Mauna 1.0.0
 */

if ( ! function_exists( 'mauna_entry_meta' ) ) :
	function mauna_entry_meta() {
		echo '<time class="updated" datetime="' . get_the_time( 'c' ) . '">' . sprintf( esc_html__( 'Posted on %s at %s.', 'mauna' ), get_the_date(), get_the_time() ) . '</time>';
		echo '<p class="byline author">' . esc_html__( 'Written by', 'mauna' ) . ' <a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author" class="fn">' . get_the_author() . '</a></p>';
	}
endif;
