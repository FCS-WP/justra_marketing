<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package THE PIPES
 * @since THE PIPES 1.0
 */

// Page (category, tag, archive, author) title

if ( the_pipes_need_page_title() ) {
	the_pipes_sc_layouts_showed( 'title', true );
	the_pipes_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								the_pipes_show_post_meta(
									apply_filters(
										'the_pipes_filter_post_meta_args', array(
											'components' => join( ',', the_pipes_array_get_keys_by_value( the_pipes_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', the_pipes_array_get_keys_by_value( the_pipes_get_theme_option( 'counters' ) ) ),
											'seo'        => the_pipes_is_on( the_pipes_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$the_pipes_blog_title           = the_pipes_get_blog_title();
							$the_pipes_blog_title_text      = '';
							$the_pipes_blog_title_class     = '';
							$the_pipes_blog_title_link      = '';
							$the_pipes_blog_title_link_text = '';
							if ( is_array( $the_pipes_blog_title ) ) {
								$the_pipes_blog_title_text      = $the_pipes_blog_title['text'];
								$the_pipes_blog_title_class     = ! empty( $the_pipes_blog_title['class'] ) ? ' ' . $the_pipes_blog_title['class'] : '';
								$the_pipes_blog_title_link      = ! empty( $the_pipes_blog_title['link'] ) ? $the_pipes_blog_title['link'] : '';
								$the_pipes_blog_title_link_text = ! empty( $the_pipes_blog_title['link_text'] ) ? $the_pipes_blog_title['link_text'] : '';
							} else {
								$the_pipes_blog_title_text = $the_pipes_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $the_pipes_blog_title_class ); ?>">
								<?php
								$the_pipes_top_icon = the_pipes_get_term_image_small();
								if ( ! empty( $the_pipes_top_icon ) ) {
									$the_pipes_attr = the_pipes_getimagesize( $the_pipes_top_icon );
									?>
									<img src="<?php echo esc_url( $the_pipes_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'the-pipes' ); ?>"
										<?php
										if ( ! empty( $the_pipes_attr[3] ) ) {
											the_pipes_show_layout( $the_pipes_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $the_pipes_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $the_pipes_blog_title_link ) && ! empty( $the_pipes_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $the_pipes_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $the_pipes_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'the_pipes_action_breadcrumbs' );
						$the_pipes_breadcrumbs = ob_get_contents();
						ob_end_clean();
						the_pipes_show_layout( $the_pipes_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
