<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

$the_pipes_template_args = get_query_var( 'the_pipes_template_args' );
$the_pipes_columns = 1;
if ( is_array( $the_pipes_template_args ) ) {
	$the_pipes_columns    = empty( $the_pipes_template_args['columns'] ) ? 1 : max( 1, $the_pipes_template_args['columns'] );
	$the_pipes_blog_style = array( $the_pipes_template_args['type'], $the_pipes_columns );
	if ( ! empty( $the_pipes_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $the_pipes_columns > 1 ) {
	    $the_pipes_columns_class = the_pipes_get_column_class( 1, $the_pipes_columns, ! empty( $the_pipes_template_args['columns_tablet']) ? $the_pipes_template_args['columns_tablet'] : '', ! empty($the_pipes_template_args['columns_mobile']) ? $the_pipes_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $the_pipes_columns_class ); ?>">
		<?php
	}
} else {
	$the_pipes_template_args = array();
}
$the_pipes_expanded    = ! the_pipes_sidebar_present() && the_pipes_get_theme_option( 'expand_content' ) == 'expand';
$the_pipes_post_format = get_post_format();
$the_pipes_post_format = empty( $the_pipes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $the_pipes_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $the_pipes_post_format ) );
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
			'thumb_size' => ! empty( $the_pipes_template_args['thumb_size'] )
							? $the_pipes_template_args['thumb_size']
							: the_pipes_get_thumb_size( strpos( the_pipes_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $the_pipes_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$the_pipes_template_args
	) );

	// Title and post meta
	$the_pipes_show_title = get_the_title() != '';
	$the_pipes_show_meta  = count( $the_pipes_components ) > 0 && ! in_array( $the_pipes_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $the_pipes_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'the_pipes_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'the_pipes_action_before_post_title' );
				if ( empty( $the_pipes_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'the_pipes_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'the_pipes_filter_show_blog_excerpt', empty( $the_pipes_template_args['hide_excerpt'] ) && the_pipes_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'the_pipes_filter_show_blog_meta', $the_pipes_show_meta, $the_pipes_components, 'excerpt' ) ) {
				if ( count( $the_pipes_components ) > 0 ) {
					do_action( 'the_pipes_action_before_post_meta' );
					the_pipes_show_post_meta(
						apply_filters(
							'the_pipes_filter_post_meta_args', array(
								'components' => join( ',', $the_pipes_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'the_pipes_action_after_post_meta' );
				}
			}

			if ( the_pipes_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'the_pipes_action_before_full_post_content' );
					the_content( '' );
					do_action( 'the_pipes_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'the-pipes' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'the-pipes' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				the_pipes_show_post_content( $the_pipes_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'the_pipes_filter_show_blog_readmore',  ! isset( $the_pipes_template_args['more_button'] ) || ! empty( $the_pipes_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $the_pipes_template_args['no_links'] ) ) {
					do_action( 'the_pipes_action_before_post_readmore' );
					if ( the_pipes_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						the_pipes_show_post_more_link( $the_pipes_template_args, '<p>', '</p>' );
					} else {
						the_pipes_show_post_comments_link( $the_pipes_template_args, '<p>', '</p>' );
					}
					do_action( 'the_pipes_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $the_pipes_template_args ) ) {
	if ( ! empty( $the_pipes_template_args['slider'] ) || $the_pipes_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
