<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$the_pipes_copyright_scheme = the_pipes_get_theme_option( 'copyright_scheme' );
if ( ! empty( $the_pipes_copyright_scheme ) && ! the_pipes_is_inherit( $the_pipes_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $the_pipes_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$the_pipes_copyright = the_pipes_get_theme_option( 'copyright' );
			if ( ! empty( $the_pipes_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$the_pipes_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $the_pipes_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$the_pipes_copyright = the_pipes_prepare_macros( $the_pipes_copyright );
				// Display copyright
				echo wp_kses( nl2br( $the_pipes_copyright ), 'the_pipes_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
