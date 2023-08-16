<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-about3';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
    <div class="row">
        <div class="col-md-8 image1">
			<?php if ( ! empty( $image1 ) && is_numeric( $image1 ) ) {
				echo wp_get_attachment_image( $image1, array( 670, 420 ) );
			} ?>
        </div>
        <div class="col-md-4 image2">
			<?php if ( ! empty( $image2 ) && is_numeric( $image2 ) ) {
				echo wp_get_attachment_image( $image2, array( 268, 355 ) );
			} ?>
        </div>
    </div>
    <div class="row row-bottom">
        <div class="col-md-4 about3-title">
            <h2 class="special-heading"><?php echo esc_html( $title ) ?></h2>
            <h3 class="sub-title"><?php echo esc_html( $sub_title ) ?></h3>
			<?php if ( ! empty( $image4 ) && is_numeric( $image4 ) ) {
				echo wp_get_attachment_image( $image4, 'full' );
			} ?>
        </div>
        <div class="col-md-4 image3">
			<?php if ( ! empty( $image3 ) && is_numeric( $image3 ) ) {
				echo wp_get_attachment_image( $image3, array( 370, 370 ) );
			} ?>
        </div>
        <div class="col-md-4">
            <div class="about3-quote">
                <span class="ion-quote small"></span>
                <span class="ion-quote big"></span>
                <div class="about3-quote-text">
					<?php echo esc_html( $quote_text ) ?>
                </div>
                <div class="about3-quote-author">
					<?php echo esc_html( $quote_author ) ?>
                </div>
            </div>
        </div>
    </div>
</div>
