<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-category-carousel';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$categories = (array) vc_param_group_parse_atts( $categories );
$uid        = uniqid( 'insight-category-carousel-' );
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>" id="<?php echo esc_attr( $uid ); ?>">
	<?php foreach ( $categories as $category ) {
		if ( $category['category'] ) {
			$woo_cat = get_term_by( 'slug', $category['category'], 'product_cat' );
			?>
            <div class="insight-category-carousel-item">
                <div class="insight-category-carousel-item-inner">
                    <a href="<?php echo get_term_link( $woo_cat->term_id, 'product_cat' ); ?>">
                        <div class="info">
                            <span class="name"><?php echo esc_html( $woo_cat->name ); ?></span>
                            <span class="count">
							<?php echo sprintf( _n( '%s item', '%s items', $woo_cat->count, 'tm-organik' ), $woo_cat->count ); ?>
						</span>
                        </div>
						<?php if ( isset( $category['image'] ) && $category['image'] ) { ?>
							<?php echo wp_get_attachment_image( $category['image'], 'full' ); ?>
						<?php } ?>
                    </a>
                </div>
            </div>
			<?php
		}
	} ?>
</div>
<script>
	jQuery( document ).ready( function( $ ) {
		jQuery( "#<?php echo esc_attr( $uid ); ?>" ).slick( {
			slidesToShow: 4,
			autoplay: false,
			dots: false,
			arrows: true,
			infinite: true,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		} );
	} );
</script>