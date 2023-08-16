<?php
/**
 * Theme Customizer
 *
 * @package tm-organik
 */

/**
 * Setup configuration
 *
 * @since 0.9
 */
Kiki::add_config( 'theme', array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );

/**
 * Add sections
 *
 * @since 0.9.7
 */
$priority = 1;
Kiki::add_section( 'site', array(
	'title'       => esc_html__( 'Site', 'tm-organik' ),
	'description' => esc_html__( 'Control the site layout, color and typography.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'header', array(
	'title'       => esc_html__( 'Header', 'tm-organik' ),
	'description' => esc_html__( 'Control the header style, layout, spacing and color.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'topbar', array(
	'title'       => esc_html__( 'Top Bar', 'tm-organik' ),
	'description' => esc_html__( 'Control the top bar layout, spacing, typography and color.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'navigation', array(
	'title'       => esc_html__( 'Navigation', 'tm-organik' ),
	'description' => esc_html__( 'Control the navigation typography, spacing and color.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'title_breadcrumbs', array(
	'title'    => esc_html__( 'Title & Breadcrumbs', 'tm-organik' ),
	'priority' => $priority ++,
) );

Kiki::add_section( 'footer', array(
	'title'       => esc_html__( 'Footer', 'tm-organik' ),
	'description' => esc_html__( 'Control the footer preset, layout, spacing, typography and color.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'copyright', array(
	'title'       => esc_html__( 'Copyright', 'tm-organik' ),
	'description' => esc_html__( 'Control the copyright layout, spacing, typography, color and content.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'post', array(
	'title'    => esc_html__( 'Post', 'tm-organik' ),
	'priority' => $priority ++,
) );

Kiki::add_section( 'shop', array(
	'title'       => esc_html__( 'Shop', 'tm-organik' ),
	'description' => esc_html__( 'Control the shop layout, shop title, product archive pages and product single page.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'notice', array(
	'title'    => esc_html__( 'Notice', 'tm-organik' ),
	'priority' => $priority ++,
) );

Kiki::add_section( 'popup', array(
	'title'    => esc_html__( 'Ads Popup', 'tm-organik' ),
	'priority' => $priority ++,
) );

Kiki::add_section( 'gmap', array(
	'title'    => esc_html__( 'Google Map', 'tm-organik' ),
	'priority' => $priority ++,
) );

Kiki::add_section( 'logo', array(
	'title'       => esc_html__( 'Logo', 'tm-organik' ),
	'description' => esc_html__( 'Control the default logo, mobile logo and sticky logo.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'socials', array(
	'title'       => esc_html__( 'Socials', 'tm-organik' ),
	'description' => esc_html__( 'Control the social links for footer and other places.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'custom_code_js', array(
	'title'       => esc_html__( 'Additional JS', 'tm-organik' ),
	'description' => esc_html__( 'Control the custom JS code.', 'tm-organik' ),
	'priority'    => $priority ++,
) );

Kiki::add_section( 'settings_preset', array(
	'title'    => esc_html__( 'Settings Preset', 'tm-organik' ),
	'priority' => $priority++,
) );


/**
 * Load modules
 *
 * @since 0.9
 */
require_once( INSIGHT_THEME_DIR . '/customizer/section-title.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-buttons.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-copyright.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-desktop-menu.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-footer.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-header.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-logo.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-mobile-menu.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-notice.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-popup.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-gmap.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-post.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-shop.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-site.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-socials.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-topbar.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-custom-js.php' );
require_once( INSIGHT_THEME_DIR . '/customizer/section-preset.php' );
