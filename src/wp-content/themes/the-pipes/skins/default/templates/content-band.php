<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package THE PIPES
 * @since THE PIPES 1.71.0
 */

$the_pipes_template_args = get_query_var( 'the_pipes_template_args' );
if ( ! is_array( $the_pipes_template_args ) ) {
	$the_pipes_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$the_pipes_columns       = 1;

$the_pipes_expanded      = ! the_pipes_sidebar_present() && the_pipes_get_theme_option( 'expand_content' ) == 'expand';

$the_pipes_post_format   = get_post_format();
$the_pipes_post_format   = empty( $the_pipes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $the_pipes_post_format );

if ( is_array( $the_pipes_template_args ) ) {
	$the_pipes_columns    = empty( $the_pipes_template_args['columns'] ) ? 1 : max( 1, $the_pipes_template_args['columns'] );
	$the_pipes_blog_style = array( $the_pipes_template_args['type'], $the_pipes_columns );
	if ( ! empty( $the_pipes_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $the_pipes_columns > 1 ) {
	    $the_pipes_columns_class = the_pipes_get_column_class( 1, $the_pipes_columns, ! empty( $the_pipes_template_args['columns_tablet']) ? $the_pipes_template_args['columns_tablet'] : '', ! empty($the_pipes_template_args['columns_mobile']) ? $the_pipes_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $the_pipes_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $the_pipes_post_format ) );
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
								: array_map( 'trim', explode( ',', $the_pipes_template_args['meta_parts'] ) )
								)
							: the_pipes_array_get_keys_by_value( the_pipes_get_theme_option( 'meta_parts' ) );
	the_pipes_show_post_featured( apply_filters( 'the_pipes_filter_args_featured',
		array(
			'no_links'   => ! empty( $the_pipes_template_args['no_links'] ),
			'hover'      => $the_pipes_hover,
			'meta_parts' => $the_pipes_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $the_pipes_template_args['thumb_size'] )
								? $the_pipes_template_args['thumb_size']
								: the_pipes_get_thumb_size( 
								in_array( $the_pipes_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( the_pipes_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $the_pipes_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$the_pipes_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$the_pipes_show_title = get_the_title() != '';
		$the_pipes_show_meta  = count( $the_pipes_components ) > 0 && ! in_array( $the_pipes_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $the_pipes_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'the_pipes_filter_show_blog_categories', $the_pipes_show_meta && in_array( 'categories', $the_pipes_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'the_pipes_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						the_pipes_show_post_meta( apply_filters(
															'the_pipes_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $the_pipes_hover, 1
															)
											);
						?>
					</div>
					<?php
					$the_pipes_components = the_pipes_array_delete_by_value( $the_pipes_components, 'categories' );
					do_action( 'the_pipes_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'the_pipes_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'the_pipes_action_before_post_title' );
					if ( empty( $the_pipes_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'the_pipes_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $the_pipes_template_args['excerpt_length'] ) && ! in_array( $the_pipes_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$the_pipes_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'the_pipes_filter_show_blog_excerpt', empty( $the_pipes_template_args['hide_excerpt'] ) && the_pipes_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				the_pipes_show_post_content( $the_pipes_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'the_pipes_filter_show_blog_meta', $the_pipes_show_meta, $the_pipes_components, 'band' ) ) {
			if ( count( $the_pipes_components ) > 0 ) {
				do_action( 'the_pipes_action_before_post_meta' );
				the_pipes_show_post_meta(
					apply_filters(
						'the_pipes_filter_post_meta_args', array(
							'components' => join( ',', $the_pipes_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'the_pipes_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'the_pipes_filter_show_blog_readmore', ! $the_pipes_show_title || ! empty( $the_pipes_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $the_pipes_template_args['no_links'] ) ) {
				do_action( 'the_pipes_action_before_post_readmore' );
				the_pipes_show_post_more_link( $the_pipes_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'the_pipes_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $the_pipes_template_args ) ) {
	if ( ! empty( $the_pipes_template_args['slider'] ) || $the_pipes_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
