<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$style = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-featured-category';

$el_class .= " style-$style";

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$woo_cat = get_term_by( 'slug', $category, 'product_cat' );
if ( $woo_cat != false ) {
	?>

	<?php if($style === '01') { ?>
		<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
			<a href="<?php echo get_term_link( $woo_cat->term_id, 'product_cat' ); ?>">
				<div class="image">
					<div class="bg" style="background-color: <?php echo esc_attr( $color ); ?>"></div>
					<div class="img">
						<?php echo wp_get_attachment_image( $image, 'full' ); ?>
					</div>
				</div>
				<div class="title"><?php echo esc_html( $woo_cat->name ); ?></div>
			</a>
		</div>
	<?php } elseif ($style === '02') { ?>
		<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>" style="background-color: <?php echo esc_attr( $color ); ?>">
			<a href="<?php echo get_term_link( $woo_cat->term_id, 'product_cat' ); ?>">
				<div class="image">
					<div class="img">
						<?php echo wp_get_attachment_image( $image, 'full' ); ?>
					</div>
				</div>
				<div class="title"><?php echo esc_html( $woo_cat->name ); ?></div>
			</a>
		</div>
	<?php } ?>

	<?php
}
