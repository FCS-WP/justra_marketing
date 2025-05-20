<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.10
 */

// Footer sidebar
$the_pipes_footer_name    = the_pipes_get_theme_option( 'footer_widgets' );
$the_pipes_footer_present = ! the_pipes_is_off( $the_pipes_footer_name ) && is_active_sidebar( $the_pipes_footer_name );
if ( $the_pipes_footer_present ) {
	the_pipes_storage_set( 'current_sidebar', 'footer' );
	$the_pipes_footer_wide = the_pipes_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $the_pipes_footer_name ) ) {
		dynamic_sidebar( $the_pipes_footer_name );
	}
	$the_pipes_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $the_pipes_out ) ) {
		$the_pipes_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $the_pipes_out );
		$the_pipes_need_columns = true;   //or check: strpos($the_pipes_out, 'columns_wrap')===false;
		if ( $the_pipes_need_columns ) {
			$the_pipes_columns = max( 0, (int) the_pipes_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $the_pipes_columns ) {
				$the_pipes_columns = min( 4, max( 1, the_pipes_tags_count( $the_pipes_out, 'aside' ) ) );
			}
			if ( $the_pipes_columns > 1 ) {
				$the_pipes_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $the_pipes_columns ) . ' widget', $the_pipes_out );
			} else {
				$the_pipes_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $the_pipes_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'the_pipes_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $the_pipes_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $the_pipes_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'the_pipes_action_before_sidebar', 'footer' );
				the_pipes_show_layout( $the_pipes_out );
				do_action( 'the_pipes_action_after_sidebar', 'footer' );
				if ( $the_pipes_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $the_pipes_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'the_pipes_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
