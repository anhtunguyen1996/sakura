<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$title  = $nav_menu = $el_class = $style = $align = '';
$output = '';

$atts   = vc_map_get_attributes( $this->getShortcode(), $atts );
$css_id = uniqid( 'tm-better-custom-menu-' );
extract( $atts );

$el_class  = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'tm-custom-menu ' . $el_class, $this->settings['base'], $atts );
$css_class .= " style-$style";
$css_class .= " align-$align";

if ( empty( $styles ) ) {
	$styles = array();
}

//Link color
if ( ! empty( $link_color ) ) {
	$styles[] = 'color: ' . $link_color;
}
if ( ! empty( $styles ) ) {
	$style = esc_attr( implode( ';', $styles ) );
} else {
	$style = '';
}
Insight_Helper::apply_style( $style, '#' . $css_id . ' a' );

//Link hover color
if ( ! empty( $link_hover_color ) ) {
	$styles_hover[] = 'color: ' . $link_hover_color;
}
if ( ! empty( $styles_hover ) ) {
	$style_hover = esc_attr( implode( ';', $styles_hover ) );
} else {
	$style_hover = '';
}
Insight_Helper::apply_style( $style_hover, '#' . $css_id . ' a:hover' );

$output = '<div class="' . esc_attr( $css_class ) . '" id="' . esc_attr( $css_id ) . '">';
$type   = 'InsightCore_BMW';
$args   = array();
global $wp_widget_factory;
// to avoid unwanted warnings let's check before using widget.
if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
	ob_start();
	the_widget( $type, $atts, $args );
	$output .= ob_get_clean();

	$output .= '</div>';

	echo '' . $output;
} else {
	echo '' . $this->debugComment( 'Widget ' . esc_attr( $type ) . 'Not found in : tm_w_better_custom_menu' );
}
