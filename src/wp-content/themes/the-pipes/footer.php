<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

							do_action( 'the_pipes_action_page_content_end_text' );
							
							// Widgets area below the content
							the_pipes_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'the_pipes_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'the_pipes_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'the_pipes_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'the_pipes_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$the_pipes_body_style = the_pipes_get_theme_option( 'body_style' );
					$the_pipes_widgets_name = the_pipes_get_theme_option( 'widgets_below_page', 'hide' );
					$the_pipes_show_widgets = ! the_pipes_is_off( $the_pipes_widgets_name ) && is_active_sidebar( $the_pipes_widgets_name );
					$the_pipes_show_related = the_pipes_is_single() && the_pipes_get_theme_option( 'related_position', 'below_content' ) == 'below_page';
					if ( $the_pipes_show_widgets || $the_pipes_show_related ) {
						if ( 'fullscreen' != $the_pipes_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $the_pipes_show_related ) {
							do_action( 'the_pipes_action_related_posts' );
						}

						// Widgets area below page content
						if ( $the_pipes_show_widgets ) {
							the_pipes_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $the_pipes_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'the_pipes_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'the_pipes_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! the_pipes_is_singular( 'post' ) && ! the_pipes_is_singular( 'attachment' ) ) || ! in_array ( the_pipes_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="the_pipes_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'the_pipes_action_before_footer' );

				// Footer
				$the_pipes_footer_type = the_pipes_get_theme_option( 'footer_type' );
				if ( 'custom' == $the_pipes_footer_type && ! the_pipes_is_layouts_available() ) {
					$the_pipes_footer_type = 'default';
				}
				get_template_part( apply_filters( 'the_pipes_filter_get_template_part', "templates/footer-" . sanitize_file_name( $the_pipes_footer_type ) ) );

				do_action( 'the_pipes_action_after_footer' );

			}
			?>

			<?php do_action( 'the_pipes_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'the_pipes_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'the_pipes_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>