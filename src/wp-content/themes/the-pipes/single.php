<?php
/**
 * The template to display single post
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

// Full post loading
$full_post_loading          = the_pipes_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = the_pipes_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = the_pipes_get_theme_option( 'posts_navigation_scroll_which_block', 'article' );

// Position of the related posts
$the_pipes_related_position   = the_pipes_get_theme_option( 'related_position', 'below_content' );

// Type of the prev/next post navigation
$the_pipes_posts_navigation   = the_pipes_get_theme_option( 'posts_navigation' );
$the_pipes_prev_post          = false;
$the_pipes_prev_post_same_cat = (int)the_pipes_get_theme_option( 'posts_navigation_scroll_same_cat', 1 );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( the_pipes_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	the_pipes_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'the_pipes_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $the_pipes_posts_navigation ) {
		$the_pipes_prev_post = get_previous_post( $the_pipes_prev_post_same_cat );  // Get post from same category
		if ( ! $the_pipes_prev_post && $the_pipes_prev_post_same_cat ) {
			$the_pipes_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $the_pipes_prev_post ) {
			$the_pipes_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $the_pipes_prev_post ) ) {
		the_pipes_sc_layouts_showed( 'featured', false );
		the_pipes_sc_layouts_showed( 'title', false );
		the_pipes_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $the_pipes_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/content', 'single-' . the_pipes_get_theme_option( 'single_style' ) ), 'single-' . the_pipes_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $the_pipes_related_position, 'inside' ) === 0 ) {
		$the_pipes_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'the_pipes_action_related_posts' );
		$the_pipes_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $the_pipes_related_content ) ) {
			$the_pipes_related_position_inside = max( 0, min( 9, the_pipes_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $the_pipes_related_position_inside ) {
				$the_pipes_related_position_inside = mt_rand( 1, 9 );
			}

			$the_pipes_p_number         = 0;
			$the_pipes_related_inserted = false;
			$the_pipes_in_block         = false;
			$the_pipes_content_start    = strpos( $the_pipes_content, '<div class="post_content' );
			$the_pipes_content_end      = strrpos( $the_pipes_content, '</div>' );

			for ( $i = max( 0, $the_pipes_content_start ); $i < min( strlen( $the_pipes_content ) - 3, $the_pipes_content_end ); $i++ ) {
				if ( $the_pipes_content[ $i ] != '<' ) {
					continue;
				}
				if ( $the_pipes_in_block ) {
					if ( strtolower( substr( $the_pipes_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$the_pipes_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $the_pipes_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $the_pipes_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$the_pipes_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $the_pipes_content[ $i + 1 ] && in_array( $the_pipes_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$the_pipes_p_number++;
					if ( $the_pipes_related_position_inside == $the_pipes_p_number ) {
						$the_pipes_related_inserted = true;
						$the_pipes_content = ( $i > 0 ? substr( $the_pipes_content, 0, $i ) : '' )
											. $the_pipes_related_content
											. substr( $the_pipes_content, $i );
					}
				}
			}
			if ( ! $the_pipes_related_inserted ) {
				if ( $the_pipes_content_end > 0 ) {
					$the_pipes_content = substr( $the_pipes_content, 0, $the_pipes_content_end ) . $the_pipes_related_content . substr( $the_pipes_content, $the_pipes_content_end );
				} else {
					$the_pipes_content .= $the_pipes_related_content;
				}
			}
		}

		the_pipes_show_layout( $the_pipes_content );
	}

	// Comments
	do_action( 'the_pipes_action_before_comments' );
	comments_template();
	do_action( 'the_pipes_action_after_comments' );

	// Related posts
	if ( 'below_content' == $the_pipes_related_position
		&& ( 'scroll' != $the_pipes_posts_navigation || (int)the_pipes_get_theme_option( 'posts_navigation_scroll_hide_related', 0 ) == 0 )
		&& ( ! $full_post_loading || (int)the_pipes_get_theme_option( 'open_full_post_hide_related', 1 ) == 0 )
	) {
		do_action( 'the_pipes_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $the_pipes_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $the_pipes_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $the_pipes_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $the_pipes_prev_post ) ); ?>"
			data-cur-post-link="<?php echo esc_attr( get_permalink() ); ?>"
			data-cur-post-title="<?php the_title_attribute(); ?>"
			<?php do_action( 'the_pipes_action_nav_links_single_scroll_data', $the_pipes_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
