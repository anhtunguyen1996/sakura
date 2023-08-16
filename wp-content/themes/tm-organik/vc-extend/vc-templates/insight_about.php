<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-about row';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$carousel_images = explode( ',', $carousel_images );
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ) ?>">
    <div class="insight-about--main-img col-lg-6">
		<?php if ( ! empty( $image ) && ( $image > 0 ) ) {
			echo wp_get_attachment_image( $image, 'full' );
		} ?>
    </div>
    <div class="insight-about--content col-lg-6">
        <div class="insight-about--content--title">
            <h4><?php echo esc_html( $title ) ?></h4>
            <div class="insight-about--content--title--line"></div>
        </div>

        <div class="insight-about--content--text">
            <p><?php Insight_Helper::output( $content ); ?></p>
        </div>
        <div class="insight-about--carousel">
			<?php if ( ! empty( $carousel_images ) && is_array( $carousel_images ) ): ?>
				<?php foreach ( $carousel_images as $carousel_image ): ?>
                    <a href="<?php echo esc_attr( Insight_Helper::img_fullsize( $carousel_image ) ) ?>">
						<?php echo wp_get_attachment_image( $carousel_image, array( 135, 97 ) ); ?>
                        <span class="ion-plus-round"></span>
                    </a>
				<?php endforeach; ?>
			<?php endif; ?>
        </div>
    </div>
</div>
