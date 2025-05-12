<?php
/**
 * The template to display default site footer
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$the_pipes_footer_scheme = the_pipes_get_theme_option( 'footer_scheme' );
if ( ! empty( $the_pipes_footer_scheme ) && ! the_pipes_is_inherit( $the_pipes_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $the_pipes_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
