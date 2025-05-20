<?php
/**
 * Required plugins
 *
 * @package THE PIPES
 * @since THE PIPES 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$the_pipes_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'the-pipes' ),
	'page_builders' => esc_html__( 'Page Builders', 'the-pipes' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'the-pipes' ),
	'socials'       => esc_html__( 'Socials and Communities', 'the-pipes' ),
	'events'        => esc_html__( 'Events and Appointments', 'the-pipes' ),
	'content'       => esc_html__( 'Content', 'the-pipes' ),
	'other'         => esc_html__( 'Other', 'the-pipes' ),
);
$the_pipes_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'the-pipes' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'the-pipes' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $the_pipes_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'the-pipes' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'the-pipes' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $the_pipes_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'the-pipes' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'the-pipes' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $the_pipes_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'the-pipes' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'the-pipes' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $the_pipes_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'the-pipes' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'the-pipes' ),
		'required'    => false,
		'install'     => false, // TRX_addons has marked the "Elegro Crypto Payment" plugin as obsolete and no longer recommends it for installation, even if it had been previously recommended by the theme
		'logo'        => 'elegro-payment.png',
		'group'       => $the_pipes_theme_required_plugins_groups['ecommerce'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'the-pipes' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'the-pipes' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $the_pipes_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'the-pipes' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $the_pipes_theme_required_plugins_groups['events'],
	),
	'quickcal'                     => array(
		'title'       => esc_html__( 'QuickCal', 'the-pipes' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'quickcal.png',
		'group'       => $the_pipes_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'the-pipes' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'the-pipes' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $the_pipes_theme_required_plugins_groups['content'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'the-pipes' ),
		'description' => '',
		'required'    => false,
		'logo'        => the_pipes_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $the_pipes_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'the-pipes' ),
		'description' => '',
		'required'    => false,
		'logo'        => the_pipes_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $the_pipes_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'the-pipes' ),
		'description' => esc_html__( "WooCommerce Wishlist is a simple but powerful tool that can help you to convert your site visitors into loyal customers", 'the-pipes' ),
		'required'    => false,
		'logo'        => the_pipes_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $the_pipes_theme_required_plugins_groups['ecommerce'],
	),
	'woocommerce-currency-switcher'  => array(
		'title'       => esc_html__( 'WOOCS - WooCommerce Currency Switcher', 'the-pipes' ),
		'description' => esc_html__( "WooCommerce multi currency switcher plugin for woocommerce", 'the-pipes' ),
		'required'    => false,
		'logo'        => the_pipes_get_file_url( 'plugins/woocommerce-currency-switcher/woocommerce-currency-switcher.png' ),
		'group'       => $the_pipes_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'the-pipes' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => the_pipes_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $the_pipes_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'the-pipes' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $the_pipes_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'the-pipes' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'the-pipes' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $the_pipes_theme_required_plugins_groups['content'],
	),
	'gdpr-framework'         => array(
		'title'       => esc_html__( 'The GDPR Framework', 'the-pipes' ),
		'description' => esc_html__( "Tools to help make your website GDPR-compliant. Fully documented, extendable and developer-friendly.", 'the-pipes' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'gdpr-framework.png',
		'group'       => $the_pipes_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'the-pipes' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'the-pipes' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $the_pipes_theme_required_plugins_groups['other'],
	),
);

if ( THE_PIPES_THEME_FREE ) {
	unset( $the_pipes_theme_required_plugins['js_composer'] );
	unset( $the_pipes_theme_required_plugins['booked'] );
	unset( $the_pipes_theme_required_plugins['quickcal'] );
	unset( $the_pipes_theme_required_plugins['the-events-calendar'] );
	unset( $the_pipes_theme_required_plugins['calculated-fields-form'] );
	unset( $the_pipes_theme_required_plugins['essential-grid'] );
	unset( $the_pipes_theme_required_plugins['revslider'] );
	unset( $the_pipes_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $the_pipes_theme_required_plugins['trx_updater'] );
	unset( $the_pipes_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
the_pipes_storage_set( 'required_plugins', $the_pipes_theme_required_plugins );
