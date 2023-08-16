<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-product-column';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$uid    = uniqid( 'insight-product-column-' );
$show   = explode( ',', $show );
$params = array();
switch ( $type ) {
	case 'recent':
		$params = array(
			'posts_per_page'      => $number,
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'stock'               => 1
		);
		break;
	case 'bestseller':
		$params = array(
			'posts_per_page'      => $number,
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'stock'               => 1,
			'meta_key'            => 'total_sales',
			'orderby'             => 'meta_value_num',
			'order'               => 'desc'
		);
		break;
	case 'toprate':
		$params = array(
			'posts_per_page'      => $number,
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'stock'               => 1,
			'meta_key'            => '_wc_average_rating',
			'orderby'             => 'meta_value_num',
			'order'               => 'desc'
		);
		break;
	case 'featured':
		$params = array(
			'posts_per_page'      => $number,
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'stock'               => 1,
			'meta_key'            => '_featured',
			'meta_value'          => 'yes',
		);
		break;
	case 'onsale':
		$params = array(
			'posts_per_page'      => $number,
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'stock'               => 1,
			'meta_query'          => array(
				'relation' => 'or',
				array(
					'key'     => '_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				),
				array(
					'key'     => '_min_variation_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				)
			)
		);
		break;
	case 'category':
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
					'terms'    => $category
				)
			),
		);
		break;
}
$product_loop = new WP_Query( $params );
if ( $product_loop->have_posts() ) {
	?>
    <div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>" id="<?php echo esc_attr( $uid ); ?>">
        <h3 class="title">
			<?php echo esc_html( $title ); ?>
        </h3>
        <div class="content">
            <div class="item">
				<?php
				$i = 1;
				while ( $product_loop->have_posts() ) :
					$product_loop->the_post();
					global $product;
					$product_id = $product->get_id();
					?>
                    <div class="product-item">
                        <div class="product-thumb">
							<?php echo get_the_post_thumbnail( $product_id, 'shop_catalog' ); ?>
                        </div>
                        <div class="product-info">
								<span class="product-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</span>
							<?php
							if ( in_array( 'price', $show ) ) {
								echo '<div class="product-price">' . $product->get_price_html() . '</div>';
							} ?>
							<?php
							if ( in_array( 'stars', $show ) ) {
								echo '<div class="product-rate">' . wc_get_rating_html( $product_id ) . '</div>';
							} ?>
							<?php
							if ( in_array( 'categories', $show ) ) {
								echo '<div class="product-categories">' . wc_get_product_category_list( $product_id, ' ' ) . '</div>';
							} ?>
                        </div>
                    </div>
					<?php
					if ( ( $i % $slides_to_display == 0 ) && ( $i < $product_loop->post_count ) ) {
						echo '</div><div class="item">';
					}
					$i ++;
				endwhile;
				?>
            </div>
        </div>
    </div>
	<?php if ( $enable_carousel == 'true' ) { ?>
        <script>
			jQuery( document ).ready( function( $ ) {
				$( "#<?php echo esc_attr( $uid ); ?> .content" ).slick( {
					slidesToShow: 1,
					slidesToScroll: 1,
					<?php if ( $enable_autoplay == 'true' ) { ?>
					autoplay: true,
					<?php } else { ?>
					autoplay: false,
					<?php } ?>
					<?php if ( $display_arrows == 'true' ) { ?>
					arrows: true,
					<?php } else { ?>
					arrows: false,
					<?php } ?>
					infinite: true,
				} );
			} );
        </script>
	<?php }
	wp_reset_postdata();
}
