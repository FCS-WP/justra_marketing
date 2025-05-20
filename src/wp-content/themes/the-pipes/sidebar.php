<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

if ( the_pipes_sidebar_present() ) {
	
	$the_pipes_sidebar_type = the_pipes_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $the_pipes_sidebar_type && ! the_pipes_is_layouts_available() ) {
		$the_pipes_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $the_pipes_sidebar_type ) {
		// Default sidebar with widgets
		$the_pipes_sidebar_name = the_pipes_get_theme_option( 'sidebar_widgets' );
		the_pipes_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $the_pipes_sidebar_name ) ) {
			dynamic_sidebar( $the_pipes_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$the_pipes_sidebar_id = the_pipes_get_custom_sidebar_id();
		do_action( 'the_pipes_action_show_layout', $the_pipes_sidebar_id );
	}
	$the_pipes_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $the_pipes_out ) ) {
		$the_pipes_sidebar_position    = the_pipes_get_theme_option( 'sidebar_position' );
		$the_pipes_sidebar_position_ss = the_pipes_get_theme_option( 'sidebar_position_ss', 'below' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $the_pipes_sidebar_position );
			echo ' sidebar_' . esc_attr( $the_pipes_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $the_pipes_sidebar_type );

			$the_pipes_sidebar_scheme = apply_filters( 'the_pipes_filter_sidebar_scheme', the_pipes_get_theme_option( 'sidebar_scheme', 'inherit' ) );
			if ( ! empty( $the_pipes_sidebar_scheme ) && ! the_pipes_is_inherit( $the_pipes_sidebar_scheme ) && 'custom' != $the_pipes_sidebar_type ) {
				echo ' scheme_' . esc_attr( $the_pipes_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="the_pipes_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'the_pipes_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $the_pipes_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$the_pipes_title = apply_filters( 'the_pipes_filter_sidebar_control_title', 'float' == $the_pipes_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'the-pipes' ) : '' );
				$the_pipes_text  = apply_filters( 'the_pipes_filter_sidebar_control_text', 'above' == $the_pipes_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'the-pipes' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $the_pipes_title ); ?>"><?php echo esc_html( $the_pipes_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'the_pipes_action_before_sidebar', 'sidebar' );
				the_pipes_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $the_pipes_out ) );
				do_action( 'the_pipes_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'the_pipes_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
