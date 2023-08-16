<?php

if ( class_exists( 'Insight_FontIcon' ) ) {
	new Insight_FontIcon();
}

vc_set_shortcodes_templates_dir( INSIGHT_THEME_DIR . '/vc-extend/vc-templates' );

add_action( 'init', 'insight_require_vc_extend', 10 );
add_action( 'admin_head', 'insight_load_libs_for_vc_param' );
add_action( 'vc_before_init', 'insight_vc_before_init' );
add_action( 'vc_after_init', 'insight_set_use_theme_fonts_default', 'load' );
add_filter( 'excerpt_more', 'insight_wpdocs_excerpt_more' );

function insight_vc_before_init() {
	vc_set_as_theme();
}

function insight_require_vc_extend() {
	// Load params
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-params/datetime_picker.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-params/gradient.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-params/imgradio.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-params/number.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-params/social-links.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-params/toggle.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-params/ajax-search.php' );

	// Load maps
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_about.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_about2.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_about3.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_accordion.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_blog.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_button.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_carousel.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_category_carousel.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_counter.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_countdown.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_featured_category.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_featured_product.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_countdown_product.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_gallery.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_gmaps.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_icon_boxes.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_icon.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_our_services.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_process.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_product_carousel.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_product_column.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_product_grid.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_product_tab.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_product_single.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_product_info.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_product_spot.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_team_member.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_testimonial.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_title.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_special_title.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_separator.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/insight_custom_menu.php' );
	require_once( INSIGHT_THEME_DIR . '/vc-extend/vc-maps/vc_custom_heading.php' );

}

function insight_load_libs_for_vc_param() {

	// Style of all
	wp_enqueue_style( 'is-visual-composer', INSIGHT_THEME_URI . '/assets/admin/css/visual-composer.css' );
	wp_enqueue_style( 'balloon', INSIGHT_THEME_URI . '/assets/admin/css/balloon.min.css' );

	// Gradient param
	wp_enqueue_style( 'is-classygradient', INSIGHT_THEME_URI . '/assets/admin/libs/classygradient/dist/jquery-classygradient-min.css' );
	wp_enqueue_style( 'is-colorpicker', INSIGHT_THEME_URI . '/assets/admin/libs/colorpicker/dist/jquery-colorpicker.css' );

	// Add icon-font
	wp_enqueue_style( 'ionicons', INSIGHT_THEME_URI . '/assets/libs/ionicons/css/ionicons.min.css' );
	wp_enqueue_style( 'font-organik', INSIGHT_THEME_URI . '/assets/libs/font-organik/organik.css' );

	wp_enqueue_script( 'is-colorpicker', INSIGHT_THEME_URI . '/assets/admin/libs/colorpicker/dist/jquery-colorpicker.js', array( 'jquery' ), INSIGHT_THEME_VERSION, true );
	wp_enqueue_script( 'is-classygradient', INSIGHT_THEME_URI . '/assets/admin/libs/classygradient/dist/jquery-classygradient-min.js', array( 'jquery' ), INSIGHT_THEME_VERSION, true );

}

function insight_set_use_theme_fonts_default() {
	//Get current values stored in the color param in "Call to Action" element
	$param_use_theme_fonts = WPBMap::getParam( 'vc_custom_heading', 'use_theme_fonts' );
	//Append new value to the 'value' array
	$param_use_theme_fonts['std'] = 'yes';
	//Finally "mutate" param with new values
	vc_update_shortcode_param( 'vc_custom_heading', $param_use_theme_fonts );
}

function insight_wpdocs_excerpt_more( $more ) {
	return '...';
}
