<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-special-title';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

if ( $align ) {
	$el_class .= ' align-' . $align;
}
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
    <div class="insight-special-title--number"><?php echo esc_html( $number ) ?></div>
    <div class="insight-special-title--title"><?php echo esc_html( $title ) ?></div>
</div>
