<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-product-single';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
	<?php
	if ( ! empty( $product ) ) {
		$params       = array(
			'posts_per_page'      => 1,
			'post_type'           => 'product',
			'p'                   => $product,
			'ignore_sticky_posts' => 1,
		);
		$product_loop = new WP_Query( $params );
		while ( $product_loop->have_posts() ) :
			$product_loop->the_post();
			wc_get_template_part( 'content', 'product-single' );
		endwhile;
		wp_reset_postdata();
	}
	?>
</div>
