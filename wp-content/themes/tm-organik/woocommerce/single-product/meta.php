<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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
$post_id    = $post->ID;
$product_id = $product->get_id();
$cat_count  = is_array( get_the_terms( $post_id, 'product_cat' ) ) ? count( get_the_terms( $post_id, 'product_cat' ) ) : 1;
$tag_count  = is_array( get_the_terms( $post_id, 'product_tag' ) ) ? count( get_the_terms( $post_id, 'product_tag' ) ) : 1;

if ( ( Insight::setting( 'shop_single_wishlist' ) == 1 ) && class_exists( 'WPcleverWoosw' ) ) {
	echo '<div class="wishlist-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_html__( 'Add to wishlist', 'tm-organik' ) . '">' . do_shortcode( '[woosw id="' . $product_id . '" type="link"]' ) . '</div>';
}
if ( ( Insight::setting( 'shop_single_compare' ) == 1 ) && ( class_exists( 'WPcleverWooscp' ) || class_exists( 'WooSCP' ) ) ) {
	echo '<div class="compare-btn hint--top hint--rounded hint--bounce" aria-label="' . esc_html__( 'Compare', 'tm-organik' ) . '">' . do_shortcode( '[wooscp id="' . $product_id . '" type="link"]' ) . '</div>';
}
?>
<div class="product_meta_wrap">
    <table class="product_meta">
		<?php do_action( 'woocommerce_product_meta_start' );
		if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
            <tr class="product_meta_item sku_wrapper">
                <td class="label"><?php esc_html_e( 'SKU', 'tm-organik' ); ?></td>
                <td>
			<span class="sku" itemprop="sku">
				<?php echo esc_html( ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'tm-organik' ) ); ?>
			</span>
                </td>
            </tr>
		<?php endif;
		echo wp_kses( wc_get_product_category_list( $product_id, ', ', '<tr class="product_meta_item posted_in"><td class="label">' . _n( 'Category', 'Categories', $cat_count, 'tm-organik' ) . '</td><td> ', '</td></tr>' ), 'insight-table' );
		echo wp_kses( wc_get_product_tag_list( $product_id, ', ', '<tr class="product_meta_item tagged_as"><td class="label">' . _n( 'Tag', 'Tags', $tag_count, 'tm-organik' ) . '</td><td> ', '</td></tr>' ), 'insight-table' );
		if ( Insight::setting( 'shop_single_share' ) == 1 ) { ?>
            <tr class="product_meta_item share">
                <td class="label"><?php esc_html_e( 'Share', 'tm-organik' ); ?></td>
                <td>
                    <a target="_blank"
                       href="http://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink() ); ?>"><i
                                class="fab fa-facebook"></i></a> <a target="_blank"
                                                                   href="http://twitter.com/share?text=<?php echo rawurlencode( get_the_title() ); ?>&url=<?php echo rawurlencode( get_permalink() ); ?>"><i
                                class="fab fa-twitter"></i></a> <a target="_blank"
                                                                  href="https://plus.google.com/share?url=<?php echo rawurlencode( get_permalink() ); ?>"><i
                                class="fab fa-google-plus-g"></i></a>
                </td>
            </tr>
		<?php }
		do_action( 'woocommerce_product_meta_end' ); ?>
    </table>
</div>
