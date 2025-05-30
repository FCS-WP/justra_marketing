<?php
/**
 * Skin Setup
 *
 * @package THE PIPES
 * @since THE PIPES 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'the_pipes_theme_defaults' ) ) {
	function the_pipes_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 60,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 30,
			'grid_gap'          => 30,
			'rad'               => 0,
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( $value === '' && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'the_pipes_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'the_pipes_skin_setup', 1 );
	function the_pipes_skin_setup() {

		$GLOBALS['THE_PIPES_STORAGE'] = array_merge( $GLOBALS['THE_PIPES_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-ancora',

			'theme_doc_url'       => '//thepipes.ancorathemes.com/doc',

			'theme_demofiles_url' => '//demofiles.ancorathemes.com/the-pipes/',
			
			'theme_rate_url'      => '//themeforest.net/downloads',

			'theme_custom_url'    => '//ancorathemes.com/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//themeforest.net/user/ancorathemes/portfolio',        // Ancora

			'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   // Ancora

			'theme_privacy_url'   => '//ancorathemes.com/privacy-policy/',                   // Ancora

			'portfolio_url'       => '//themeforest.net/user/ancorathemes/portfolio',        // Ancora

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'the_pipes_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'the_pipes_skin_setup_settings', 1 );
	function the_pipes_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		the_pipes_storage_set_array( 'settings', 'thumbs_in_navigation', false );
	}
}



//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'the_pipes_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'the_pipes_skin_setup_fonts', 1 );
	function the_pipes_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		the_pipes_storage_set(
			'load_fonts', array(
				array(
					'name'   => 'europa',
					'family' => 'sans-serif',
					'link'   => 'https://use.typekit.net/qmj1tmx.css',
					'styles' => ''
				),	
				// Google font
				array(
					'name'   => 'Hind Madurai',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'wght@300;400;500;600;700',     // Parameter 'style' used only for the Google fonts
				),
				array(
					'name'   => 'DM Sans',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,400;0,500;0,700;1,400;1,500;1,700',     // Parameter 'style' used only for the Google fonts
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		the_pipes_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => the_pipes_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'the-pipes' );

		the_pipes_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'the-pipes' ) ),
					'font-family'     => 'DM Sans,sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.62em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.57em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'the-pipes' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '3.167em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1px',
					'margin-top'      => '1.04em',
					'margin-bottom'   => '0.35em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '2.611em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.1px',
					'margin-top'      => '0.8em',
					'margin-bottom'   => '0.45em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '1.944em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.55em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '1.556em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.45em',
					'margin-bottom'   => '0.6em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '1.333em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.417em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.45em',
					'margin-bottom'   => '0.65em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '1.056em',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '2.4em',
					'margin-bottom'   => '.85em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '17px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'the-pipes' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '16px',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'the-pipes' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'the-pipes' ) ),
					'font-family'     => 'Hind Madurai,sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'the-pipes' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'the-pipes' ) ),
					'font-family'     => 'DM Sans,sans-serif',
				),
			)
		);

		// Font presets
		the_pipes_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'the-pipes' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'the-pipes' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'the-pipes' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'the_pipes_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'the_pipes_skin_setup_schemes', 1 );
	function the_pipes_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		the_pipes_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'the-pipes' ),
					'description' => esc_html__( 'Colors of the main content area', 'the-pipes' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'the-pipes' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'the-pipes' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'the-pipes' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'the-pipes' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'the-pipes' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'the-pipes' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'the-pipes' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'the-pipes' ),
				),
			)
		);

		the_pipes_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'the-pipes' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'the-pipes' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'the-pipes' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'the-pipes' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'the-pipes' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'the-pipes' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'the-pipes' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'the-pipes' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'the-pipes' ),
					'description' => esc_html__( 'Color of the text inside this block', 'the-pipes' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'the-pipes' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'the-pipes' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'the-pipes' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'the-pipes' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'the-pipes' ),
					'description' => esc_html__( 'Color of the links inside this block', 'the-pipes' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'the-pipes' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'the-pipes' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'the-pipes' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'the-pipes' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'the-pipes' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'the-pipes' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'the-pipes' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'the-pipes' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'the-pipes' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'the-pipes' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'the-pipes' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF', //
					'bd_color'         => '#DCDCDC', //
					'bd_hover'         => '#CFCFCF', //

					// Text and links colors
					'text'             => '#5C6164', //
					'text_light'       => '#91999E', //
					'text_dark'        => '#232A34', //
					'text_link'        => '#04BBE8', //
					'text_hover'       => '#232A34', //
					'text_link2'       => '#FDAC2B',
					'text_hover2'      => '#E59617',
					'text_link3'        => '#04BBE8', //
					'text_hover3'       => '#232A34', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F5F5F5', //
					'alter_bg_hover'   => '#EFEFEF', //
					'alter_bd_color'   => '#DCDCDC', //
					'alter_bd_hover'   => '#CFCFCF', //
					'alter_text'       => '#5C6164', //
					'alter_light'      => '#91999E', //
					'alter_dark'       => '#232A34', //
					'alter_link'       => '#04BBE8', //
					'alter_hover'      => '#232A34', //
					'alter_link2'       => '#FDAC2B',
					'alter_hover2'      => '#E59617',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#22252B', //
					'extra_bg_hover'   => '#22252B',
					'extra_bd_color'   => '#3C414C',
					'extra_bd_hover'   => '#F9F9F9',
					'extra_text'       => '#96999F', //
					'extra_light'      => '#04BBE8',
					'extra_dark'       => '#FFFFFF', //
					'extra_link'       => '#D2D3D5', //
					'extra_hover'      => '#FFFFFF', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#FFFFFF', //
					'input_bg_hover'   => '#FFFFFF', //
					'input_bd_color'   => '#DCDCDC', //
					'input_bd_hover'   => '#232a34', //
					'input_text'       => '#5C6164', //
					'input_light'      => '#91999E', //
					'input_dark'       => '#232A34', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bg_color' => '#FFFFFF',
					'inverse_bg_hover' => '#efefef',
					'inverse_bd_color' => '#F5F5F5',
					'inverse_text'     => '#232A34',
					'inverse_light'    => '#3c414c',
					'inverse_dark'     => '#232A34', //
					'inverse_link'     => '#F9F9F9', //
					'inverse_hover'    => '#F9F9F9', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'the-pipes' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#090A0C', //
					'bd_color'         => '#3C414C', //
					'bd_hover'         => '#575C67', //

					// Text and links colors
					'text'             => '#D2D3D5', //
					'text_light'       => '#96999F', //
					'text_dark'        => '#F9F9F9', //
					'text_link'        => '#04BBE8', //
					'text_hover'       => '#FFFFFF', //
					'text_link2'       => '#E59617',
					'text_hover2'      => '#FFFFFF',
					'text_link3'        => '#04BBE8', //
					'text_hover3'       => '#FFFFFF', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#22252B', //
					'alter_bg_hover'   => '#282C33', //
					'alter_bd_color'   => '#3C414C', //
					'alter_bd_hover'   => '#575C67', //
					'alter_text'       => '#D2D3D5', //
					'alter_light'      => '#96999F', //
					'alter_dark'       => '#F9F9F9', //
					'alter_link'       => '#04BBE8', //
					'alter_hover'      => '#FFFFFF', //
					'alter_link2'       => '#FDAC2B',
					'alter_hover2'      => '#E59617',
					

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#22252B',
					'extra_bg_hover'   => '#22252B',
					'extra_bd_color'   => '#DCDCDC',
					'extra_bd_hover'   => '#3C414C',
				//	'extra_text'       => '#96999F',
					'extra_light'      => '#04bbe8',
					'extra_dark'       => '#91999E',
					'extra_link'       => '#5C6164',
					'extra_hover'      => '#FFFFFF',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#282c33', //
					'input_bg_hover'   => '#090A0C', //
					'input_bd_color'   => '#3C414C', //
					'input_bd_hover'   => '#575C67', //
					'input_text'       => '#D2D3D5', //
					'input_light'      => '#96999F', //
					'input_dark'       => '#F9F9F9',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bg_color' => '#FFFFFF',
					'inverse_bg_hover' => '#efefef',
					'inverse_bd_color' => '#F9F9F9',
				//	'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9', //
					'inverse_light'    => '#91999e',
					'inverse_dark'     => '#232A34', //
					'inverse_link'     => '#F9F9F9', //
					'inverse_hover'    => '#232A34', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'default'
			'light' => array(
				'title'    => esc_html__( 'Light', 'the-pipes' ),
				'internal' => true,
				'colors'   => array(

									// Whole block border and background
					'bg_color'         => '#F5F5F5', //
					'bd_color'         => '#DCDCDC', //
					'bd_hover'         => '#CFCFCF', //

					// Text and links colors
					'text'             => '#5C6164', //
					'text_light'       => '#91999E', //
					'text_dark'        => '#232A34', //
					'text_link'        => '#FDAC2B', //
					'text_hover'       => '#E59617', //
					'text_link2'       => '#04bbe8',
					'text_hover2'      => '#232a34',
					'text_link3'        => '#FDAC2B', //
					'text_hover3'       => '#E59617', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //
					'alter_bg_hover'   => '#EFEFEF', //
					'alter_bd_color'   => '#DCDCDC', //
					'alter_bd_hover'   => '#CFCFCF', //
					'alter_text'       => '#5C6164', //
					'alter_light'      => '#91999E', //
					'alter_dark'       => '#232A34', //
					'alter_link'       => '#FDAC2B', //
					'alter_hover'      => '#e59617', //
					'alter_link2'       => '#04bbe8',
					'alter_hover2'      => '#232a34',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#22252B', //
					'extra_bg_hover'   => '#22252B',
					'extra_bd_color'   => '#3C414C',
					'extra_bd_hover'   => '#F9F9F9',
					'extra_text'       => '#96999F', //
					'extra_light'      => '#FDAC2B', //
					'extra_link'       => '#D2D3D5', //
					'extra_hover'      => '#FFFFFF', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#FFFFFF', //
					'input_bg_hover'   => '#F9F9F9', //
					'input_bd_color'   => '#DCDCDC', //
					'input_bd_hover'   => '#232a34', //
					'input_text'       => '#5C6164', //
					'input_light'      => '#91999E', //
					'input_dark'       => '#232A34', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bg_color' => '#FFFFFF',
					'inverse_bg_hover' => '#efefef',
					'inverse_bd_color' => '#F5F5F5',
					'inverse_text'     => '#232A34',
					'inverse_light'    => '#3c414c',
					'inverse_dark'     => '#232A34', //
					'inverse_link'     => '#F9F9F9', //
					'inverse_hover'    => '#F9F9F9', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
						// Color scheme: 'dark'
			'dark_light'    => array(
				'title'    => esc_html__( 'Dark light', 'the-pipes' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#090A0C', //
					'bd_color'         => '#3C414C', //
					'bd_hover'         => '#575C67', //

					// Text and links colors
					'text'             => '#D2D3D5', //
					'text_light'       => '#96999F', //
					'text_dark'        => '#F9F9F9', //
					'text_link'        => '#E59617', //
					'text_hover'       => '#FFFFFF', //
					'text_link2'       => '#04bbe8',
					'text_hover2'      => '#FFFFFF',
					'text_link3'        => '#04BBE8', //
					'text_hover3'       => '#FFFFFF', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#22252B', //
					'alter_bg_hover'   => '#282C33', //
					'alter_bd_color'   => '#3C414C', //
					'alter_bd_hover'   => '#575C67', //
					'alter_text'       => '#D2D3D5', //
					'alter_light'      => '#96999F', //
					'alter_dark'       => '#F9F9F9', //
					'alter_link'       => '#E59617', //
					'alter_hover'      => '#FFFFFF', //
					'alter_link2'       => '#04bbe8',
					'alter_hover2'      => '#ffffff',
					

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#22252B',
					'extra_bg_hover'   => '#22252B',
					'extra_bd_color'   => '#DCDCDC',
					'extra_bd_hover'   => '#3C414C',
				//	'extra_text'       => '#96999F',
					'extra_light'      => '#FDAC2B',
					'extra_dark'       => '#91999E',
					'extra_link'       => '#5C6164',
					'extra_hover'      => '#FDAC2B',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#22252B', //
					'input_bg_hover'   => '#090A0C', //
					'input_bd_color'   => '#3C414C', //
					'input_bd_hover'   => '#575C67', //
					'input_text'       => '#D2D3D5', //
					'input_light'      => '#96999F', //
					'input_dark'       => '#F9F9F9',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bg_color' => '#FFFFFF',
					'inverse_bg_hover' => '#efefef',
					'inverse_bd_color' => '#F9F9F9',
				//	'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9', //
					'inverse_light'    => '#91999e',
					'inverse_dark'     => '#232A34', //
					'inverse_link'     => '#F9F9F9', //
					'inverse_hover'    => '#232A34', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			// Color scheme: 'modern'
			'modern' => array(
				'title'    => esc_html__( 'Modern', 'the-pipes' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F5F5F5', //
					'bd_color'         => '#DCDCDC', //
					'bd_hover'         => '#CFCFCF', //

					// Text and links colors
					'text'             => '#5C6164', //
					'text_light'       => '#91999E', //
					'text_dark'        => '#232A34', //
					'text_link'        => '#04BBE8', //
					'text_hover'       => '#232A34', //
					'text_link2'       => '#FDAC2B',
					'text_hover2'      => '#E59617',
					'text_link3'        => '#04BBE8', //
					'text_hover3'       => '#232A34', //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF', //
					'alter_bg_hover'   => '#EFEFEF', //
					'alter_bd_color'   => '#DCDCDC', //
					'alter_bd_hover'   => '#CFCFCF', //
					'alter_text'       => '#5C6164', //
					'alter_light'      => '#91999E', //
					'alter_dark'       => '#232A34', //
					'alter_link'       => '#04BBE8', //
					'alter_hover'      => '#232A34', //
					'alter_link2'       => '#FDAC2B',
					'alter_hover2'      => '#E59617',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#22252B', //
					'extra_bg_hover'   => '#22252B',
					'extra_bd_color'   => '#3C414C',
					'extra_bd_hover'   => '#F9F9F9',
					'extra_text'       => '#96999F', //
					'extra_dark'       => '#FFFFFF', //
					'extra_link'       => '#D2D3D5', //
					'extra_hover'      => '#FFFFFF', //

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#F5F5F5', //
					'input_bg_hover'   => '#FFFFFF', //
					'input_bd_color'   => '#DCDCDC', //
					'input_bd_hover'   => '#232a34 		', //
					'input_text'       => '#5C6164', //
					'input_light'      => '#91999E', //
					'input_dark'       => '#232A34', //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bg_color' => '#FFFFFF',
					'inverse_bg_hover' => '#efefef',
					'inverse_bd_color' => '#F5F5F5',
					'inverse_text'     => '#232A34',
					'inverse_light'    => '#3c414c',
					'inverse_dark'     => '#232A34', //
					'inverse_link'     => '#F9F9F9', //
					'inverse_hover'    => '#F9F9F9', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		the_pipes_storage_set( 'schemes', $schemes );
		the_pipes_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> the_pipes_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'the-pipes' ),
		//---> 	'description' => __( 'Description of the new color 1', 'the-pipes' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		the_pipes_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_08' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.8,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
				'text_link2_09'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.9,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		the_pipes_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Parameters to set order of schemes in the css
		the_pipes_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		the_pipes_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'the-pipes' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'the-pipes' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}
