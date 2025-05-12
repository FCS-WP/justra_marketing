<?php
/**
 * The template to display default site footer
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.10
 */

$the_pipes_footer_id = the_pipes_get_custom_footer_id();
$the_pipes_footer_meta = get_post_meta( $the_pipes_footer_id, 'trx_addons_options', true );
if ( ! empty( $the_pipes_footer_meta['margin'] ) ) {
	the_pipes_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( the_pipes_prepare_css_value( $the_pipes_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $the_pipes_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $the_pipes_footer_id ) ) ); ?>
						<?php
						$the_pipes_footer_scheme = the_pipes_get_theme_option( 'footer_scheme' );
						if ( ! empty( $the_pipes_footer_scheme ) && ! the_pipes_is_inherit( $the_pipes_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $the_pipes_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'the_pipes_action_show_layout', $the_pipes_footer_id );
	?>
</footer><!-- /.footer_wrap -->
