<div class="front_page_section front_page_section_contacts<?php
	$the_pipes_scheme = the_pipes_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $the_pipes_scheme ) && ! the_pipes_is_inherit( $the_pipes_scheme ) ) {
		echo ' scheme_' . esc_attr( $the_pipes_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( the_pipes_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( the_pipes_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$the_pipes_css      = '';
		$the_pipes_bg_image = the_pipes_get_theme_option( 'front_page_contacts_bg_image' );
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
	$the_pipes_anchor_icon = the_pipes_get_theme_option( 'front_page_contacts_anchor_icon' );
	$the_pipes_anchor_text = the_pipes_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $the_pipes_anchor_icon ) || ! empty( $the_pipes_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $the_pipes_anchor_icon ) ? ' icon="' . esc_attr( $the_pipes_anchor_icon ) . '"' : '' )
									. ( ! empty( $the_pipes_anchor_text ) ? ' title="' . esc_attr( $the_pipes_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( the_pipes_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' the-pipes-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$the_pipes_css      = '';
			$the_pipes_bg_mask  = the_pipes_get_theme_option( 'front_page_contacts_bg_mask' );
			$the_pipes_bg_color_type = the_pipes_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $the_pipes_bg_color_type ) {
				$the_pipes_bg_color = the_pipes_get_theme_option( 'front_page_contacts_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$the_pipes_caption     = the_pipes_get_theme_option( 'front_page_contacts_caption' );
			$the_pipes_description = the_pipes_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $the_pipes_caption ) || ! empty( $the_pipes_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $the_pipes_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $the_pipes_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $the_pipes_caption, 'the_pipes_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $the_pipes_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $the_pipes_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $the_pipes_description ), 'the_pipes_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$the_pipes_content = the_pipes_get_theme_option( 'front_page_contacts_content' );
			$the_pipes_layout  = the_pipes_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $the_pipes_layout && ( ! empty( $the_pipes_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $the_pipes_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $the_pipes_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $the_pipes_content, 'the_pipes_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $the_pipes_layout && ( ! empty( $the_pipes_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$the_pipes_sc = the_pipes_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $the_pipes_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $the_pipes_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					the_pipes_show_layout( do_shortcode( $the_pipes_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $the_pipes_layout && ( ! empty( $the_pipes_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
