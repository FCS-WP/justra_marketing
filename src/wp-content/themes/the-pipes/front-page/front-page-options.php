<?php
/**
 * Setup options for the Front Page
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.31
 */


// Theme init priorities:
// 3 - add/remove Theme Options elements
// Add sidebars for front page sections to the global list of sidebars
if ( ! function_exists( 'the_pipes_front_page_add_sidebars' ) ) {
	add_action( 'after_setup_theme', 'the_pipes_front_page_add_sidebars', 3 );
	function the_pipes_front_page_add_sidebars() {
		if ( the_pipes_get_theme_setting( 'allow_front_page_builder', true ) ) {
			add_filter( 'the_pipes_filter_list_sidebars', 'the_pipes_front_page_sidebars' );
		}
	}
}


// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'the_pipes_front_page_setup3' ) ) {
	add_action( 'after_setup_theme', 'the_pipes_front_page_setup3', 3 );
	function the_pipes_front_page_setup3() {
		if ( the_pipes_get_theme_setting( 'allow_front_page_builder', true ) ) {
			the_pipes_storage_set_array_before(
				'options', 'blog', apply_filters(
					'the_pipes_filter_front_page_options', array(

						// 'Front Page Sections'
						'front_page'              => array(
							'title'      => esc_html__( 'Front Page Builder', 'the-pipes' ),
							'desc'       => wp_kses_data( __( 'More fine tuning component display Front Page (view and menu position, presence and position of the sidebar, header and footer, etc.) you can produce in the section "Page Options" when editing a page, selected as Front Page', 'the-pipes' ) ),
							'priority'   => 65,
							'expand_url' => esc_url( home_url( '/' ) ),
							'icon'       => 'icon-editor-table',
							'type'       => 'panel',
						),
						// Front Page Sections - General
						'front_page_general'      => array(
							'title'    => esc_html__( 'General', 'the-pipes' ),
							'desc'     => '',
							'priority' => 10,
							'type'     => 'section',
						),
						'front_page_general_info' => array(
							'title' => esc_html__( 'General settings for Front Page Builder', 'the-pipes' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'front_page_enabled'      => array(
							'title' => esc_html__( 'Enable Front Page builder', 'the-pipes' ),
							'desc'  => wp_kses_data( __( 'If Front Page Builder is off - native page content will be shown', 'the-pipes' ) ),
							'std'   => 0,
							'type'  => 'switch',
						),
						'front_page_sections'     => array(
							'title'      => esc_html__( 'Sections order', 'the-pipes' ),
							'desc'       => wp_kses_data( __( 'Drag and drop sections below to set up their order on the Front Page. You can also enable / disable any section.', 'the-pipes' ) ),
							'dependency' => array(
								'front_page_enabled' => array( 1 ),
							),
							'dir'        => 'vertical',
							'sortable'   => true,
							'std'        => '',
							'options'    => array(),
							'type'       => 'checklist',
						),
						'front_page_bg_image'     => array(
							'title'      => esc_html__( 'Background image', 'the-pipes' ),
							'desc'       => wp_kses_data( __( 'Select or upload background image for whole Front page', 'the-pipes' ) ),
							'refresh'    => false,
							'dependency' => array(
								'front_page_enabled' => array( 1 ),
							),
							'std'        => THE_PIPES_THEME_FREE ? the_pipes_get_file_url( 'front-page/images/bg.jpg' ) : '',
							'type'       => 'image',
						),
					)
				)
			);
		}
	}
}


// Close panel
if ( ! function_exists( 'the_pipes_front_page_options_close' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_close', 20 );
	function the_pipes_front_page_options_close( $options ) {
		return empty( $options ) || count( $options ) == 0
				? $options
				: array_merge(
						$options,
						array(
							'front_page_end' => array(
								'type' => 'panel_end',
							),
						)
					);
	}
}


// Add section 'Title' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_title' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_title' );
	function the_pipes_front_page_options_title( $options ) {

		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'title=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'title' => esc_html__( 'Big title', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Title
				'front_page_title'                 => array(
					'title'    => esc_html__( 'Title', 'the-pipes' ),
					'desc'     => '',
					'priority' => 20,
					'type'     => 'section',
				),
				'front_page_title_slider_info'     => array(
					'title' => esc_html__( 'Slider', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_title_shortcode'       => array(
					'title'     => esc_html__( 'Slider Shortcode', 'the-pipes' ),
					'desc'      => wp_kses_data( __( 'Paste a shortcode generated by any slider plugin. The slider will be used instead of the section title, description and buttons.', 'the-pipes' ) ),
					'translate' => true,
					'sanitize'  => 'wp_kses_post',
					'std'       => '',
					'type'      => 'text',
				),
				'front_page_title_layout_info'     => array(
					'title'      => esc_html__( 'Layout', 'the-pipes' ),
					'desc'       => '',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'info',
				),
				'front_page_title_fullheight'      => array(
					'title'      => esc_html__( 'Full height', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'        => 1,
					'refresh'    => false,
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'switch',
				),
				'front_page_title_stack'           => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_title_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_title_paddings'        => array(
					'title'      => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'        => 'large',
					'options'    => the_pipes_get_list_paddings(),
					'refresh'    => false,
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'choice',
				),
				'front_page_title_heading_info'    => array(
					'title'      => esc_html__( 'Title', 'the-pipes' ),
					'desc'       => '',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'info',
				),
				'front_page_title_caption'         => array(
					'title'      => esc_html__( 'Section title', 'the-pipes' ),
					'desc'       => '',
					'translate'  => true,
					'refresh'    => false, // To refresh part of the page: '.front_page_section_title .front_page_section_title_caption'
					'std'        => wp_kses_data( __( 'Section with Big title', 'the-pipes' ) ),
					'sanitize'   => 'wp_kses_post',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'text',
				),
				'front_page_title_description'     => array(
					'title'      => esc_html__( 'Description', 'the-pipes' ),
					'desc'       => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate'  => true,
					'refresh'    => false, // To refresh part of the page: '.front_page_section_title .front_page_section_title_description',
					'std'        => wp_kses_data( __( 'This text can be changed in the section "Title"', 'the-pipes' ) ),
					'sanitize'   => 'wp_kses_post',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'textarea',
				),
				'front_page_title_buttons_info'    => array(
					'title'      => esc_html__( 'Buttons', 'the-pipes' ),
					'desc'       => '',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'info',
				),
				'front_page_title_button1_link'    => array(
					'title'           => esc_html__( 'Button1 link', 'the-pipes' ),
					'desc'            => '',
					'refresh'         => '.front_page_section_title .front_page_section_title_button1',
					'refresh_wrapper' => true,
					'std'             => '#',
					'dependency'      => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'            => 'text',
				),
				'front_page_title_button1_caption' => array(
					'title'      => esc_html__( 'Button1 caption', 'the-pipes' ),
					'desc'       => '',
					'translate'  => true,
					'dependency' => array(
						'front_page_title_button1_link' => array( 'not_empty' ),
						'front_page_title_shortcode'    => array( 'is_empty' ),
					),
					'refresh'    => false,
					'std'        => wp_kses_data( __( 'Customize Button 1', 'the-pipes' ) ),
					'type'       => 'text',
				),
				'front_page_title_button2_link'    => array(
					'title'           => esc_html__( 'Button2 link', 'the-pipes' ),
					'desc'            => '',
					'refresh'         => '.front_page_section_title .front_page_section_title_button2',
					'refresh_wrapper' => true,
					'std'             => '#',
					'dependency'      => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'            => 'text',
				),
				'front_page_title_button2_caption' => array(
					'title'      => esc_html__( 'Button2 caption', 'the-pipes' ),
					'desc'       => '',
					'translate'  => true,
					'dependency' => array(
						'front_page_title_button2_link' => array( 'not_empty' ),
						'front_page_title_shortcode'    => array( 'is_empty' ),
					),
					'refresh'    => false,
					'std'        => wp_kses_data( __( 'Customize Button 2', 'the-pipes' ) ),
					'type'       => 'text',
				),
				'front_page_title_color_info'      => array(
					'title' => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_title_scheme'          => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_title_bg_image'        => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_title',
					'refresh_wrapper' => true,
					'std'             => THE_PIPES_THEME_FREE ? the_pipes_get_file_url( 'front-page/images/bg-title.jpg' ) : '',
					'type'            => 'image',
				),
				'front_page_title_bg_color_type'   => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_title_bg_color'        => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => THE_PIPES_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_title_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_title_bg_mask'         => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => THE_PIPES_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_title_anchor_info'     => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_title_anchor_icon'     => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_title_anchor_text'     => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Features' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_features' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_features' );
	function the_pipes_front_page_options_features( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'features=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'features' => esc_html__( 'Features', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Features
				'sidebar-widgets-front_page_features_widgets' => array(
					'title'    => esc_html__( 'Features', 'the-pipes' ),
					'desc'     => '',
					'priority' => 30,
					'type'     => 'section',
				),
				'front_page_features_layout_info'  => array(
					'title'    => esc_html__( 'Layout', 'the-pipes' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_features_fullheight'   => array(
					'title'    => esc_html__( 'Full height', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'switch',
				),
				'front_page_features_stack'        => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_features_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_features_paddings'     => array(
					'title'    => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'      => 'medium',
					'options'  => the_pipes_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'choice',
				),
				'front_page_features_heading_info' => array(
					'title'    => esc_html__( 'Title', 'the-pipes' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_features_caption'      => array(
					'title'     => esc_html__( 'Section title', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_features .front_page_section_features_caption',
					'std'       => wp_kses_data( __( 'Why our service is the best', 'the-pipes' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_features_description'  => array(
					'title'     => esc_html__( 'Description', 'the-pipes' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_features .front_page_section_features_description',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Features"', 'the-pipes' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_features_widgets_info' => array(
					'title'    => esc_html__( 'Widgets', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'You can set up widgets for this section in "Appearance - Customize" or "Appearance - Widgets" tabs.', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Insert your preferred widget to display services here. You can also select any other widget, thus changing the purpose of this section', 'the-pipes' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_features_color_info'   => array(
					'title'    => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_features_scheme'       => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_features_bg_image'     => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_features',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_features_bg_color_type' => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => 'scheme_bg_color',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_features_bg_color'     => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_features_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_features_bg_mask'      => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_features_anchor_info'  => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_features_anchor_icon'  => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_features_anchor_text'  => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'translate' => true,
					'desc'      => '',
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'About Us' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_about' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_about' );
	function the_pipes_front_page_options_about( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'about=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'about' => esc_html__( 'About Us', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - About
				'front_page_about'              => array(
					'title'    => esc_html__( 'About Us', 'the-pipes' ),
					'desc'     => '',
					'priority' => 40,
					'type'     => 'section',
				),
				'front_page_about_layout_info'  => array(
					'title' => esc_html__( 'Layout', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_about_fullheight'   => array(
					'title'   => esc_html__( 'Full height', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'     => 0,
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_about_stack'        => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_about_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_about_paddings'     => array(
					'title'   => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'     => 'medium',
					'options' => the_pipes_get_list_paddings(),
					'refresh' => false,
					'type'    => 'choice',
				),
				'front_page_about_heading_info' => array(
					'title' => esc_html__( 'Title', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_about_caption'      => array(
					'title'     => esc_html__( 'Section title', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_about .front_page_section_about_caption',
					'std'       => wp_kses_data( __( 'About Us', 'the-pipes' ) ),
					'type'      => 'text',
				),
				'front_page_about_description'  => array(
					'title'     => esc_html__( 'Description', 'the-pipes' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_about .front_page_section_about_description',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "About"', 'the-pipes' ) ),
					'type'      => 'textarea',
				),
				'front_page_about_content_info' => array(
					'title' => esc_html__( 'Content', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_about_content'      => array(
					'title'     => esc_html__( 'Content', 'the-pipes' ),
					'desc'      => wp_kses_data( __( 'The arbitrary content of the current section.', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data(
									__( 'Attention! You can use %%CONTENT%% to insert instead the content of the page, selected as the Front Page in the menu "Settings - Reading" or in the "Customize - Static Front Page"', 'the-pipes' )
								),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_about .front_page_section_about_content',
					'std'       => '',
					'teeny'     => false,
					'rows'      => 20,
					'type'      => 'text_editor',
				),
				'front_page_about_color_info'   => array(
					'title' => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_about_scheme'       => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_about_bg_image'     => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_about',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_about_bg_color_type'   => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_about_bg_color'        => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => THE_PIPES_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_about_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_about_bg_mask'      => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => THE_PIPES_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_about_anchor_info'  => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_about_anchor_icon'  => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_about_anchor_text'  => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Team' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_team' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_team' );
	function the_pipes_front_page_options_team( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'team=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'team' => esc_html__( 'Our Team', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Team
				'sidebar-widgets-front_page_team_widgets' => array(
					'title'    => esc_html__( 'Team members', 'the-pipes' ),
					'desc'     => '',
					'priority' => 50,
					'type'     => 'section',
				),
				'front_page_team_layout_info'             => array(
					'title'    => esc_html__( 'Layout', 'the-pipes' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_team_fullheight'              => array(
					'title'    => esc_html__( 'Full height', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'switch',
				),
				'front_page_team_stack'                   => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_team_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_team_paddings'                => array(
					'title'    => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'      => 'medium',
					'options'  => the_pipes_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'choice',
				),
				'front_page_team_heading_info'            => array(
					'title'    => esc_html__( 'Title', 'the-pipes' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_team_caption'                 => array(
					'title'     => esc_html__( 'Section title', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_team .front_page_section_team_caption',
					'std'       => wp_kses_data( __( 'Meet our team', 'the-pipes' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_team_description'             => array(
					'title'     => esc_html__( 'Description', 'the-pipes' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_team .front_page_section_team_description',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Team members"', 'the-pipes' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_team_widgets_info'            => array(
					'title'    => esc_html__( 'Widgets', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'You can set up widgets for this section in "Appearance - Customize" or "Appearance - Widgets" tabs.', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Insert your preferred widget to display team members here. You can also select any other widget, thus changing the purpose of this section', 'the-pipes' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_team_color_info'              => array(
					'title'    => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_team_scheme'                  => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_team_bg_image'                => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_team',
					'refresh_wrapper' => true,
					'std'             => THE_PIPES_THEME_FREE ? the_pipes_get_file_url( 'front-page/images/bg-team.jpg' ) : '',
					'type'            => 'image',
				),
				'front_page_team_bg_color_type'           => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_team_bg_color'                => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => THE_PIPES_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_team_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_team_bg_mask'                 => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => THE_PIPES_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_team_anchor_info'             => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_team_anchor_icon'             => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_team_anchor_text'             => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Testimonials' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_testimonials' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_testimonials' );
	function the_pipes_front_page_options_testimonials( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'testimonials=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'testimonials' => esc_html__( 'Testimonials', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Testimonials
				'sidebar-widgets-front_page_testimonials_widgets' => array(
					'title'    => esc_html__( 'Testimonials', 'the-pipes' ),
					'desc'     => '',
					'priority' => 60,
					'type'     => 'section',
				),
				'front_page_testimonials_layout_info'  => array(
					'title'    => esc_html__( 'Layout', 'the-pipes' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_testimonials_fullheight'   => array(
					'title'    => esc_html__( 'Full height', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'switch',
				),
				'front_page_testimonials_stack'           => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_testimonials_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_testimonials_paddings'     => array(
					'title'    => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'      => 'medium',
					'options'  => the_pipes_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'choice',
				),
				'front_page_testimonials_heading_info' => array(
					'title'    => esc_html__( 'Title', 'the-pipes' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_testimonials_caption'      => array(
					'title'     => esc_html__( 'Section title', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_testimonials .front_page_section_testimonials_caption',
					'std'       => wp_kses_data( __( 'What our clients say', 'the-pipes' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_testimonials_description'  => array(
					'title'     => esc_html__( 'Description', 'the-pipes' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_testimonials .front_page_section_testimonials_description',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Testimonials"', 'the-pipes' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_testimonials_widgets_info' => array(
					'title'    => esc_html__( 'Widgets', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'You can set up widgets for this section in "Appearance - Customize" or "Appearance - Widgets" tabs.', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Insert your preferred widget to display testimonials here. You can also select any other widget, thus changing the purpose of this section', 'the-pipes' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_testimonials_color_info'   => array(
					'title'    => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_testimonials_scheme'       => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_testimonials_bg_image'     => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_testimonials',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_testimonials_bg_color_type' => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => 'scheme_bg_color',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_testimonials_bg_color'     => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_testimonials_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_testimonials_bg_mask'      => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_testimonials_anchor_info'  => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_testimonials_anchor_icon'  => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_testimonials_anchor_text'  => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Latest posts' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_blog' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_blog' );
	function the_pipes_front_page_options_blog( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'blog=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'blog' => esc_html__( 'Latest posts', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Blog (Latest posts)
				'sidebar-widgets-front_page_blog_widgets' => array(
					'title'    => esc_html__( 'Latest posts', 'the-pipes' ),
					'desc'     => '',
					'priority' => 70,
					'type'     => 'section',
				),
				'front_page_blog_layout_info'             => array(
					'title'    => esc_html__( 'Layout', 'the-pipes' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_blog_fullheight'              => array(
					'title'    => esc_html__( 'Full height', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'switch',
				),
				'front_page_blog_stack'                   => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_blog_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_blog_paddings'                => array(
					'title'    => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'      => 'medium',
					'options'  => the_pipes_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'choice',
				),
				'front_page_blog_heading_info'            => array(
					'title'    => esc_html__( 'Title', 'the-pipes' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_blog_caption'                 => array(
					'title'     => esc_html__( 'Section title', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_blog .front_page_section_blog_caption',
					'std'       => wp_kses_data( __( 'Latest posts', 'the-pipes' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_blog_description'             => array(
					'title'     => esc_html__( 'Description', 'the-pipes' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_blog .front_page_section_blog_description',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Latest posts"', 'the-pipes' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_blog_widgets_info'            => array(
					'title'    => esc_html__( 'Widgets', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'You can set up widgets for this section in "Appearance - Customize" or "Appearance - Widgets" tabs.', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Insert your preferred widget to display latest posts here. You can also select any other widget, thus changing the purpose of this section', 'the-pipes' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_blog_color_info'              => array(
					'title'    => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_blog_scheme'                  => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_blog_bg_image'                => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_blog',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_blog_bg_color_type'           => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_blog_bg_color'                => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => THE_PIPES_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_blog_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_blog_bg_mask'                 => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => THE_PIPES_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_blog_anchor_info'             => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_blog_anchor_icon'             => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_blog_anchor_text'             => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Subscribe' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_subscribe' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_subscribe' );
	function the_pipes_front_page_options_subscribe( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'subscribe=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'subscribe' => esc_html__( 'Subscribe', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Subscribe
				'front_page_subscribe'                => array(
					'title'    => esc_html__( 'Subscribe', 'the-pipes' ),
					'desc'     => '',
					'priority' => 80,
					'type'     => 'section',
				),
				'front_page_subscribe_layout_info'    => array(
					'title' => esc_html__( 'Layout', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_subscribe_fullheight'     => array(
					'title'   => esc_html__( 'Full height', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'     => 0,
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_subscribe_stack'          => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_subscribe_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_subscribe_paddings'       => array(
					'title'   => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'     => 'medium',
					'options' => the_pipes_get_list_paddings(),
					'refresh' => false,
					'type'    => 'choice',
				),
				'front_page_subscribe_heading_info'   => array(
					'title' => esc_html__( 'Title', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_subscribe_caption'        => array(
					'title'     => esc_html__( 'Section title', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_subscribe .front_page_section_subscribe_caption',
					'std'       => wp_kses_data( __( 'Subscribe to our Newsletter', 'the-pipes' ) ),
					'type'      => 'text',
				),
				'front_page_subscribe_description'    => array(
					'title'     => esc_html__( 'Description', 'the-pipes' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_subscribe .front_page_section_subscribe_description',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Subscribe"', 'the-pipes' ) ),
					'type'      => 'textarea',
				),
				'front_page_subscribe_shortcode_info' => array(
					'title' => esc_html__( 'Shortcode', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_subscribe_shortcode'      => array(
					'title'     => esc_html__( 'Shortcode to insert Subscribe form', 'the-pipes' ),
					'desc'      => wp_kses_data( __( 'Paste shortcode, generated with any subscribe plugin (for example, MailChimp)', 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => '.front_page_section_subscribe .front_page_section_subscribe_output',
					'std'       => '',
					'type'      => 'text',
				),
				'front_page_subscribe_color_info'     => array(
					'title' => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_subscribe_scheme'         => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_subscribe_bg_image'       => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_subscribe',
					'refresh_wrapper' => true,
					'std'             => THE_PIPES_THEME_FREE ? the_pipes_get_file_url( 'front-page/images/bg-subscribe.jpg' ) : '',
					'type'            => 'image',
				),
				'front_page_subscribe_bg_color_type'  => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_subscribe_bg_color'       => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => THE_PIPES_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_subscribe_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_subscribe_bg_mask'        => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => THE_PIPES_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_subscribe_anchor_info'    => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_subscribe_anchor_icon'    => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_subscribe_anchor_text'    => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Google map' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_googlemap' ) ) {
	if ( ! THE_PIPES_THEME_FREE ) {
		add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_googlemap' );
	}
	function the_pipes_front_page_options_googlemap( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'googlemap=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'googlemap' => esc_html__( 'Google map', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Google map
				'sidebar-widgets-front_page_googlemap_widgets' => array(
					'title'    => esc_html__( 'Google map', 'the-pipes' ),
					'desc'     => '',
					'priority' => 90,
					'type'     => 'section',
				),
				'front_page_googlemap_layout_info'  => array(
					'title'    => esc_html__( 'Layout', 'the-pipes' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_googlemap_fullheight'   => array(
					'title'    => esc_html__( 'Full height', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'switch',
				),
				'front_page_googlemap_stack'        => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_googlemap_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_googlemap_paddings'     => array(
					'title'    => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'      => 'medium',
					'options'  => the_pipes_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'choice',
				),
				'front_page_googlemap_layout'       => array(
					'title'           => esc_html__( 'Layout', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select layout of this section', 'the-pipes' ) ),
					'std'             => 'fullwidth',
					'options'         => array(
						'fullwidth' => esc_html__( 'Fullwidth', 'the-pipes' ),
						'boxed'     => esc_html__( 'Boxed', 'the-pipes' ),
						'columns'   => esc_html__( '2 columns', 'the-pipes' ),
					),
					'refresh'         => '.front_page_section_googlemap',
					'refresh_wrapper' => true,
					'priority'        => -95,
					'type'            => 'radio',
				),
				'front_page_googlemap_heading_info' => array(
					'title'    => esc_html__( 'Title', 'the-pipes' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_googlemap_caption'      => array(
					'title'     => esc_html__( 'Section title', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_googlemap .front_page_section_googlemap_caption',
					'std'       => wp_kses_data( __( 'Google map', 'the-pipes' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_googlemap_description'  => array(
					'title'     => esc_html__( 'Description', 'the-pipes' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_googlemap .front_page_section_googlemap_description',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Google map"', 'the-pipes' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_googlemap_content'      => array(
					'title'     => esc_html__( 'Content', 'the-pipes' ),
					'desc'      => wp_kses_data( __( 'Any text at the left side of the map', 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_googlemap .front_page_section_googlemap_content',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Google map"', 'the-pipes' ) ),
					'priority'  => -65,
					'type'      => 'text_editor',
				),
				'front_page_googlemap_widgets_info' => array(
					'title'    => esc_html__( 'Widgets', 'the-pipes' ),
					'desc'     => wp_kses_data( __( 'You can set up widgets for this section in "Appearance - Customize" or "Appearance - Widgets" tabs.', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Insert your preferred widget to display the map with the location of your choice here. You can also select any other widget, thus changing the purpose of this section', 'the-pipes' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_googlemap_color_info'   => array(
					'title'    => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_googlemap_scheme'       => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_googlemap_bg_image'     => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_googlemap',
					'refresh_wrapper' => true,
					'std'             => THE_PIPES_THEME_FREE ? the_pipes_get_file_url( 'front-page/images/bg-googlemap.jpg' ) : '',
					'type'            => 'image',
				),
				'front_page_googlemap_bg_color_type' => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_googlemap_bg_color'     => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => THE_PIPES_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_googlemap_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_googlemap_bg_mask'      => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => THE_PIPES_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_googlemap_anchor_info'  => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_googlemap_anchor_icon'  => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_googlemap_anchor_text'  => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Contact Us' to the Front Page option
if ( ! function_exists( 'the_pipes_front_page_options_contacts' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_contacts' );
	function the_pipes_front_page_options_contacts( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'contacts=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'contacts' => esc_html__( 'Contact Us', 'the-pipes' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Contact Us
				'sidebar-widgets-front_page_contacts_widgets' => array(
					'title'    => esc_html__( 'Contact Us', 'the-pipes' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'section',
				),
				'front_page_contacts_layout_info'    => array(
					'title' => esc_html__( 'Layout', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_contacts_fullheight'     => array(
					'title'   => esc_html__( 'Full height', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Stretch this section to the window height', 'the-pipes' ) ),
					'std'     => 0,
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_contacts_stack'          => array(
					'title'      => esc_html__( 'Stack this section', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'the-pipes' ) ),
					'std'        => 0,
					'refresh'    => false,
					'dependency' => array(
						'front_page_contacts_fullheight' => array( 1 ),
					),
					'type'       => 'switch',
				),
				'front_page_contacts_paddings'       => array(
					'title'   => esc_html__( 'Paddings', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Select paddings inside this section', 'the-pipes' ) ),
					'std'     => 'medium',
					'options' => the_pipes_get_list_paddings(),
					'refresh' => false,
					'type'    => 'choice',
				),
				'front_page_contacts_layout'         => array(
					'title'           => esc_html__( 'Layout', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select layout of this section', 'the-pipes' ) ),
					'std'             => 'columns',
					'options'         => array(
						'boxed'   => esc_html__( 'Boxed', 'the-pipes' ),
						'columns' => esc_html__( '2 columns', 'the-pipes' ),
					),
					'refresh'         => '.front_page_section_contacts',
					'refresh_wrapper' => true,
					'type'            => 'radio',
				),
				'front_page_contacts_heading_info'   => array(
					'title' => esc_html__( 'Title', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_contacts_caption'        => array(
					'title'     => esc_html__( 'Section title', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_contacts .front_page_section_contacts_caption',
					'std'       => wp_kses_data( __( 'Contact Us', 'the-pipes' ) ),
					'type'      => 'text',
				),
				'front_page_contacts_description'    => array(
					'title'     => esc_html__( 'Description', 'the-pipes' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => false, // To refresh part of the page: '.front_page_section_contacts .front_page_section_contacts_description',
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Contact Us"', 'the-pipes' ) ),
					'type'      => 'textarea',
				),
				'front_page_contacts_content'        => array(
					'title'   => esc_html__( 'Content', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Any text at the left side of the form', 'the-pipes' ) ),
					'refresh' => false, // To refresh part of the page: '.front_page_section_contacts .front_page_section_contacts_content',
					'std'     => wp_kses( __( '<h5><span class="icon-home-2"> </span>Find us at the office:</h5><p>500, Lorem Street,<br />Chicago, IL, 55030<br />Mon - Fri, 09:00 - 18:00</p><h5> <span class="icon-mobile-light"> </span>Give us a call:</h5><p>Michael Jordan<br />+40 (123) 456-78-90<br />Mon - Fri, 08:00 - 22:00</p>', 'the-pipes' ), 'the_pipes_kses_content' ),
					'type'    => 'text_editor',
				),
				'front_page_contacts_shortcode_info' => array(
					'title' => esc_html__( 'Shortcode', 'the-pipes' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_contacts_shortcode'      => array(
					'title'     => esc_html__( 'Shortcode with contact form', 'the-pipes' ),
					'desc'      => wp_kses_data( __( 'Paste shortcode, generated with any form plugin (for example, Contacts Form 7). You can also paste any other shortcodes, changing thus the purpose of this section', 'the-pipes' ) ),
					'translate' => true,
					'refresh'   => '.front_page_section_contacts .front_page_section_contacts_output',
					'std'       => '',
					'type'      => 'text',
				),
				'front_page_contacts_color_info'     => array(
					'title'    => esc_html__( 'Colors and images', 'the-pipes' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_contacts_scheme'         => array(
					'title'   => esc_html__( 'Color scheme', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'radio',
				),
				'front_page_contacts_bg_image'       => array(
					'title'           => esc_html__( 'Background image', 'the-pipes' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'the-pipes' ) ),
					'refresh'         => '.front_page_section_contacts',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_contacts_bg_color_type'  => array(
					'title'   => esc_html__( 'Background color', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'the-pipes' ) ),
					'std'     => THE_PIPES_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'the-pipes' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'the-pipes' ),
						'custom'          => esc_html__( 'Custom', 'the-pipes' ),
					),
					'type'    => 'radio',
				),
				'front_page_contacts_bg_color'       => array(
					'title'      => esc_html__( 'Custom color', 'the-pipes' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'the-pipes' ) ),
					'std'        => THE_PIPES_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_contacts_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_contacts_bg_mask'        => array(
					'title'   => esc_html__( 'Background mask', 'the-pipes' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'the-pipes' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => THE_PIPES_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_contacts_anchor_info'    => array(
					'title' => esc_html__( 'Anchor', 'the-pipes' ),
					'desc'  => wp_kses_data( __( 'You can select an icon and/or specify a text to create an anchor for this section to display it in the side menu (if selected in the section "Header - Menu").', 'the-pipes' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors are available only if ThemeREX Addons plugin is installed and activated!', 'the-pipes' ) ),
					'type'  => 'info',
				),
				'front_page_contacts_anchor_icon'    => array(
					'title' => esc_html__( 'Anchor icon', 'the-pipes' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_contacts_anchor_text'    => array(
					'title'     => esc_html__( 'Anchor text', 'the-pipes' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}

// Add 'active_callback' to all Front Page options
if ( ! function_exists( 'the_pipes_front_page_options_add_active_callback' ) ) {
	add_filter( 'the_pipes_filter_front_page_options', 'the_pipes_front_page_options_add_active_callback', 1000 );
	function the_pipes_front_page_options_add_active_callback( $options ) {
		foreach ( $options as $k => $v ) {
			if ( substr( $k, 0, 11 ) == 'front_page_' ) {
				$options[ $k ]['active_callback'] = 'the_pipes_front_page_check';
			}
		}
		return $options;
	}
}

// Callback to show/hide Front Page sections in the WP Customizer
if ( ! function_exists( 'the_pipes_front_page_check' ) ) {
	function the_pipes_front_page_check( $control = null ) {
		return true;    // Condition like "is_front_page() && !is_home()" is not used, because preview area is redirected to the home page when 'front_page' panel is opened
	}
}

// Add Front Page specific items to the list of sidebars
//------------------------------------------------------------------------
if ( ! function_exists( 'the_pipes_front_page_sidebars' ) ) {
	//Handler of the add_filter( 'the_pipes_filter_list_sidebars', 'the_pipes_front_page_sidebars' );
	function the_pipes_front_page_sidebars( $list = array() ) {
		$list['front_page_features_widgets']     = array(
			'name'               => wp_kses_data( __( 'Front Page section "Features"', 'the-pipes' ) ),
			'description'        => wp_kses_data( __( 'Widgets to be shown only in the section "Features" on the front page', 'the-pipes' ) ),
			'front_page_section' => true,
		);
		$list['front_page_team_widgets']         = array(
			'name'               => wp_kses_data( __( 'Front Page section "Team members"', 'the-pipes' ) ),
			'description'        => wp_kses_data( __( 'Widgets to be shown only in the section "Team members" on the front page', 'the-pipes' ) ),
			'front_page_section' => true,
		);
		$list['front_page_testimonials_widgets'] = array(
			'name'               => wp_kses_data( __( 'Front Page section "Testimonials"', 'the-pipes' ) ),
			'description'        => wp_kses_data( __( 'Widgets to be shown only in the section "Testimonials" on the front page', 'the-pipes' ) ),
			'front_page_section' => true,
		);
		$list['front_page_blog_widgets']         = array(
			'name'               => wp_kses_data( __( 'Front Page section "Latest Posts"', 'the-pipes' ) ),
			'description'        => wp_kses_data( __( 'Widgets to be shown only in the section "Latest Posts" on the front page', 'the-pipes' ) ),
			'front_page_section' => true,
		);
		if ( ! THE_PIPES_THEME_FREE ) {
			$list['front_page_googlemap_widgets'] = array(
				'name'               => wp_kses_data( __( 'Front Page section "Google map"', 'the-pipes' ) ),
				'description'        => wp_kses_data( __( 'Widgets to be shown only in the section "Google map" on the front page', 'the-pipes' ) ),
				'front_page_section' => true,
			);
		}
		return $list;
	}
}




//====================================================================
//== Refresh partials on the Front Page
//====================================================================


// Partial refresh whole section
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_section' ) ) {
	function the_pipes_customizer_partial_refresh_section( $section ) {
		ob_start();
		get_template_part( apply_filters( 'the_pipes_filter_get_template_part', "front-page/section-" . sanitize_file_name( $section ) ) );
		$output = ob_get_contents();
		ob_end_clean();
		return the_pipes_customizer_partial_refresh_add_init_script( $output, $section );
	}
}


// Add init script to the section's html output
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_add_init_script' ) ) {
	function the_pipes_customizer_partial_refresh_add_init_script( $output, $section ) {
		return sprintf(
			"%1$s<%2$s>
						setTimeout(function() {
							jQuery(document).trigger( 'action.init_hidden_elements', [jQuery('.front_page_section_{$section}')] );
						}, 500);
					</%2$s>", $output, 'script'
		);
	}
}


// Section 'Front Page - Title'
//--------------------------------------------------------------------

// Button1 link
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_title_button1_link' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_title_button1_link() {
		return the_pipes_get_theme_option( 'front_page_title_button1_link' ) != ''
				? '<a href="' . esc_url( the_pipes_get_theme_option( 'front_page_title_button1_link' ) ) . '" class="theme_button front_page_section_button front_page_section_title_button1">'
					. esc_html( the_pipes_get_theme_option( 'front_page_title_button1_caption' ) )
					. '</a>'
				: '';
	}
}

// Button2 link
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_title_button2_link' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_title_button2_link() {
		return the_pipes_get_theme_option( 'front_page_title_button2_link' ) != ''
				? '<a href="' . esc_url( the_pipes_get_theme_option( 'front_page_title_button2_link' ) ) . '" class="theme_button color_style_link2 front_page_section_button front_page_section_title_button2">'
					. esc_html( the_pipes_get_theme_option( 'front_page_title_button2_caption' ) )
					. '</a>'
				: '';
	}
}

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_title_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_title_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'title' );
	}
}


// Section 'Front Page - About'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_about_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_about_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'about' );
	}
}


// Section 'Front Page - Features'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_features_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_features_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'features' );
	}
}


// Section 'Front Page - Team'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_team_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_team_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'team' );
	}
}


// Section 'Front Page - Testimonials'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_testimonials_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_testimonials_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'testimonials' );
	}
}


// Section 'Front Page - Latest posts'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_blog_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_blog_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'blog' );
	}
}


// Section 'Front Page - Subscribe'
//--------------------------------------------------------------------

// Shortcode changed
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_subscribe_shortcode' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_subscribe_shortcode() {
		$the_pipes_sc = the_pipes_get_theme_option( 'front_page_subscribe_shortcode' );
		return ! empty( $the_pipes_sc ) ? do_shortcode( $the_pipes_sc ) : '';
	}
}

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_subscribe_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_subscribe_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'subscribe' );
	}
}


// Section 'Front Page - Google map'
//--------------------------------------------------------------------

// Layout
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_googlemap_layout' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_googlemap_layout() {
		return the_pipes_customizer_partial_refresh_section( 'googlemap' );
	}
}

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_googlemap_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_googlemap_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'googlemap' );
	}
}


// Section 'Front Page - Contact Us'
//--------------------------------------------------------------------

// Layout
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_contacts_layout' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_contacts_layout() {
		return the_pipes_customizer_partial_refresh_section( 'contacts' );
	}
}

// Shortcode changed
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_contacts_shortcode' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_contacts_shortcode() {
		$the_pipes_sc = the_pipes_get_theme_option( 'front_page_contacts_shortcode' );
		return ! empty( $the_pipes_sc ) ? do_shortcode( $the_pipes_sc ) : '';
	}
}

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_contacts_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_contacts_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'contacts' );
	}
}


// Section 'Front Page - WooCommerce'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'the_pipes_customizer_partial_refresh_front_page_woocommerce_bg_image' ) ) {
	function the_pipes_customizer_partial_refresh_front_page_woocommerce_bg_image() {
		return the_pipes_customizer_partial_refresh_section( 'woocommerce' );
	}
}


// Front Page styles
//--------------------------------------------------------------------

// Enqueue styles for frontend
if ( !function_exists( 'the_pipes_front_page_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'the_pipes_front_page_frontend_scripts', 1100 );
	function the_pipes_front_page_frontend_scripts() {
		if ( the_pipes_get_theme_setting( 'allow_front_page_builder', true )
			&& is_front_page()
			&& ! is_home()
			&& get_option( 'show_on_front' ) == 'page'
			&& the_pipes_is_on( the_pipes_get_theme_option( 'front_page_enabled', false ) )
		) {
			$the_pipes_url = the_pipes_get_file_url( 'front-page/front-page.css' );
			if ( '' != $the_pipes_url ) {
				wp_enqueue_style( 'the-pipes-front-page',  $the_pipes_url, array(), null );
			}
			$the_pipes_url = the_pipes_get_file_url( 'front-page/front-page-responsive.css' );
			if ( '' != $the_pipes_url ) {
				wp_enqueue_style( 'the-pipes-front-page-responsive',  $the_pipes_url, array(), null, the_pipes_media_for_load_css_responsive( 'front-page' ) );
			}
		}
	}
}
