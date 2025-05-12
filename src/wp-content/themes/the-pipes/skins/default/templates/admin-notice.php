<?php
/**
 * The template to display Admin notices
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.1
 */

$the_pipes_theme_slug = get_option( 'template' );
$the_pipes_theme_obj  = wp_get_theme( $the_pipes_theme_slug );
?>
<div class="the_pipes_admin_notice the_pipes_welcome_notice notice notice-info is-dismissible" data-notice="admin">
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
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'the-pipes' ),
				$the_pipes_theme_obj->get( 'Name' ) . ( THE_PIPES_THEME_FREE ? ' ' . __( 'Free', 'the-pipes' ) : '' ),
				$the_pipes_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="the_pipes_notice_text">
		<p class="the_pipes_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $the_pipes_theme_obj->description ) );
			?>
		</p>
		<p class="the_pipes_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'the-pipes' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="the_pipes_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=the_pipes_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'the-pipes' );
			?>
		</a>
	</div>
</div>
