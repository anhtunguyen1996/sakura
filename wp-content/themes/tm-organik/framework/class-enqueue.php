<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue scripts and styles.
 *
 * @package   InsightFramework
 */
class Insight_Enqueue {

	/**
	 * The constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'customize_controls_init', array( $this, 'customize_preview_css' ) );
	}

	/**
	 * Enqueue scrips & styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		/* Main CSS */
		wp_enqueue_style( 'main-style', get_template_directory_uri() . '/style.css' );

		/* Fonts */
		wp_enqueue_style( 'ionicons', INSIGHT_THEME_URI . '/assets/libs/ionicons/css/ionicons.css' );
		wp_enqueue_style( 'font-organik', INSIGHT_THEME_URI . '/assets/libs/font-organik/organik.css' );
		wp_enqueue_style( 'font-awesome', INSIGHT_THEME_URI . '/assets/libs/awesome/css/fontawesome-all.min.css', null, null );

		wp_enqueue_script( 'isotope', INSIGHT_THEME_URI . '/assets/libs/isotope/isotope.pkgd.min.js', array( 'jquery' ), null, true );

		wp_enqueue_script( 'imagesloaded' );

		/* Countdown */
		wp_enqueue_script( 'countdown', INSIGHT_THEME_URI . '/assets/libs/countdown/countdown.min.js', array( 'jquery' ), null, true );

		/* Counter */
		wp_enqueue_script( 'odometer', INSIGHT_THEME_URI . '/assets/libs/odometer/odometer.min.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'odometer-theme-minimal', INSIGHT_THEME_URI . '/assets/libs/odometer/odometer-theme-minimal.css' );

		/* Slideout */
		wp_enqueue_script( 'slideout', INSIGHT_THEME_URI . '/assets/libs/slideout/slideout.min.js', array( 'jquery' ), null, true );

		/* Growl */
		wp_enqueue_script( 'growl', INSIGHT_THEME_URI . '/assets/libs/growl/jquery.growl.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'growl', INSIGHT_THEME_URI . '/assets/libs/growl/jquery.growl.css' );

		/* Slick */
		wp_enqueue_style( 'slick', INSIGHT_THEME_URI . '/assets/libs/slick/slick.css' );
		wp_enqueue_script( 'slick', INSIGHT_THEME_URI . '/assets/libs/slick/slick.min.js', array( 'jquery' ), null, true );

		/* Lightgallery */
		wp_enqueue_script( 'lightgallery', INSIGHT_THEME_URI . '/assets/libs/lightgallery/js/lightgallery-all.min.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'lightgallery', INSIGHT_THEME_URI . '/assets/libs/lightgallery/css/lightgallery.min.css' );

		/* Headroom */
		if ( Insight::setting( 'header_sticky_enable' ) == 1 ) {
			wp_enqueue_script( 'jquery-headroom', INSIGHT_THEME_URI . '/assets/libs/headroom/jQuery.headroom.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'headroom', INSIGHT_THEME_URI . '/assets/libs/headroom/headroom.js', array( 'jquery' ), null, true );
		}

		/* Featherlight */
		wp_enqueue_script( 'featherlight', INSIGHT_THEME_URI . '/assets/libs/featherlight/featherlight.min.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'featherlight', INSIGHT_THEME_URI . '/assets/libs/featherlight/featherlight.min.css' );

		/* Main JS */
		if ( class_exists( 'WooCommerce' ) ) {
			$notice_cart_url = wc_get_cart_url();
		} else {
			$notice_cart_url = '/cart';
		}
		wp_enqueue_script( 'js-main', INSIGHT_THEME_URI . '/assets/js/main.js', array( 'jquery' ), null, true );
		wp_localize_script( 'js-main', 'jsVars', array(
			'ajaxUrl'                 => esc_js( admin_url( 'admin-ajax.php' ) ),
			'popupEnable'             => esc_js( Insight::setting( 'popup_enable' ) ),
			'popupReOpen'             => esc_js( Insight::setting( 'popup_reopen' ) ),
			'noticeCookieEnable'      => esc_js( Insight::setting( 'notice_cookie_enable' ) ),
			'noticeCartUrl'           => esc_js( $notice_cart_url ),
			'noticeCartText'          => esc_js( esc_html__( 'View cart', 'tm-organik' ) ),
			'noticeAddedCartText'     => esc_js( esc_html__( 'Added to cart!', 'tm-organik' ) ),
			'noticeAddedWishlistText' => esc_js( esc_html__( 'Added to wishlist!', 'tm-organik' ) ),
			'noticeCookie'            => esc_js( wp_kses( Insight::setting( 'notice_cookie_message' ), 'insight-a' ) ),
			'noticeCookieOk'          => esc_js( esc_html__( 'Thank you! Hope you have the best experience on our website.', 'tm-organik' ) ),
			'shopDefaultLayout'       => esc_js( Insight::setting( 'shop_archive_view_switch_layout' ) ),
		) );

		/*
		 * The comment-reply script.
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Add customize preview css
	 *
	 * @since 0.9.1
	 */
	public function customize_preview_css() {
		wp_enqueue_style( 'kirki-custom-css', INSIGHT_THEME_URI . '/assets/admin/css/custom.css' );
	}

}
