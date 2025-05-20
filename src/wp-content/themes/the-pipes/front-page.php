<?php
/**
 * The Front Page template file.
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( the_pipes_is_on( the_pipes_get_theme_option( 'front_page_enabled', false ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$the_pipes_sections = the_pipes_array_get_keys_by_value( the_pipes_get_theme_option( 'front_page_sections' ) );
		if ( is_array( $the_pipes_sections ) ) {
			foreach ( $the_pipes_sections as $the_pipes_section ) {
				get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'front-page/section', $the_pipes_section ), $the_pipes_section );
			}
		}

		// Else if this page is a blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'blog' ) );

		// Else - display a native page content
	} else {
		get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'page' ) );
	}

	// Else get the template 'index.php' to show posts
} else {
	get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'index' ) );
}

get_footer();
