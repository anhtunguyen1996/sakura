<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' ' . $align . ' ' . $display . ' insight-icon';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

// Get icon
$icon_html = '';
if ( is_numeric( $custom_icon ) && ( $icon_type == 'custom' ) ) {
	$icon_html .= wp_get_attachment_image( $custom_icon, 'full' );
} else {
	// Enqueue needed icon font
	if ( $icon_lib != 'ionicons' ) {
		vc_icon_element_fonts_enqueue( $icon_lib );
	}
	$icon_class = isset( ${"icon_" . $icon_lib} ) ? esc_attr( ${"icon_" . $icon_lib} ) : 'ionic';
	$icon_html  .= "<i class='" . $icon_class . "' ></i>";
}

// Get style
$icon_style = '';
if ( ! empty( $font_size ) ) {
	$icon_style .= 'font-size: ' . $font_size . 'px;';
}
if ( ! empty( $color ) ) {
	$icon_style .= 'color: ' . $color . ';';
}
if ( ! empty( $display ) ) {
	$icon_style .= 'display: ' . $display . ';';
}
if ( ! empty( $align ) ) {
	$icon_style .= 'text-align: ' . $align . ';';
}

$uid = uniqid( 'insight-icon-' );
Insight_Helper::apply_style( $icon_style, '#' . $uid );
?>
<div id="<?php echo esc_attr( $uid ); ?>" class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
	<?php Insight_Helper::output( $icon_html ) ?>
</div>
