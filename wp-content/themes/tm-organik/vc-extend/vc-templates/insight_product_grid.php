<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-product-grid insight-woo';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$terms = explode( ',', $categories );

$paged = 1;
if ( get_query_var( 'paged' ) != '' ) {
	$paged = get_query_var( 'paged' );
}
if ( get_query_var( 'page' ) != '' ) {
	$paged = get_query_var( 'page' );
}

$next_page = 0;
$uid       = uniqid( 'insight-product-grid-content-' );
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
	<?php if ( $disable_filter != 'yes' ) { ?>
        <div class="insight-grid-filter">
            <ul data-option-key="filter">
                <li>
                    <a class="active" href="#filter" data-option-value=".product">
						<?php echo esc_html__( 'All', 'tm-organik' ) ?>
                    </a>
                </li>
				<?php foreach ( $terms as $key => $term ):
					$woo_term = get_term_by( 'slug', $term, 'product_cat' ); ?>
                    <li>
                        <a href="#" data-option-value="<?php echo esc_attr( '.product_cat-' . $woo_term->slug ); ?>">
							<?php echo esc_html( $woo_term->name ); ?>
                        </a>
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
		<?php
	}
	if ( empty( $product_type ) || ( 'categories' == $product_type ) ) {
		$params       = array(
			'posts_per_page' => $number,
			'post_type'      => 'product',
			'paged'          => $paged,
			'orderby'        => $order_by,
			'order'          => $order,
			'tax_query'      => array(
				'relation' => 'or',
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => explode( ',', $categories ),
				)
			)
		);
		$product_loop = new WP_Query( $params );
		if ( $product_loop->max_num_pages >= 2 ) {
			$next_page = 2;
		}
		$col_class = ( $columns == 1 ) ? 'column-' . $columns : 'columns-' . $columns;
		?>
        <div id="<?php echo esc_attr( $uid ) ?>" class="<?php echo esc_attr( $col_class ) ?> products-grid-content">
			<?php
			woocommerce_product_loop_start();
			while ( $product_loop->have_posts() ) :
				$product_loop->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
			wp_reset_postdata();
			woocommerce_product_loop_end();
			?>
        </div>
	<?php } else { ?>
        <div id="<?php echo esc_attr( $uid ) ?>" class="products-grid-content">
			<?php
			echo do_shortcode( '[' . $product_type . ' columns="' . $columns . '" per_page="' . $number . '" orderby="' . $order_by . '" order="' . $order . '"]' );
			?>
        </div>
	<?php }
	if ( ( ( $product_type == '' ) || ( 'categories' == $product_type ) ) && ( $show_load_more == 'yes' ) ) {
		//data-url esc_url( add_query_arg( array( 'paged' => '' ), ( is_ssl() ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ) );
		?>
        <div class="loadmore-contain">
            <button data-box-container="#<?php echo esc_attr( $uid ) ?>"
                    data-next-page="<?php echo esc_attr( $next_page ) ?>"
                    data-max-pages="<?php echo esc_attr( $product_loop->max_num_pages ) ?>"
                    class="btn-loadmore insight-btn small"
                    type="button"
                    data-url="#"
                    name="button"
                    data-text="<?php esc_html_e( 'Load more', 'tm-organik' ) ?>">
				<?php esc_html_e( 'Load more', 'tm-organik' ) ?>
            </button>
        </div>
	<?php } ?>
</div>
