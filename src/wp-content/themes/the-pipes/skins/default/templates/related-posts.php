<?php
/**
 * The default template to displaying related posts
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.54
 */

$the_pipes_link        = get_permalink();
$the_pipes_post_format = get_post_format();
$the_pipes_post_format = empty( $the_pipes_post_format ) ? 'standard' : str_replace( 'post-format-', '', $the_pipes_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $the_pipes_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	the_pipes_show_post_featured(
		array(
			'thumb_size' => apply_filters( 'the_pipes_filter_related_thumb_size', the_pipes_get_thumb_size( (int) the_pipes_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
		)
	);
	?>
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $the_pipes_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'the-pipes' );
			} else {
				the_title();
			}
		?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<span class="post_date"><a href="<?php echo esc_url( $the_pipes_link ); ?>"><?php echo wp_kses_data( the_pipes_get_date() ); ?></a></span>
			<?php
		}
		?>
	</div>
</div>
