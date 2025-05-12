<?php
/**
 * The Header: Logo and main menu
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( the_pipes_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'the_pipes_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'the_pipes_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('the_pipes_action_body_wrap_attributes'); ?>>

		<?php do_action( 'the_pipes_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'the_pipes_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('the_pipes_action_page_wrap_attributes'); ?>>

			<?php do_action( 'the_pipes_action_page_wrap_start' ); ?>

			<?php
			$the_pipes_full_post_loading = ( the_pipes_is_singular( 'post' ) || the_pipes_is_singular( 'attachment' ) ) && the_pipes_get_value_gp( 'action' ) == 'full_post_loading';
			$the_pipes_prev_post_loading = ( the_pipes_is_singular( 'post' ) || the_pipes_is_singular( 'attachment' ) ) && the_pipes_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $the_pipes_full_post_loading && ! $the_pipes_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="the_pipes_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'the_pipes_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'the-pipes' ); ?></a>
				<?php if ( the_pipes_sidebar_present() ) { ?>
				<a class="the_pipes_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'the_pipes_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'the-pipes' ); ?></a>
				<?php } ?>
				<a class="the_pipes_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'the_pipes_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'the-pipes' ); ?></a>

				<?php
				do_action( 'the_pipes_action_before_header' );

				// Header
				$the_pipes_header_type = the_pipes_get_theme_option( 'header_type' );
				if ( 'custom' == $the_pipes_header_type && ! the_pipes_is_layouts_available() ) {
					$the_pipes_header_type = 'default';
				}
				get_template_part( apply_filters( 'the_pipes_filter_get_template_part', "templates/header-" . sanitize_file_name( $the_pipes_header_type ) ) );

				// Side menu
				if ( in_array( the_pipes_get_theme_option( 'menu_side', 'none' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				if ( apply_filters( 'the_pipes_filter_use_navi_mobile', true ) ) {
					get_template_part( apply_filters( 'the_pipes_filter_get_template_part', 'templates/header-navi-mobile' ) );
				}

				do_action( 'the_pipes_action_after_header' );

			}
			?>

			<?php do_action( 'the_pipes_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( the_pipes_is_off( the_pipes_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $the_pipes_header_type ) ) {
						$the_pipes_header_type = the_pipes_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $the_pipes_header_type && the_pipes_is_layouts_available() ) {
						$the_pipes_header_id = the_pipes_get_custom_header_id();
						if ( $the_pipes_header_id > 0 ) {
							$the_pipes_header_meta = the_pipes_get_custom_layout_meta( $the_pipes_header_id );
							if ( ! empty( $the_pipes_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$the_pipes_footer_type = the_pipes_get_theme_option( 'footer_type' );
					if ( 'custom' == $the_pipes_footer_type && the_pipes_is_layouts_available() ) {
						$the_pipes_footer_id = the_pipes_get_custom_footer_id();
						if ( $the_pipes_footer_id ) {
							$the_pipes_footer_meta = the_pipes_get_custom_layout_meta( $the_pipes_footer_id );
							if ( ! empty( $the_pipes_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'the_pipes_action_page_content_wrap_class', $the_pipes_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'the_pipes_filter_is_prev_post_loading', $the_pipes_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( the_pipes_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'the_pipes_action_page_content_wrap_data', $the_pipes_prev_post_loading );
			?>>
				<?php
				do_action( 'the_pipes_action_page_content_wrap', $the_pipes_full_post_loading || $the_pipes_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'the_pipes_filter_single_post_header', the_pipes_is_singular( 'post' ) || the_pipes_is_singular( 'attachment' ) ) ) {
					if ( $the_pipes_prev_post_loading ) {
						if ( the_pipes_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) != 'article' ) {
							do_action( 'the_pipes_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$the_pipes_path = apply_filters( 'the_pipes_filter_get_template_part', 'templates/single-styles/' . the_pipes_get_theme_option( 'single_style' ) );
					if ( the_pipes_get_file_dir( $the_pipes_path . '.php' ) != '' ) {
						get_template_part( $the_pipes_path );
					}
				}

				// Widgets area above page
				$the_pipes_body_style   = the_pipes_get_theme_option( 'body_style' );
				$the_pipes_widgets_name = the_pipes_get_theme_option( 'widgets_above_page', 'hide' );
				$the_pipes_show_widgets = ! the_pipes_is_off( $the_pipes_widgets_name ) && is_active_sidebar( $the_pipes_widgets_name );
				if ( $the_pipes_show_widgets ) {
					if ( 'fullscreen' != $the_pipes_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					the_pipes_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $the_pipes_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'the_pipes_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $the_pipes_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'the_pipes_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'the_pipes_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="the_pipes_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( the_pipes_is_singular( 'post' ) || the_pipes_is_singular( 'attachment' ) )
							&& $the_pipes_prev_post_loading 
							&& the_pipes_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) == 'article'
						) {
							do_action( 'the_pipes_action_between_posts' );
						}

						// Widgets area above content
						the_pipes_create_widgets_area( 'widgets_above_content' );

						do_action( 'the_pipes_action_page_content_start_text' );
