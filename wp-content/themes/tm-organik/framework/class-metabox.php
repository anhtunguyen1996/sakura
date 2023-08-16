<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Insight Metabox
 *
 * @package   InsightFramework
 * @since     0.9.8
 */
class Insight_Metabox {

	/**
	 * Insight_Metabox constructor.
	 */
	public function __construct() {
		// Add metabox for page
		add_filter( 'insight_core_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_filter( 'insight_page_meta_box_presets', array( $this, 'page_meta_box_presets' ) );
	}

	public function page_meta_box_presets( $presets ) {
		$presets[] = 'settings_preset';

		return $presets;
	}

	/**
	 * Register Metabox
	 *
	 * @param $meta_boxes
	 *
	 * @return array
	 */
	public function register_meta_boxes( $meta_boxes ) {
		$meta_boxes[] = array(
			'id'         => 'insight_page_options',
			'title'      => esc_html__( 'Page Options', 'tm-organik' ),
			'post_types' => array( 'page', 'post' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields'     => array(
				array(
					'type'  => 'tabpanel',
					'items' => array(
						array(
							'title'  => esc_attr__( 'Settings Preset', 'tm-organik' ),
							'fields' => array(
								array(
									'id'      => 'settings_preset_message',
									'type'    => 'message',
									'title'   => esc_html__( 'Notice', 'tm-organik' ),
									'message' => esc_html__( 'This setting applies to demo homepage only. You should set this setting to "none" to use your own settings from Customize.', 'tm-organik' ),
								),
								array(
									'id'      => 'settings_preset',
									'type'    => 'select',
									'title'   => esc_html__( 'Settings Preset', 'tm-organik' ),
									'desc'    => esc_html__( 'Select a settings preset for this page. This setting mixed display different colors and fonts.', 'tm-organik' ),
									'options' => array(
										'-1' => esc_attr__( 'None', 'tm-organik' ),
										'01' => esc_attr__( 'Settings Preset 01', 'tm-organik' ),
										'02' => esc_attr__( 'Settings Preset 02', 'tm-organik' ),
									),
									'default' => '-1',
								),
							),
						),
						array(
							'title'  => esc_html__( 'Layout', 'tm-organik' ),
							'icon'   => 'dashicons-layout',
							'fields' => array(
								array(
									'id'      => 'page_layout',
									'type'    => 'switch',
									'title'   => esc_html__( 'Page layout', 'tm-organik' ),
									'default' => 'default',
									'options' => array(
										'default'         => esc_html__( 'Default', 'tm-organik' ),
										'fullwidth'       => esc_html__( 'Fullwidth', 'tm-organik' ),
										'content-sidebar' => esc_html__( 'Content - Sidebar', 'tm-organik' ),
										'sidebar-content' => esc_html__( 'Sidebar - Content', 'tm-organik' ),
									),
								),
								array(
									'id'      => 'page_padding',
									'type'    => 'switch',
									'title'   => esc_html__( 'Padding top & bottom', 'tm-organik' ),
									'desc'    => esc_html__( 'If choose yes, the page content will have the padding top & bottom is 60px', 'tm-organik' ),
									'default' => 'yes',
									'options' => array(
										'no'  => esc_html__( 'No', 'tm-organik' ),
										'yes' => esc_html__( 'Yes', 'tm-organik' )
									),
								),
								array(
									'id'    => 'body_class',
									'type'  => 'text',
									'title' => esc_html__( 'Body class', 'tm-organik' ),
								),
							),
						),
						array(
							'title'  => esc_html__( 'Header', 'tm-organik' ),
							'icon'   => 'dashicons-welcome-widgets-menus',
							'fields' => array(
								array(
									'id'      => 'menu_display',
									'type'    => 'select',
									'title'   => esc_html__( 'Primary menu', 'tm-organik' ),
									'default' => '',
									'options' => Insight_Helper::get_all_menus(),
								),
								array(
									'id'      => 'custom_logo',
									'type'    => 'media',
									'title'   => esc_attr__( 'Custom logo', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'custom_sticky_logo',
									'type'    => 'media',
									'title'   => esc_attr__( 'Custom sticky header logo', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'custom_mobile_logo',
									'type'    => 'media',
									'title'   => esc_attr__( 'Custom mobile logo', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'overlay_header',
									'type'    => 'switch',
									'title'   => esc_html__( 'Overlay header', 'tm-organik' ),
									'default' => 'no',
									'options' => array(
										'yes' => esc_html__( 'Yes', 'tm-organik' ),
										'no'  => esc_html__( 'No', 'tm-organik' ),
									),
								),
							),
						),
						array(
							'title'  => esc_html__( 'Title & Breadcrumbs', 'tm-organik' ),
							'icon'   => 'dashicons-welcome-widgets-menus',
							'fields' => array(
								array(
									'id'      => 'title_visibility',
									'title'   => esc_html__( 'Title visibility', 'tm-organik' ),
									'type'    => 'switch',
									'default' => 'visible',
									'options' => array(
										'visible' => esc_html__( 'Visible', 'tm-organik' ),
										'hidden'  => esc_html__( 'Hidden', 'tm-organik' ),
									),
								),
								array(
									'id'      => 'custom_title',
									'type'    => 'text',
									'title'   => esc_attr__( 'Custom title', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'custom_title_bg_color',
									'type'    => 'color',
									'title'   => esc_attr__( 'Custom title background color', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'custom_title_bg_image',
									'type'    => 'media',
									'title'   => esc_attr__( 'Custom title background image', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'breadcrumbs_visibility',
									'type'    => 'switch',
									'title'   => esc_html__( 'Breadcrumbs visibility', 'tm-organik' ),
									'default' => 'default',
									'options' => array(
										'default' => esc_html__( 'Default', 'tm-organik' ),
										'visible' => esc_html__( 'Visible', 'tm-organik' ),
										'hidden'  => esc_html__( 'Hidden', 'tm-organik' ),
									),
								),
							),
						),
						array(
							'title'  => esc_attr__( 'Sidebars', 'tm-organik' ),
							'icon'   => 'dashicons-index-card',
							'fields' => array(
								array(
									'id'      => 'page_sidebar',
									'type'    => 'select',
									'title'   => esc_html__( 'Page sidebar', 'tm-organik' ),
									'desc'    => esc_html__( 'Choose a custom sidebar for your page', 'tm-organik' ),
									'default' => 'default',
									'options' => Insight_Helper::get_registered_sidebars( true ),
								),
							),
						),
						array(
							'title'  => esc_attr__( 'Footer', 'tm-organik' ),
							'icon'   => 'dashicons-feedback',
							'fields' => array(
								array(
									'id'      => 'footer_visibility',
									'title'   => esc_html__( 'Footer visibility', 'tm-organik' ),
									'type'    => 'switch',
									'default' => 'default',
									'options' => array(
										'default' => esc_html__( 'Default', 'tm-organik' ),
										'visible' => esc_html__( 'Visible', 'tm-organik' ),
										'hidden'  => esc_html__( 'Hidden', 'tm-organik' ),
									),
								),
								array(
									'id'      => 'copyright_visibility',
									'title'   => esc_html__( 'Copyright visibility', 'tm-organik' ),
									'type'    => 'switch',
									'default' => 'default',
									'options' => array(
										'default' => esc_html__( 'Default', 'tm-organik' ),
										'visible' => esc_html__( 'Visible', 'tm-organik' ),
										'hidden'  => esc_html__( 'Hidden', 'tm-organik' ),
									),
								),
							),
						),
					),
				),
			),
		);

		$meta_boxes[] = array(
			'id'         => 'insight_page_options',
			'title'      => esc_html__( 'Product Options', 'tm-organik' ),
			'post_types' => array( 'product' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'fields'     => array(
				array(
					'type'  => 'tabpanel',
					'items' => array(
						array(
							'title'  => esc_html__( 'Layout', 'tm-organik' ),
							'icon'   => 'dashicons-layout',
							'fields' => array(
								array(
									'id'      => 'page_layout',
									'type'    => 'switch',
									'title'   => esc_html__( 'Page layout', 'tm-organik' ),
									'default' => 'default',
									'options' => array(
										'default'         => esc_html__( 'Default', 'tm-organik' ),
										'fullwidth'       => esc_html__( 'Fullwidth', 'tm-organik' ),
										'content-sidebar' => esc_html__( 'Content - Sidebar', 'tm-organik' ),
										'sidebar-content' => esc_html__( 'Sidebar - Content', 'tm-organik' ),
									),
								),
								array(
									'id'    => 'body_class',
									'type'  => 'text',
									'title' => esc_html__( 'Body class', 'tm-organik' ),
								),
							),
						),
						array(
							'title'  => esc_html__( 'Title & Breadcrumbs', 'tm-organik' ),
							'icon'   => 'dashicons-welcome-widgets-menus',
							'fields' => array(
								array(
									'id'      => 'title_visibility',
									'title'   => esc_html__( 'Title visibility', 'tm-organik' ),
									'type'    => 'switch',
									'default' => 'visible',
									'options' => array(
										'visible' => esc_html__( 'Visible', 'tm-organik' ),
										'hidden'  => esc_html__( 'Hidden', 'tm-organik' ),
									),
								),
								array(
									'id'      => 'custom_title',
									'type'    => 'text',
									'title'   => esc_attr__( 'Custom title', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'custom_title_bg_color',
									'type'    => 'color',
									'title'   => esc_attr__( 'Custom title background color', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'custom_title_bg_image',
									'type'    => 'media',
									'title'   => esc_attr__( 'Custom title background image', 'tm-organik' ),
									'default' => '',
								),
								array(
									'id'      => 'breadcrumbs_visibility',
									'type'    => 'switch',
									'title'   => esc_html__( 'Breadcrumbs visibility', 'tm-organik' ),
									'default' => 'default',
									'options' => array(
										'default' => esc_html__( 'Default', 'tm-organik' ),
										'visible' => esc_html__( 'Visible', 'tm-organik' ),
										'hidden'  => esc_html__( 'Hidden', 'tm-organik' ),
									),
								),
							),
						),
					),
				),
			),
		);

		return $meta_boxes;
	}

}
