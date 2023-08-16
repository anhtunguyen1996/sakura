<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' ' . $style . ' insight-icon-boxes';

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
	$icon_class = isset( ${'icon_' . $icon_lib} ) ? esc_attr( ${'icon_' . $icon_lib} ) : 'ionic';
	$icon_html  .= "<i class='" . $icon_class . "' ></i>";
}

// Get element tag
if ( empty( $element_tag ) ) {
	$element_tag = 'h6';
}
?>
<?php if ( $style == 'icon_on_right' ) { ?>
    <div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
        <div class="insight-icon-boxes--inner">
			<?php echo '<' . esc_attr( $element_tag ) . ' class="insight-icon-boxes--title">' . esc_html( $title ) . '</' . esc_attr( $element_tag ) . '>'; ?>
            <div class="insight-icon-boxes--content"><?php Insight_Helper::output( $content ) ?></div>
        </div>
        <div class="insight-icon-boxes--icon"><?php Insight_Helper::output( $icon_html ) ?></div>
    </div>
<?php } else { ?>
    <div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
        <div class="insight-icon-boxes--icon"><?php Insight_Helper::output( $icon_html ) ?></div>
        <div class="insight-icon-boxes--inner">
			<?php echo '<' . esc_attr( $element_tag ) . ' class="insight-icon-boxes--title">' . esc_html( $title ) . '</' . esc_attr( $element_tag ) . '>'; ?>
            <div class="insight-icon-boxes--content"><?php Insight_Helper::output( $content ) ?></div>
        </div>
    </div>
<?php }
