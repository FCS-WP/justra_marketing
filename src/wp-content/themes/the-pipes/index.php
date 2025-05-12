<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

$the_pipes_template = apply_filters( 'the_pipes_filter_get_template_part', the_pipes_blog_archive_get_template() );

if ( ! empty( $the_pipes_template ) && 'index' != $the_pipes_template ) {

	get_template_part( $the_pipes_template );

} else {

	the_pipes_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$the_pipes_stickies   = is_home()
								|| ( in_array( the_pipes_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) the_pipes_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$the_pipes_post_type  = the_pipes_get_theme_option( 'post_type' );
		$the_pipes_args       = array(
								'blog_style'     => the_pipes_get_theme_option( 'blog_style' ),
								'post_type'      => $the_pipes_post_type,
								'taxonomy'       => the_pipes_get_post_type_taxonomy( $the_pipes_post_type ),
								'parent_cat'     => the_pipes_get_theme_option( 'parent_cat' ),
								'posts_per_page' => the_pipes_get_theme_option( 'posts_per_page' ),
								'sticky'         => the_pipes_get_theme_option( 'sticky_style', 'inherit' ) == 'columns'
															&& is_array( $the_pipes_stickies )
															&& count( $the_pipes_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		the_pipes_blog_archive_start();

		do_action( 'the_pipes_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'the_pipes_action_before_page_author' );
			get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'the_pipes_action_after_page_author' );
		}

		if ( the_pipes_get_theme_option( 'show_filters', 0 ) ) {
			do_action( 'the_pipes_action_before_page_filters' );
			the_pipes_show_filters( $the_pipes_args );
			do_action( 'the_pipes_action_after_page_filters' );
		} else {
			do_action( 'the_pipes_action_before_page_posts' );
			the_pipes_show_posts( array_merge( $the_pipes_args, array( 'cat' => $the_pipes_args['parent_cat'] ) ) );
			do_action( 'the_pipes_action_after_page_posts' );
		}

		do_action( 'the_pipes_action_blog_archive_end' );

		the_pipes_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
