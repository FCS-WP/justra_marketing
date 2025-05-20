<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'the_pipes_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'the_pipes_mailchimp_theme_setup9', 9 );
	function the_pipes_mailchimp_theme_setup9() {
		if ( the_pipes_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'the_pipes_mailchimp_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'the_pipes_mailchimp_frontend_scripts', 10, 1 );
			add_filter( 'the_pipes_filter_merge_styles', 'the_pipes_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'the_pipes_filter_tgmpa_required_plugins', 'the_pipes_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'the_pipes_mailchimp_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('the_pipes_filter_tgmpa_required_plugins',	'the_pipes_mailchimp_tgmpa_required_plugins');
	function the_pipes_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( the_pipes_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && the_pipes_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => the_pipes_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'the_pipes_exists_mailchimp' ) ) {
	function the_pipes_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'the_pipes_mailchimp_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'the_pipes_mailchimp_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'the_pipes_mailchimp_frontend_scripts', 10, 1 );
	function the_pipes_mailchimp_frontend_scripts( $force = false ) {
		the_pipes_enqueue_optimized( 'mailchimp', $force, array(
			'css' => array(
				'the-pipes-mailchimp-for-wp' => array( 'src' => 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'the_pipes_mailchimp_merge_styles' ) ) {
	//Handler of the add_filter( 'the_pipes_filter_merge_styles', 'the_pipes_mailchimp_merge_styles');
	function the_pipes_mailchimp_merge_styles( $list ) {
		$list[ 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( the_pipes_exists_mailchimp() ) {
	$the_pipes_fdir = the_pipes_get_file_dir( 'plugins/mailchimp-for-wp/mailchimp-for-wp-style.php' );
	if ( ! empty( $the_pipes_fdir ) ) {
		require_once $the_pipes_fdir;
	}
}

