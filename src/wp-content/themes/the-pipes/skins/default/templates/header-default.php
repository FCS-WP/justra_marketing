<?php
/**
 * The template to display default site header
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

$the_pipes_header_css   = '';
$the_pipes_header_image = get_header_image();
$the_pipes_header_video = the_pipes_get_header_video();
if ( ! empty( $the_pipes_header_image ) && the_pipes_trx_addons_featured_image_override( is_singular() || the_pipes_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$the_pipes_header_image = the_pipes_get_current_mode_image( $the_pipes_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $the_pipes_header_image ) || ! empty( $the_pipes_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( the_pipes_is_on( the_pipes_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
