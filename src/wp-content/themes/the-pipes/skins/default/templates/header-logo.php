<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

$the_pipes_args = get_query_var( 'the_pipes_logo_args' );

// Site logo
$the_pipes_logo_type   = isset( $the_pipes_args['type'] ) ? $the_pipes_args['type'] : '';
$the_pipes_logo_image  = the_pipes_get_logo_image( $the_pipes_logo_type );
$the_pipes_logo_text   = the_pipes_is_on( the_pipes_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$the_pipes_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $the_pipes_logo_image['logo'] ) || ! empty( $the_pipes_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $the_pipes_logo_image['logo'] ) ) {
			if ( empty( $the_pipes_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($the_pipes_logo_image['logo']) && (int) $the_pipes_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$the_pipes_attr = the_pipes_getimagesize( $the_pipes_logo_image['logo'] );
				echo '<img src="' . esc_url( $the_pipes_logo_image['logo'] ) . '"'
						. ( ! empty( $the_pipes_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $the_pipes_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $the_pipes_logo_text ) . '"'
						. ( ! empty( $the_pipes_attr[3] ) ? ' ' . wp_kses_data( $the_pipes_attr[3] ) : '' )
						. '>';
			}
		} else {
			the_pipes_show_layout( the_pipes_prepare_macros( $the_pipes_logo_text ), '<span class="logo_text">', '</span>' );
			the_pipes_show_layout( the_pipes_prepare_macros( $the_pipes_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
