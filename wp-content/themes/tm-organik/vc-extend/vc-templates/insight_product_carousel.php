<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' ' . $product_type . ' insight-product-carousel insight-woo';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$data_slick                   = array();
$data_slick['arrows']         = true;
$data_slick['slidesToShow']   = 3;
$data_slick['slidesToScroll'] = 3;
$data_slick['responsive']     = array(
	array(
		'breakpoint' => 480,
		'settings'   => array(
			'slidesToShow'   => 2,
			'slidesToScroll' => 2
		)
	)
);

$terms = get_terms( 'product_cat', array(
	'slug' => explode( ',', $categories ),
) );

?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
	<?php if ( ! empty( $title ) ): ?>
        <h3 class="special-heading insight-title"><?php echo esc_html( $title ) ?></h3>
	<?php endif; ?>
	<?php if ( ! empty( $sub_title ) ): ?>
        <h4 class="insight-sub-title"><?php echo esc_html( $sub_title ) ?></h4>
	<?php endif; ?>

	<?php if ( $product_type == 'categories' ) { ?>
        <div class="insight-filter">
            <ul data-option-key="filter">
                <li><a class="active" href="#filter"
                       data-option-value=".product"><?php echo esc_html__( 'All', 'tm-organik' ) ?></a></li>
				<?php foreach ( $terms as $key => $term ): ?>
                    <li><a href="#"
                           data-option-value="<?php echo '.product_cat-' . $term->slug ?>"><?php echo '' . $term->name ?></a>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
	<?php } ?>

	<?php
	if ( empty( $product_type ) || 'categories' == $product_type ):
		$params = array(
			'posts_per_page'      => $number,
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'stock'               => 1,
			'tax_query'           => array(
				'relation' => 'or',
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => explode( ',', $categories )
				)
			),
		);
		$product_loop = new WP_Query( $params );
		?>
        <div class="products">
			<?php
			while ( $product_loop->have_posts() ) :
				$product_loop->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
			wp_reset_postdata();
			?>
        </div>
	<?php
    elseif ( ( $product_type == 'special_products' ) && ( $special_products != '' ) ):
		$params = array(
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'stock'               => 1,
			'post__in'            => explode( ',', $special_products ),
			'orderby'             => 'post__in',
		);
		$product_loop = new WP_Query( $params );
		?>
        <div class="products">
			<?php
			while ( $product_loop->have_posts() ) :
				$product_loop->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
			wp_reset_postdata();
			?>
        </div>
	<?php
	else:
		echo do_shortcode( '[' . $product_type . ' columns="3" per_page="' . $number . '" orderby="' . $order_by . '" order="' . $order . '"]' );
	endif;
	?>
</div>
