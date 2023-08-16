<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$shop_product_columns = get_option( 'woocommerce_catalog_columns', 3 );
$column               = 'col-md-' . ( 12 / $shop_product_columns );
$product_id           = $product->get_id();
?>
<div <?php wc_product_class( 'product ' . $column, $product ); ?>>
	<?php
	echo '<div class="product-thumb">';
	woocommerce_template_loop_product_link_open();
	do_action( 'woocommerce_before_shop_loop_item_title' );
	woocommerce_template_loop_product_link_close();
	// echo '<div class="product-action">';
	// woocommerce_template_loop_add_to_cart();
	// if ( ( Insight::setting( 'shop_archive_wishlist' ) == 1 ) && class_exists( 'WPcleverWoosw' ) ) {
	// 	echo '<div class="wishlist-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_html__( 'Add to wishlist', 'tm-organik' ) . '">' . do_shortcode( '[woosw id="' . $product_id . '" type="link"]' ) . '</div>';
	// }
	// if ( ( Insight::setting( 'shop_archive_quickview' ) == 1 ) && class_exists( 'WPcleverWoosq' ) ) {
	// 	echo '<div class="quick-view-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_html__( 'Quick view', 'tm-organik' ) . '">' . do_shortcode( '[woosq id="' . $product_id . '" type="link"]' ) . '</div>';
	// }
	// if ( ( Insight::setting( 'shop_archive_compare' ) == 1 ) && class_exists( 'WPcleverWooscp' ) ) {
	// 	echo '<div class="compare-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_html__( 'Compare', 'tm-organik' ) . '">' . do_shortcode( '[wooscp id="' . $product_id . '" type="link"]' ) . '</div>';
	// }
	// echo '</div>';
	echo '</div>';
	echo '<div class="product-info">';
	woocommerce_template_loop_product_link_open();
	do_action( 'woocommerce_shop_loop_item_title' );
	woocommerce_template_loop_product_link_close();
	woocommerce_template_loop_price();
	echo '<div class="product-rate">';
	woocommerce_template_loop_rating();
	if ( $product->get_rating_count() > 0 ) {
		echo '<span class="text-rating">' . sprintf( _n( '(Based on %s review)', '(Based on %s reviews)', $product->get_rating_count(), 'tm-organik' ), $product->get_rating_count() ) . '</span>';
	}
	echo '</div>';
	echo '<div class="product-desc">';
	woocommerce_template_single_excerpt();
	echo '</div>';
	echo '<div class="product-action-list">';
	woocommerce_template_loop_add_to_cart();
	if ( ( Insight::setting( 'shop_archive_wishlist' ) == 1 ) && class_exists( 'WPcleverWoosw' ) ) {
		echo '<div class="wishlist-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_html__( 'Add to wishlist', 'tm-organik' ) . '">' . do_shortcode( '[woosw id="' . $product_id . '" type="link"]' ) . '</div>';
	}
	if ( ( Insight::setting( 'shop_archive_quickview' ) == 1 ) && class_exists( 'WPcleverWoosq' ) ) {
		echo '<div class="quick-view-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_html__( 'Quick view', 'tm-organik' ) . '">' . do_shortcode( '[woosq id="' . $product_id . '" type="link"]' ) . '</div>';
	}
	if ( ( Insight::setting( 'shop_archive_compare' ) == 1 ) && class_exists( 'WPcleverWooscp' ) ) {
		echo '<div class="compare-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_html__( 'Compare', 'tm-organik' ) . '">' . do_shortcode( '[wooscp id="' . $product_id . '" type="link"]' ) . '</div>';
	}
	echo '</div>';
	echo '</div>';
	?>
</div>
