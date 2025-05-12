<?php
/* WooCommerce Currency Switcher support functions
------------------------------------------------------------------------------- */

// Check if plugin installed and activated
if ( ! function_exists( 'the_pipes_exists_woocommerce_currency_switcher' ) ) {
    function the_pipes_exists_woocommerce_currency_switcher() {
        return class_exists( 'WOOCS' );
    }
}

if (!function_exists('the_pipes_woocommerce_currency_switcher_theme_setup9')) {
    add_action('after_setup_theme', 'the_pipes_woocommerce_currency_switcher_theme_setup9', 9);
    function the_pipes_woocommerce_currency_switcher_theme_setup9() {
        if (is_admin()) {
            add_filter( 'the_pipes_filter_tgmpa_required_plugins',		'the_pipes_woocommerce_currency_switcher_tgmpa_required_plugins' );
        }
    }
}


// Filter to add in the required plugins list
if ( !function_exists( 'the_pipes_woocommerce_currency_switcher_tgmpa_required_plugins' ) ) {
    function the_pipes_woocommerce_currency_switcher_tgmpa_required_plugins($list=array()) {
        if (the_pipes_storage_isset('required_plugins', 'woocommerce-currency-switcher') && the_pipes_storage_get_array( 'required_plugins', 'woocommerce-currency-switcher', 'install' ) !== false) {
            $list[] = array(
                'name' 		=> the_pipes_storage_get_array('required_plugins', 'woocommerce-currency-switcher', 'title'),
                'slug' 		=> 'woocommerce-currency-switcher',
                'required' 	=> false
            );

        }
        return $list;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'the_pipes_woocommerce_currency_switcher_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',    'the_pipes_woocommerce_currency_switcher_importer_set_options' );
    function the_pipes_woocommerce_currency_switcher_importer_set_options($options=array()) {
        if ( the_pipes_exists_woocommerce_currency_switcher() && in_array('woocommerce-currency-switcher', $options['required_plugins']) ) {
            $options['additional_options'][]    = 'woocs_drop_down_view';
            $options['additional_options'][]    = 'woocs';
        }
        return $options;
    }
}