<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.06
 */

$the_pipes_header_css   = '';
$the_pipes_header_image = get_header_image();
$the_pipes_header_video = the_pipes_get_header_video();
if ( ! empty( $the_pipes_header_image ) && the_pipes_trx_addons_featured_image_override( is_singular() || the_pipes_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$the_pipes_header_image = the_pipes_get_current_mode_image( $the_pipes_header_image );
}

$the_pipes_header_id = the_pipes_get_custom_header_id();
$the_pipes_header_meta = get_post_meta( $the_pipes_header_id, 'trx_addons_options', true );
if ( ! empty( $the_pipes_header_meta['margin'] ) ) {
	the_pipes_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( the_pipes_prepare_css_value( $the_pipes_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $the_pipes_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $the_pipes_header_id ) ) ); ?>
				<?php
				echo ! empty( $the_pipes_header_image ) || ! empty( $the_pipes_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $the_pipes_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $the_pipes_header_image ) {
					echo ' ' . esc_attr( the_pipes_add_inline_css_class( 'background-image: url(' . esc_url( $the_pipes_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( the_pipes_is_on( the_pipes_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight the-pipes-full-height';
				}
				$the_pipes_header_scheme = the_pipes_get_theme_option( 'header_scheme' );
				if ( ! empty( $the_pipes_header_scheme ) && ! the_pipes_is_inherit( $the_pipes_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $the_pipes_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $the_pipes_header_video ) ) {
		get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'the_pipes_action_show_layout', $the_pipes_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
