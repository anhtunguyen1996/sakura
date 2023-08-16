<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' ' . $text_align . ' insight-counter';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
    <div class="number">
		<?php echo esc_attr( $prefix ) . '<span>' . esc_attr( $number ) . '</span>' . esc_attr( $suffix ); ?>
    </div>
    <div class="text"><?php echo esc_html( $text ); ?></div>
</div>
