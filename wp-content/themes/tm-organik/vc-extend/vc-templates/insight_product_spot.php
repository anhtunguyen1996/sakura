<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-product-spot';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

if ( $type != '' ) {
	$el_class .= ' type-' . $type;
}

if ( $length && is_numeric( $length ) && ( $length > 0 ) ) {
	$spot_length = $length;
} else {
	$spot_length = 0;
}

// Get icon
$icon_html  = '';
$icon_class = isset( ${"icon_" . $icon_lib} ) ? esc_attr( ${"icon_" . $icon_lib} ) : 'ionic';
$icon_html  .= "<i class='" . $icon_class . "' ></i>";
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
    <div class="insight-product-spot--info">
        <div class="title"><?php echo esc_html( $title ); ?></div>
        <div class="content"><?php echo esc_html( $content ); ?></div>
    </div>
    <div class="insight-product-spot--icon">
        <div class="insight-product-spot--icon-inner">
			<?php Insight_Helper::output( $icon_html ) ?>
            <div class="spot" style="width: <?php echo esc_attr( $spot_length ); ?>px">
                <div class="spot-inner"></div>
            </div>
        </div>
    </div>
</div>
