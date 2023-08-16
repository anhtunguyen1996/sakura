<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-separator';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

if ( $style == 'color' ) {
	$el_class .= ' custom-color';
}
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>"
     style="<?php echo esc_attr( $style == 'color' ? 'color: ' . $color . '; border-color: ' . $color : '' ); ?>">
    <div class="separator vc_separator vc_separator_align_center vc_sep_pos_align_center vc_separator-has-text">
        <span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span>
        <div class="separator--icon vc_icon_element vc_icon_element-outer">
            <i style="<?php echo esc_attr( $style == 'color' ? 'color: ' . $icon_color . ';' : '' ); ?>" class="organik-flower"></i>
        </div>
        <span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
    </div>
</div>
