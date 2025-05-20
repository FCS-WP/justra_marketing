<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.50
 */

$the_pipes_template_args = get_query_var( 'the_pipes_template_args' );
if ( is_array( $the_pipes_template_args ) ) {
	$the_pipes_columns    = empty( $the_pipes_template_args['columns'] ) ? 2 : max( 1, $the_pipes_template_args['columns'] );
	$the_pipes_blog_style = array( $the_pipes_template_args['type'], $the_pipes_columns );
} else {
	$the_pipes_template_args = array();
	$the_pipes_blog_style = explode( '_', the_pipes_get_theme_option( 'blog_style' ) );
	$the_pipes_columns    = empty( $the_pipes_blog_style[1] ) ? 2 : max( 1, $the_pipes_blog_style[1] );
}
$the_pipes_blog_id       = the_pipes_get_custom_blog_id( join( '_', $the_pipes_blog_style ) );
$the_pipes_blog_style[0] = str_replace( 'blog-custom-', '', $the_pipes_blog_style[0] );
$the_pipes_expanded      = ! the_pipes_sidebar_present() && the_pipes_get_theme_option( 'expand_content' ) == 'expand';
$the_pipes_components    = ! empty( $the_pipes_template_args['meta_parts'] )
							? ( is_array( $the_pipes_template_args['meta_parts'] )
								? join( ',', $the_pipes_template_args['meta_parts'] )
								: $the_pipes_template_args['meta_parts']
								)
							: the_pipes_array_get_keys_by_value( the_pipes_get_theme_option( 'meta_parts' ) );
$the_pipes_post_format   = get_post_format();
$the_pipes_post_format   = empty( $the_pipes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $the_pipes_post_format );

$the_pipes_blog_meta     = the_pipes_get_custom_layout_meta( $the_pipes_blog_id );
$the_pipes_custom_style  = ! empty( $the_pipes_blog_meta['scripts_required'] ) ? $the_pipes_blog_meta['scripts_required'] : 'none';

if ( ! empty( $the_pipes_template_args['slider'] ) || $the_pipes_columns > 1 || ! the_pipes_is_off( $the_pipes_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $the_pipes_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( the_pipes_is_off( $the_pipes_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $the_pipes_custom_style ) ) . "-1_{$the_pipes_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $the_pipes_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $the_pipes_columns )
					. ' post_layout_' . esc_attr( $the_pipes_blog_style[0] )
					. ' post_layout_' . esc_attr( $the_pipes_blog_style[0] ) . '_' . esc_attr( $the_pipes_columns )
					. ( ! the_pipes_is_off( $the_pipes_custom_style )
						? ' post_layout_' . esc_attr( $the_pipes_custom_style )
							. ' post_layout_' . esc_attr( $the_pipes_custom_style ) . '_' . esc_attr( $the_pipes_columns )
						: ''
						)
		);
	the_pipes_add_blog_animation( $the_pipes_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'the_pipes_action_show_layout', $the_pipes_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $the_pipes_template_args['slider'] ) || $the_pipes_columns > 1 || ! the_pipes_is_off( $the_pipes_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
