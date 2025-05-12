<?php
/**
 * The Portfolio template to display the content
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

$the_pipes_post_format = get_post_format();
$the_pipes_post_format = empty( $the_pipes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $the_pipes_post_format );

?><div class="
<?php
if ( ! empty( $the_pipes_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( the_pipes_is_blog_style_use_masonry( $the_pipes_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $the_pipes_columns ) : esc_attr( $the_pipes_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $the_pipes_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $the_pipes_columns )
		. ( 'portfolio' != $the_pipes_blog_style[0] ? ' ' . esc_attr( $the_pipes_blog_style[0] )  . '_' . esc_attr( $the_pipes_columns ) : '' )
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

	$the_pipes_hover   = ! empty( $the_pipes_template_args['hover'] ) && ! the_pipes_is_inherit( $the_pipes_template_args['hover'] )
								? $the_pipes_template_args['hover']
								: the_pipes_get_theme_option( 'image_hover' );

	if ( 'dots' == $the_pipes_hover ) {
		$the_pipes_post_link = empty( $the_pipes_template_args['no_links'] )
								? ( ! empty( $the_pipes_template_args['link'] )
									? $the_pipes_template_args['link']
									: get_permalink()
									)
								: '';
		$the_pipes_target    = ! empty( $the_pipes_post_link ) && the_pipes_is_external_url( $the_pipes_post_link )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$the_pipes_components = ! empty( $the_pipes_template_args['meta_parts'] )
							? ( is_array( $the_pipes_template_args['meta_parts'] )
								? $the_pipes_template_args['meta_parts']
								: explode( ',', $the_pipes_template_args['meta_parts'] )
								)
							: the_pipes_array_get_keys_by_value( the_pipes_get_theme_option( 'meta_parts' ) );

	// Featured image
	the_pipes_show_post_featured( apply_filters( 'the_pipes_filter_args_featured',
        array(
			'hover'         => $the_pipes_hover,
			'no_links'      => ! empty( $the_pipes_template_args['no_links'] ),
			'thumb_size'    => ! empty( $the_pipes_template_args['thumb_size'] )
								? $the_pipes_template_args['thumb_size']
								: the_pipes_get_thumb_size(
									the_pipes_is_blog_style_use_masonry( $the_pipes_blog_style[0] )
										? (	strpos( the_pipes_get_theme_option( 'body_style' ), 'full' ) !== false || $the_pipes_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( the_pipes_get_theme_option( 'body_style' ), 'full' ) !== false || $the_pipes_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => the_pipes_is_blog_style_use_masonry( $the_pipes_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $the_pipes_components,
			'class'         => 'dots' == $the_pipes_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $the_pipes_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $the_pipes_post_link )
												? '<a href="' . esc_url( $the_pipes_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $the_pipes_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $the_pipes_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $the_pipes_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!