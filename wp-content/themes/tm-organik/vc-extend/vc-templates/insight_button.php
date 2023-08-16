<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-btn';

if ( $style ) {
	$el_class .= ' style-' . $style;
}

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

// Get link
$link_html   = '';
$link        = vc_build_link( $link );
$link_url    = ( isset( $link['url'] ) ) ? $link['url'] : '';
$link_text   = ( isset( $link['title'] ) ) ? $link['title'] : '';
$link_target = ( isset( $link['target'] ) ) ? $link['target'] : '';
$link_rel    = ( isset( $link['rel'] ) ) ? $link['rel'] : '';

if ( ! empty( $link_text ) ) {
	echo '<a class="' . Insight_Helper::nice_class( $el_class ) . '" href="' . esc_url( $link_url ) . '" target="' . esc_attr( $link_target ) . '" rel="' . esc_attr( $link_rel ) . '">' . esc_html( $link_text ) . '</a>';
}
