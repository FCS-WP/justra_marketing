<?php
$the_pipes_woocommerce_sc = the_pipes_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $the_pipes_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$the_pipes_scheme = the_pipes_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $the_pipes_scheme ) && ! the_pipes_is_inherit( $the_pipes_scheme ) ) {
			echo ' scheme_' . esc_attr( $the_pipes_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( the_pipes_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( the_pipes_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$the_pipes_css      = '';
			$the_pipes_bg_image = the_pipes_get_theme_option( 'front_page_woocommerce_bg_image' );
			if ( ! empty( $the_pipes_bg_image ) ) {
				$the_pipes_css .= 'background-image: url(' . esc_url( the_pipes_get_attachment_url( $the_pipes_bg_image ) ) . ');';
			}
			if ( ! empty( $the_pipes_css ) ) {
				echo ' style="' . esc_attr( $the_pipes_css ) . '"';
			}
			?>
	>
	<?php
		// Add anchor
		$the_pipes_anchor_icon = the_pipes_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$the_pipes_anchor_text = the_pipes_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $the_pipes_anchor_icon ) || ! empty( $the_pipes_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $the_pipes_anchor_icon ) ? ' icon="' . esc_attr( $the_pipes_anchor_icon ) . '"' : '' )
											. ( ! empty( $the_pipes_anchor_text ) ? ' title="' . esc_attr( $the_pipes_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( the_pipes_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' the-pipes-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$the_pipes_css      = '';
				$the_pipes_bg_mask  = the_pipes_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$the_pipes_bg_color_type = the_pipes_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $the_pipes_bg_color_type ) {
					$the_pipes_bg_color = the_pipes_get_theme_option( 'front_page_woocommerce_bg_color' );
				} elseif ( 'scheme_bg_color' == $the_pipes_bg_color_type ) {
					$the_pipes_bg_color = the_pipes_get_scheme_color( 'bg_color', $the_pipes_scheme );
				} else {
					$the_pipes_bg_color = '';
				}
				if ( ! empty( $the_pipes_bg_color ) && $the_pipes_bg_mask > 0 ) {
					$the_pipes_css .= 'background-color: ' . esc_attr(
						1 == $the_pipes_bg_mask ? $the_pipes_bg_color : the_pipes_hex2rgba( $the_pipes_bg_color, $the_pipes_bg_mask )
					) . ';';
				}
				if ( ! empty( $the_pipes_css ) ) {
					echo ' style="' . esc_attr( $the_pipes_css ) . '"';
				}
				?>
		>
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$the_pipes_caption     = the_pipes_get_theme_option( 'front_page_woocommerce_caption' );
				$the_pipes_description = the_pipes_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $the_pipes_caption ) || ! empty( $the_pipes_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $the_pipes_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $the_pipes_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $the_pipes_caption, 'the_pipes_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $the_pipes_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $the_pipes_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $the_pipes_description ), 'the_pipes_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $the_pipes_woocommerce_sc ) {
						$the_pipes_woocommerce_sc_ids      = the_pipes_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$the_pipes_woocommerce_sc_per_page = count( explode( ',', $the_pipes_woocommerce_sc_ids ) );
					} else {
						$the_pipes_woocommerce_sc_per_page = max( 1, (int) the_pipes_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$the_pipes_woocommerce_sc_columns = max( 1, min( $the_pipes_woocommerce_sc_per_page, (int) the_pipes_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$the_pipes_woocommerce_sc}"
										. ( 'products' == $the_pipes_woocommerce_sc
												? ' ids="' . esc_attr( $the_pipes_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $the_pipes_woocommerce_sc
												? ' category="' . esc_attr( the_pipes_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $the_pipes_woocommerce_sc
												? ' orderby="' . esc_attr( the_pipes_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( the_pipes_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $the_pipes_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $the_pipes_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
