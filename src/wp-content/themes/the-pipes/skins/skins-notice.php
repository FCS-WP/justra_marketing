<?php
/**
 * The template to display Admin notices
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.64
 */

$the_pipes_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$the_pipes_skins_args = get_query_var( 'the_pipes_skins_notice_args' );
?>
<div class="the_pipes_admin_notice the_pipes_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins are available', 'the-pipes' ); ?>
	</h3>
	<?php

	// Description
	$the_pipes_total      = $the_pipes_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$the_pipes_skins_msg  = $the_pipes_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $the_pipes_total, 'the-pipes' ), $the_pipes_total ) . '</strong>'
							: '';
	$the_pipes_total      = $the_pipes_skins_args['free'];
	$the_pipes_skins_msg .= $the_pipes_total > 0
							? ( ! empty( $the_pipes_skins_msg ) ? ' ' . esc_html__( 'and', 'the-pipes' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $the_pipes_total, 'the-pipes' ), $the_pipes_total ) . '</strong>'
							: '';
	$the_pipes_total      = $the_pipes_skins_args['pay'];
	$the_pipes_skins_msg .= $the_pipes_skins_args['pay'] > 0
							? ( ! empty( $the_pipes_skins_msg ) ? ' ' . esc_html__( 'and', 'the-pipes' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $the_pipes_total, 'the-pipes' ), $the_pipes_total ) . '</strong>'
							: '';
	?>
	<div class="the_pipes_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'the-pipes' ), $the_pipes_skins_msg ) );
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
