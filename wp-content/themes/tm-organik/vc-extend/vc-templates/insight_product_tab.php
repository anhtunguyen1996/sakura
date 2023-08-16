<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-product-tab insight-woo';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$terms = explode( ',', $categories );

if ( count( $terms ) <= 0 ) {
	return;
}
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>"
     data-perpage="<?php echo esc_attr( $number ); ?>"
     data-order="<?php echo esc_attr( $order ); ?>"
     data-orderby="<?php echo esc_attr( $order_by ); ?>">
	<?php if ( $show_filter == 'yes' ) { ?>
        <div class="insight-tab">
            <ul>
                <li>
                    <a class="active loaded" href="#" data-tab="*">
						<?php echo esc_html__( 'All', 'tm-organik' ) ?>
                    </a>
                </li>
				<?php foreach ( $terms as $key => $term ) {
					$woo_term = get_term_by( 'slug', $term, 'product_cat' );
					if ( $woo_term ) {
						?>
                        <li>
                            <a href="<?php echo esc_attr( '#' . $woo_term->slug ); ?>"
                               data-tab="<?php echo esc_attr( $woo_term->slug ); ?>">
								<?php echo esc_html( $woo_term->name ); ?>
                            </a>
                        </li>
						<?php
					}
				} ?>
            </ul>
        </div>
	<?php } ?>
    <div class="columns-<?php echo esc_attr( $columns ); ?> products-tab-content">
        <div class="products-tab-content-inner active" data-tab="*">
			<?php
			$params       = array(
				'post_type'      => 'product',
				'paged'          => 1,
				'posts_per_page' => $number,
				'orderby'        => $order_by,
				'order'          => $order
			);
			$product_loop = new WP_Query( $params );
			if ( $product_loop->have_posts() ) {
				woocommerce_product_loop_start();
				while ( $product_loop->have_posts() ) {
					$product_loop->the_post();
					wc_get_template_part( 'content', 'product' );
				}
				woocommerce_product_loop_end();
				wp_reset_postdata();

				if ( $show_load_more == 'yes' ) { ?>
                    <div class="load-btn">
                        <button class="insight-btn small" data-tab="*" data-page="2">
							<?php esc_html_e( 'Load more', 'tm-organik' ) ?>
                        </button>
                    </div>
				<?php }
			}
			?>
        </div>
		<?php foreach ( $terms as $key => $term ) {
			$woo_term = get_term_by( 'slug', $term, 'product_cat' );
			if ( $woo_term ) {
				?>
                <div class="products-tab-content-inner" data-tab="<?php echo esc_attr( $woo_term->slug ); ?>">
					<?php
					woocommerce_product_loop_start();
					woocommerce_product_loop_end();
					if ( $show_load_more == 'yes' ) { ?>
                        <div class="load-btn">
                            <button class="insight-btn small loading" data-page="2"
                                    data-tab="<?php echo esc_attr( $woo_term->slug ); ?>">
								<?php esc_html_e( 'Load more', 'tm-organik' ) ?>
                            </button>
                        </div>
					<?php }
					?>
                </div>
				<?php
			}
		} ?>
    </div>
</div>
