<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup for customizer of this theme
 *
 * @package   InsightFramework
 */

if ( ! class_exists( 'Insight_Customize' ) ) {
	class Insight_Customize {

		protected static $override_settings = array();

		protected static $instance = null;

		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function initialize() {
			// Build URL for customizer.
			add_filter( 'kirki/values/get_value', array( $this, 'kirki_db_get_theme_mod_value' ), 10, 2 );

			// Force load all variants and subsets.
			add_action( 'after_setup_theme', array( $this, 'load_all_variants_and_subsets' ) );

			// Remove unused native sections and controls.
			add_action( 'customize_register', array( $this, 'remove_customizer_sections' ) );

			// Add custom font to font select
			add_filter( 'kirki_fonts_standard_fonts', array( $this, 'add_custom_font' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_custom_font_css' ) );

			// Load customizer sections when all widgets init
			add_action( 'widgets_init', array( $this, 'load_customizer' ), 99 );

			/**
			 * Override kirki settings with url preset or post meta preset.
			 * Used priority 11 to wait global variables loaded.
			 *
			 * @see Brook_Global->init_global_variable()
			 */
			add_action( 'wp', array( $this, 'setup_override_settings' ), 11 );
		}

		/**
		 * Load Customizer.
		 */
		public function load_customizer() {
			Insight::require_file( 'customizer/customizer.php' );
		}

		/**
		 * Active Callback functions
		 *
		 * @since  0.9.2
		 * @access public
		 */

		public static function return_is_page() {
			return is_page();
		}

		/**
		 * Remove unused native sections and controls
		 *
		 * @param $wp_customize
		 *
		 * @since 0.9.3
		 *
		 */
		public function remove_customizer_sections( $wp_customize ) {
			$wp_customize->remove_section( 'nav' );
			$wp_customize->remove_section( 'colors' );
			$wp_customize->remove_section( 'background_image' );
			$wp_customize->remove_section( 'header_image' );
			$wp_customize->remove_control( 'blogdescription' );
			$wp_customize->remove_control( 'display_header_text' );
		}

		/**
		 * Force load all variants and subsets
		 *
		 * @since 0.9
		 */
		public function load_all_variants_and_subsets() {
			if ( class_exists( 'Kirki_Fonts_Google' ) ) {
				Kirki_Fonts_Google::$force_load_all_variants = true;
				//Kirki_Fonts_Google::$force_load_all_subsets = true;
			}
		}

		function add_custom_font( $fonts ) {
			$fonts['cerebrisans'] = array(
				'label'    => 'CerebriSans',
				'variants' => array( 300, '300italic', 'regular', 'italic', 500, '500italic', 600, '600italic', 700, '700italic', 800, '800italic', 900, '900italic' ),
				'stack'    => 'CerebriSans, sans-serif',
			);

			$fonts['rossela'] = array(
				'label'    => 'Rossela Demo',
				'variants' => array( 400 ),
				'stack'    => '"Rossela Demo", sans-serif',
			);

			return $fonts;
		}

		function add_custom_font_css() {
			$typo_fields = Kiki::get_typography_fields_id();

			if ( ! is_array( $typo_fields ) || empty( $typo_fields ) ) {
				return;
			}

			foreach ( $typo_fields as $field ) {
				$value = Insight::setting( $field );

				if ( is_array( $value ) && isset( $value['font-family'] ) && $value['font-family'] !== '' ) {
					$font_family = $value['font-family'];

					if (strpos($font_family, 'CerebriSans') !== false) {
						wp_enqueue_style( 'cerebrisans-font', INSIGHT_THEME_URI . '/assets/fonts/cerebrisans/cerebrisans.css', null, null );
					} elseif (strpos($font_family, 'Rossela Demo') !== false) {
						wp_enqueue_style( 'rossela-font', INSIGHT_THEME_URI . '/assets/fonts/rossela/rossela.css', null, null );
					} else {
						do_action( 'insight_enqueue_custom_font', $value['font-family'] ); // hook to custom do enqueue fonts
					}
				}
			}
		}

		function setup_override_settings() {
			// Make preset in meta box.
			if ( ! is_customize_preview() ) {
				$presets = apply_filters( 'insight_page_meta_box_presets', array() );

				if ( ! empty( $presets ) ) {
					foreach ( $presets as $preset ) {
						$page_preset_value = Insight_Helper::get_post_meta( $preset );

						if ( $page_preset_value !== false ) {
							$_GET[ $preset ] = $page_preset_value;
						}
					}
				}
			}

			// Setup url.
			if ( empty( self::$override_settings ) ) {
				if ( ! empty( $_GET ) ) {

					foreach ( $_GET as $key => $query_value ) {
						if ( ! empty( Kirki::$fields[ $key ] ) ) {

							if ( is_array( Kirki::$fields[ $key ] ) &&
							     in_array( Kirki::$fields[ $key ]['type'], array(
								     'kirki-preset',
								     'kirki-select',
							     ), true ) &&
							     ! empty( Kirki::$fields[ $key ]['args']['choices'] ) &&
							     ! empty( Kirki::$fields[ $key ]['args']['choices'][ $query_value ] ) &&
							     ! empty( Kirki::$fields[ $key ]['args']['choices'][ $query_value ]['settings'] )
							) {
								$field_choice = Kirki::$fields[ $key ]['args']['choices'];

								foreach ( $field_choice[ $query_value ]['settings'] as $kirki_setting => $kirki_value ) {
									self::$override_settings[ $kirki_setting ] = $kirki_value;
								}
							} else {
								self::$override_settings[ $key ] = $query_value;
							}
						}
					}
				}
			}
		}

		/**
		 * Build URL for customizer
		 *
		 * @param $value
		 * @param $setting
		 *
		 * @return mixed
		 * @since  0.9
		 * @access public
		 *
		 */
		public function kirki_db_get_theme_mod_value( $value, $setting ) {
//			Insight_Helper::d( self::$override_settings );
			if ( ! is_customize_preview() && ! empty( self::$override_settings ) && isset( self::$override_settings["{$setting}"] ) ) {
				return self::$override_settings["{$setting}"];
			}

			return $value;
		}

	}

	Insight_Customize::instance()->initialize();
}

