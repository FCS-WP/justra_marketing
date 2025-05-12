<?php
/**
 * The template to display the socials in the footer
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.10
 */


// Socials
if ( the_pipes_is_on( the_pipes_get_theme_option( 'socials_in_footer' ) ) ) {
	$the_pipes_output = the_pipes_get_socials_links();
	if ( '' != $the_pipes_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php the_pipes_show_layout( $the_pipes_output ); ?>
			</div>
		</div>
		<?php
	}
}
