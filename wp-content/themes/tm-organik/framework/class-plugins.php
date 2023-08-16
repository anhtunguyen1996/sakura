<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin installation and activation for WordPress themes
 *
 * @package InsightFramework
 * @since   0.9.7
 */
class Insight_Register_Plugins {

	/**
	 * Insight_Register_Plugins constructor.
	 */
	public function __construct() {
		add_filter( 'insight_core_tgm_plugins', array( $this, 'register_required_plugins' ) );
	}

	public function register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'     => esc_html__( 'Insight Core', 'tm-organik' ),
				'slug'     => 'insight-core',
				'source'   => 'https://api.thememove.com/download/insight-core-1.7.7-lALprVbxHG.zip',
				'version'  => '1.7.7',
				'required' => true,
			),
			array(
				'name'     => esc_html__( 'WPBakery Page Builder', 'tm-organik' ),
				'slug'     => 'js_composer',
				'source'   => 'https://api.thememove.com/download/js_composer-6.5.0-GTz1qxX6Xb.zip',
				'version'  => '6.5.0',
				'required' => true,
			),
			array(
				'name'     => esc_html__( 'Revolution Slider', 'tm-organik' ),
				'slug'     => 'revslider',
				'source'   => 'https://api.thememove.com/download/revslider-6.3.3-1PC2kN8bFm.zip',
				'version'  => '6.3.3',
				'required' => true,
			),
			array(
				'name'     => esc_html__( 'WPBakery Page Builder (Visual Composer) Clipboard', 'tm-organik' ),
				'slug'     => 'vc_clipboard',
				'source'   => 'https://api.thememove.com/download/vc_clipboard-4.5.7-6x4EjSaacf.zip',
				'version'  => '4.5.7',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'WooCommerce', 'tm-organik' ),
				'slug'     => 'woocommerce',
				'required' => true,
			),
			array(
				'name'     => esc_html__( 'WPC Smart Compare', 'tm-organik' ),
				'slug'     => 'woo-smart-compare',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'WPC Smart Wishlist', 'tm-organik' ),
				'slug'     => 'woo-smart-wishlist',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'WPC Smart Quick View', 'tm-organik' ),
				'slug'     => 'woo-smart-quick-view',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'WPC Product Bundles', 'tm-organik' ),
				'slug'     => 'woo-product-bundle',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'MailChimp for WordPress', 'tm-organik' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Contact Form 7', 'tm-organik' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),
		);

		return $plugins;
	}

}
