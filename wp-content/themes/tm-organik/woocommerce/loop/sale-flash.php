<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

if ( ! $product->is_in_stock() ) {
	echo '<span class="outofstock"><span>' . esc_html__( 'Out', 'tm-organik' ) . '</span>' . esc_html__( 'of stock', 'tm-organik' ) . '</span>';
} else {
	// echo '<div class="badges">';
	// //hot
	// if ( $product->is_featured() ) {
	// 	echo '<span class="hot">' . esc_html__( 'Hot', 'tm-organik' ) . '</span>';
	// }
	// //sale
	// if ( $product->is_on_sale() ) {
	// 	echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'tm-organik' ) . '</span>', $post, $product );
	// }
	// //new
	// $postdate      = get_the_time( 'Y-m-d', $product->get_id() );
	// $postdatestamp = strtotime( $postdate );
	// $newdays       = Insight::setting( 'shop_archive_new_days' );
	// if ( ( time() - ( 60 * 60 * 24 * $newdays ) ) < $postdatestamp ) {
	// 	echo '<span class="new">' . esc_html__( 'New', 'tm-organik' ) . '</span>';
	// }
	// echo '</div>';
}
?>
