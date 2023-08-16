<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initial setup for this theme
 *
 * @package   InsightFramework
 */
class Insight_Init {

	static private $_instance = null;

	/**
	 * The constructor.
	 */
	private function __construct() {
		// Instantiates the Insight_Enqueue object
		new Insight_Enqueue();

		//This is a wrapper class for Kirki
		new Kiki();

		// Instantiates the Insight_Customize
		new Insight_Customize();

		// Instantiates the Insight_Extras
		new Insight_Extras();

		// Instantiates the Insight_Import
		new Insight_Import();

		// Instantiates the Insight_Register_Plugins
		new Insight_Register_Plugins();

		// Instantiates the Insight_Woo
		new Insight_Woo();

		// Instantiates the Insight_Metabox
		new Insight_Metabox();

		// Instantiates Insight_Functions
		new Insight_Functions();

		// Adjust the content-width
		add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );

		// Load the theme's textdomain
		add_action( 'after_setup_theme', array( $this, 'load_theme_textdomain' ) );

		// Register navigation menus
		add_action( 'after_setup_theme', array( $this, 'register_nav_menus' ) );

		// Add theme supports
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );

		// Register widget areas
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );

		// Support editor style
		add_editor_style( array( 'editor-style.css' ) );

		// Core filters
		add_filter( 'insight_core_info', array( $this, 'core_info' ) );
	}

	/**
	 * Registers the Menus.
	 *
	 * @access public
	 */
	public function register_nav_menus() {
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'tm-organik' ),
			'top'     => esc_html__( 'Top', 'tm-organik' ),
		) );
	}

	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 *
	 * @access public
	 */
	public function load_theme_textdomain() {
		load_theme_textdomain( 'tm-organik', INSIGHT_THEME_DIR . '/languages' );
	}

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @access public
	 * @global int $content_width
	 */
	public function content_width() {
		$GLOBALS['content_width'] = apply_filters( 'content_width', 640 );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @access public
	 */
	public function add_theme_supports() {
		/*
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'insight-post-small', 80, 80, true );
		add_image_size( 'insight-post-full', 870, 470, true );
		add_image_size( 'insight-post-list', 330, 240, true );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		/*
		 * Set up the WordPress core custom background feature.
		 */
		add_theme_support( 'custom-background', apply_filters( 'custom_background_args', array(
			'default-color' => '#ffffff',
			'default-image' => '',
		) ) );

		/*
		 * Support woocommerce
		 */
		add_theme_support( 'woocommerce', array(
			'product_grid' => array(
				'default_rows'    => 3,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 4,
			),
		) );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/*
		 * Support selective refresh for widget
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/* WordPress 5.0 */
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );

		add_theme_support( 'insight-core' );
		add_theme_support( 'insight-kungfu' );
		add_theme_support( 'insight-megamenu' );
		add_theme_support( 'insight-sidebar' );
		add_theme_support( 'insight-metabox' );
	}

	function widgets_init() {
		register_sidebar( array(
			'id'            => 'sidebar',
			'name'          => esc_html__( 'Sidebar', 'tm-organik' ),
			'description'   => esc_html__( 'Add widgets here.', 'tm-organik' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		if ( class_exists( 'WooCommerce' ) ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Sidebar for Shop', 'tm-organik' ),
				'id'            => 'sidebar_shop',
				'description'   => esc_html__( 'Sidebar for all shop pages', 'tm-organik' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}

		register_sidebar( array(
			'id'            => 'footer_01',
			'name'          => esc_html__( 'Footer Column 01', 'tm-organik' ),
			'description'   => esc_html__( 'Add widgets here.', 'tm-organik' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'id'            => 'footer_02',
			'name'          => esc_html__( 'Footer Column 02', 'tm-organik' ),
			'description'   => esc_html__( 'Add widgets here.', 'tm-organik' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'id'            => 'footer_03',
			'name'          => esc_html__( 'Footer Column 03', 'tm-organik' ),
			'description'   => esc_html__( 'Add widgets here.', 'tm-organik' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'id'            => 'footer_04',
			'name'          => esc_html__( 'Footer Column 04', 'tm-organik' ),
			'description'   => esc_html__( 'Add widgets here.', 'tm-organik' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	/**
	 * Core info
	 *
	 * @param $info
	 *
	 * @return mixed
	 */
	public function core_info( $info ) {
		$info['support'] = 'https://thememove.ticksy.com/';
		$info['faqs']    = 'https://thememove.ticksy.com/articles/';
		$info['docs']    = 'https://document.thememove.com/organik-document';
		$info['child']   = 'https://api.thememove.com/update/organik/tm-organik-child.zip';
		$info['api']     = 'https://api.thememove.com/update/organik';
		$info['icon']    = INSIGHT_THEME_URI . '/assets/images/favicon.png';
		$info['desc']    = 'Thank you for using our theme, please reward it a full five-star &#9733;&#9733;&#9733;&#9733;&#9733; rating.';
		$info['tf']      = 'https://themeforest.net/item/organik-an-appealing-organic-store-farm-bakery-woocomerce-theme/17678863';

		return $info;
	}

	/**
	 * Singleton for global accessing.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}
