<?php
/**
 * The template to display the site logo in the footer
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.10
 */

// Logo
if ( the_pipes_is_on( the_pipes_get_theme_option( 'logo_in_footer' ) ) ) {
	$the_pipes_logo_image = the_pipes_get_logo_image( 'footer' );
	$the_pipes_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $the_pipes_logo_image['logo'] ) || ! empty( $the_pipes_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $the_pipes_logo_image['logo'] ) ) {
					$the_pipes_attr = the_pipes_getimagesize( $the_pipes_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $the_pipes_logo_image['logo'] ) . '"'
								. ( ! empty( $the_pipes_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $the_pipes_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'the-pipes' ) . '"'
								. ( ! empty( $the_pipes_attr[3] ) ? ' ' . wp_kses_data( $the_pipes_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $the_pipes_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $the_pipes_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
