<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-carousel';
if ( $gray_style == 'yes' ) {
	$el_class .= ' grayscale';
}

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

if ( $images == '' ) {
	return;
}

$images = explode( ',', $images );

$data_slick = array();

if ( $dots == 'yes' ) {
	$data_slick['dots'] = true;
}
if ( $autoplay == 'yes' ) {
	$data_slick['autoplay'] = true;
}
$data_slick['arrows'] = true;

$data_slick['slidesToShow']   = (int) $slides_per_row;
$data_slick['slidesToScroll'] = (int) $slides_per_row;
$data_slick['responsive']     = array(
	array(
		'breakpoint' => 480,
		'settings'   => array(
			'slidesToShow'   => 2,
			'slidesToScroll' => 2
		)
	),
);
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>"
     data-slick='<?php echo wp_json_encode( $data_slick ) ?>'>
	<?php
	foreach ( $images as $attach_id ) {
		if ( $attach_id > 0 ) {
			if ( ( $custom_image_size == 'yes' ) && ( $width > 0 ) && ( $height > 0 ) ) {
				echo '<div class="insight-carousel--slide">';
				echo wp_get_attachment_image( $attach_id, array( $width, $height ) );
				echo '</div>';
			} else {
				echo '<div class="insight-carousel--slide">';
				echo wp_get_attachment_image( $attach_id, 'full' );
				echo '</div>';
			}
		} else {
			continue;
		}
	} ?>
</div>
