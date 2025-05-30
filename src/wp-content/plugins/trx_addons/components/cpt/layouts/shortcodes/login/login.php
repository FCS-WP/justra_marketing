<?php
/**
 * Shortcode: Display Login link
 *
 * @package ThemeREX Addons
 * @since v1.6.08
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	exit;
}


// trx_sc_layouts_login
//-------------------------------------------------------------
/*
[trx_sc_layouts_login id="unique_id" text="Link text" title="link title"]
*/
if ( !function_exists( 'trx_addons_sc_layouts_login' ) ) {
	function trx_addons_sc_layouts_login($atts, $content = ''){	
		$atts = trx_addons_sc_prepare_atts( 'trx_sc_layouts_login', $atts, trx_addons_sc_common_atts( 'trx_sc_layouts_login', 'id,hide', array(
			// Individual params
			"type" => "default",
			"text_login" => "",
			"text_logout" => "",
			"login_icon" => "",
			"login_image" => "",
			"logout_icon" => "",
			"logout_image" => "",
			"user_menu" => "0",
			"user_menu_icon" => "",
			"user_menu_image" => "",
			// Popup params
			'tab_login_icon'      => 'trx_addons_icon-lock-open',
			'tab_login_image'     => '',
			'tab_register_icon'   => 'trx_addons_icon-user-plus',
			'tab_register_image'  => '',
			'field_login_icon'    => 'trx_addons_icon-user-alt',
			'field_password_icon' => 'trx_addons_icon-lock',
			'field_email_icon'    => 'trx_addons_icon-mail',
		) ) );

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'login/tpl.' . trx_addons_esc( trx_addons_sanitize_file_name( $atts['type'] ) ) . '.php',
										TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'login/tpl.default.php'
										),
										'trx_addons_args_sc_layouts_login',
										$atts
									);
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_layouts_login', $atts, $content);
	}
}


// Add shortcode [trx_sc_layouts_login]
if (!function_exists('trx_addons_sc_layouts_login_add_shortcode')) {
	function trx_addons_sc_layouts_login_add_shortcode() {
		
		if (!trx_addons_cpt_layouts_sc_required()) return;

		add_shortcode("trx_sc_layouts_login", "trx_addons_sc_layouts_login");
	}
	add_action('init', 'trx_addons_sc_layouts_login_add_shortcode', 15);
}


// Add shortcodes
//----------------------------------------------------------------------------

// Add shortcodes to Elementor
if ( trx_addons_exists_elementor() && function_exists('trx_addons_elm_init') ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'login/login-sc-elementor.php';
}

// Add shortcodes to Gutenberg
if ( trx_addons_exists_gutenberg() && function_exists( 'trx_addons_gutenberg_get_param_id' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'login/login-sc-gutenberg.php';
}

// Add shortcodes to VC
if ( trx_addons_exists_vc() && function_exists( 'trx_addons_vc_add_id_param' ) ) {
	require_once TRX_ADDONS_PLUGIN_DIR . TRX_ADDONS_PLUGIN_CPT_LAYOUTS_SHORTCODES . 'login/login-sc-vc.php';
}
