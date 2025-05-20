<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'the_pipes_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'the_pipes_elegro_payment_theme_setup9', 9 );
	function the_pipes_elegro_payment_theme_setup9() {
		if ( the_pipes_exists_elegro_payment() ) {
			add_action( 'wp_enqueue_scripts', 'the_pipes_elegro_payment_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'the_pipes_elegro_payment_frontend_scripts', 10, 1 );
			add_filter( 'the_pipes_filter_merge_styles', 'the_pipes_elegro_payment_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'the_pipes_filter_tgmpa_required_plugins', 'the_pipes_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'the_pipes_elegro_payment_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('the_pipes_filter_tgmpa_required_plugins',	'the_pipes_elegro_payment_tgmpa_required_plugins');
	function the_pipes_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( the_pipes_storage_isset( 'required_plugins', 'woocommerce' ) && the_pipes_storage_isset( 'required_plugins', 'elegro-payment' ) && the_pipes_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
			$list[] = array(
				'name'     => the_pipes_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'the_pipes_exists_elegro_payment' ) ) {
	function the_pipes_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'the_pipes_elegro_payment_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'the_pipes_elegro_payment_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'the_pipes_elegro_payment_frontend_scripts', 10, 1 );
	function the_pipes_elegro_payment_frontend_scripts( $force = false ) {
		the_pipes_enqueue_optimized( 'elegro_payment', $force, array(
			'css' => array(
				'the-pipes-elegro-payment' => array( 'src' => 'plugins/elegro-payment/elegro-payment.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'the_pipes_elegro_payment_merge_styles' ) ) {
	//Handler of the add_filter('the_pipes_filter_merge_styles', 'the_pipes_elegro_payment_merge_styles');
	function the_pipes_elegro_payment_merge_styles( $list ) {
		$list[ 'plugins/elegro-payment/elegro-payment.css' ] = false;
		return $list;
	}
}
