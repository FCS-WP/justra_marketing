<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

$the_pipes_template_args = get_query_var( 'the_pipes_template_args' );

if ( is_array( $the_pipes_template_args ) ) {
	$the_pipes_columns    = empty( $the_pipes_template_args['columns'] ) ? 2 : max( 1, $the_pipes_template_args['columns'] );
	$the_pipes_blog_style = array( $the_pipes_template_args['type'], $the_pipes_columns );
    $the_pipes_columns_class = the_pipes_get_column_class( 1, $the_pipes_columns, ! empty( $the_pipes_template_args['columns_tablet']) ? $the_pipes_template_args['columns_tablet'] : '', ! empty($the_pipes_template_args['columns_mobile']) ? $the_pipes_template_args['columns_mobile'] : '' );
} else {
	$the_pipes_template_args = array();
	$the_pipes_blog_style = explode( '_', the_pipes_get_theme_option( 'blog_style' ) );
	$the_pipes_columns    = empty( $the_pipes_blog_style[1] ) ? 2 : max( 1, $the_pipes_blog_style[1] );
    $the_pipes_columns_class = the_pipes_get_column_class( 1, $the_pipes_columns );
}
$the_pipes_expanded   = ! the_pipes_sidebar_present() && the_pipes_get_theme_option( 'expand_content' ) == 'expand';

$the_pipes_post_format = get_post_format();
$the_pipes_post_format = empty( $the_pipes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $the_pipes_post_format );

?><div class="<?php
	if ( ! empty( $the_pipes_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( the_pipes_is_blog_style_use_masonry( $the_pipes_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $the_pipes_columns ) : esc_attr( $the_pipes_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $the_pipes_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $the_pipes_columns )
				. ' post_layout_' . esc_attr( $the_pipes_blog_style[0] )
				. ' post_layout_' . esc_attr( $the_pipes_blog_style[0] ) . '_' . esc_attr( $the_pipes_columns )
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

	// Featured image
	$the_pipes_hover      = ! empty( $the_pipes_template_args['hover'] ) && ! the_pipes_is_inherit( $the_pipes_template_args['hover'] )
							? $the_pipes_template_args['hover']
							: the_pipes_get_theme_option( 'image_hover' );

	$the_pipes_components = ! empty( $the_pipes_template_args['meta_parts'] )
							? ( is_array( $the_pipes_template_args['meta_parts'] )
								? $the_pipes_template_args['meta_parts']
								: explode( ',', $the_pipes_template_args['meta_parts'] )
								)
							: the_pipes_array_get_keys_by_value( the_pipes_get_theme_option( 'meta_parts' ) );

	the_pipes_show_post_featured( apply_filters( 'the_pipes_filter_args_featured',
		array(
			'thumb_size' => ! empty( $the_pipes_template_args['thumb_size'] )
				? $the_pipes_template_args['thumb_size']
				: the_pipes_get_thumb_size(
					'classic' == $the_pipes_blog_style[0]
						? ( strpos( the_pipes_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $the_pipes_columns > 2 ? 'big' : 'huge' )
								: ( $the_pipes_columns > 2
									? ( $the_pipes_expanded ? 'square' : 'square' )
									: ($the_pipes_columns > 1 ? 'square' : ( $the_pipes_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( the_pipes_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $the_pipes_columns > 2 ? 'masonry-big' : 'full' )
								: ($the_pipes_columns === 1 ? ( $the_pipes_expanded ? 'huge' : 'big' ) : ( $the_pipes_columns <= 2 && $the_pipes_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $the_pipes_hover,
			'meta_parts' => $the_pipes_components,
			'no_links'   => ! empty( $the_pipes_template_args['no_links'] ),
        ),
        'content-classic',
        $the_pipes_template_args
    ) );

	// Title and post meta
	$the_pipes_show_title = get_the_title() != '';
	$the_pipes_show_meta  = count( $the_pipes_components ) > 0 && ! in_array( $the_pipes_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $the_pipes_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'the_pipes_filter_show_blog_meta', $the_pipes_show_meta, $the_pipes_components, 'classic' ) ) {
				if ( count( $the_pipes_components ) > 0 ) {
					do_action( 'the_pipes_action_before_post_meta' );
					the_pipes_show_post_meta(
						apply_filters(
							'the_pipes_filter_post_meta_args', array(
							'components' => join( ',', $the_pipes_components ),
							'seo'        => false,
							'echo'       => true,
						), $the_pipes_blog_style[0], $the_pipes_columns
						)
					);
					do_action( 'the_pipes_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'the_pipes_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'the_pipes_action_before_post_title' );
				if ( empty( $the_pipes_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'the_pipes_action_after_post_title' );
			}

			if( !in_array( $the_pipes_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'the_pipes_filter_show_blog_readmore', ! $the_pipes_show_title || ! empty( $the_pipes_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $the_pipes_template_args['no_links'] ) ) {
						do_action( 'the_pipes_action_before_post_readmore' );
						the_pipes_show_post_more_link( $the_pipes_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'the_pipes_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $the_pipes_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('the_pipes_filter_show_blog_excerpt', empty($the_pipes_template_args['hide_excerpt']) && the_pipes_get_theme_option('excerpt_length') > 0, 'classic')) {
			the_pipes_show_post_content($the_pipes_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $the_pipes_template_args['more_button'] )) {
			if ( empty( $the_pipes_template_args['no_links'] ) ) {
				do_action( 'the_pipes_action_before_post_readmore' );
				the_pipes_show_post_more_link( $the_pipes_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'the_pipes_action_after_post_readmore' );
			}
		}
		$the_pipes_content = ob_get_contents();
		ob_end_clean();
		the_pipes_show_layout($the_pipes_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
