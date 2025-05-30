<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

$the_pipes_link        = get_permalink();
$the_pipes_post_format = get_post_format();
$the_pipes_post_format = empty( $the_pipes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $the_pipes_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $the_pipes_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	the_pipes_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'the_pipes_filter_related_thumb_size', the_pipes_get_thumb_size( (int) the_pipes_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses( the_pipes_get_post_categories( '' ), 'the_pipes_kses_content' ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $the_pipes_link ) . '">'
										. wp_kses_data( '' == get_the_title() ? esc_html__( '- No title -', 'the-pipes' ) : get_the_title() )
									. '</a></h6>'
									. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
											? '<div class="post_meta"><a href="' . esc_url( $the_pipes_link ) . '" class="post_meta_item post_date">' . wp_kses_data( the_pipes_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
		)
	);
	?>
</div>
