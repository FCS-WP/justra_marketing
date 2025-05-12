<?php
/**
 * The template to display Admin notices
 *
 * @package THE PIPES
 * @since THE PIPES 1.98.0
 */

$the_pipes_skins_url   = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$the_pipes_active_skin = the_pipes_skins_get_active_skin_name();
?>
<div class="the_pipes_admin_notice the_pipes_skins_notice notice notice-error">
	<?php
	// Theme image
	$the_pipes_theme_img = the_pipes_get_file_url( 'screenshot.jpg' );
	if ( '' != $the_pipes_theme_img ) {
		?>
		<div class="the_pipes_notice_image"><img src="<?php echo esc_url( $the_pipes_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'the-pipes' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="the_pipes_notice_title">
		<?php esc_html_e( 'Active skin is missing!', 'the-pipes' ); ?>
	</h3>
	<div class="the_pipes_notice_text">
		<p>
			<?php
			// Translators: Add a current skin name to the message
			echo wp_kses_data( sprintf( __( "Your active skin <b>'%s'</b> is missing. Usually this happens when the theme is updated directly through the server or FTP.", 'the-pipes' ), ucfirst( $the_pipes_active_skin ) ) );
			?>
		</p>
		<p>
			<?php
			echo wp_kses_data( __( "Please use only <b>'ThemeREX Updater v.1.6.0+'</b> plugin for your future updates.", 'the-pipes' ) );
			?>
		</p>
		<p>
			<?php
			echo wp_kses_data( __( "But no worries! You can re-download the skin via 'Skins Manager' ( Theme Panel - Theme Dashboard - Skins ).", 'the-pipes' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="the_pipes_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $the_pipes_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'the-pipes' );
			?>
		</a>
	</div>
</div>
