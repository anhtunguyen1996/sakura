<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version     3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

if ( ( Insight_Helper::get_post_meta( 'page_layout' ) == 'default' ) || ( Insight_Helper::get_post_meta( 'page_layout' ) == '' ) ) {
	$layout = Insight::setting( 'shop_layout' );
} else {
	$layout = Insight_Helper::get_post_meta( 'page_layout' );
}
?>
<?php Insight::page_title(); ?>
<?php Insight::breadcrumbs(); ?>
<div class="container">
    <div id="primary" class="content-area row">
		<?php if ( is_active_sidebar( 'sidebar_shop' ) && ( $layout == 'sidebar-content' ) ) {
			do_action( 'woocommerce_sidebar' );
		} ?>
        <div
                class="<?php echo esc_attr( is_active_sidebar( 'sidebar_shop' ) && ( $layout == 'content-sidebar' || $layout == 'sidebar-content' ) ? 'col-md-9' : 'col-md-12' ); ?>">
			<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
			?>
			<?php
			if ( Insight::setting( 'shop_archive_category_slider' ) == 1 ) {
				woocommerce_output_product_categories( array(
					'before'    => '<div class="cats row">',
					'after'     => '</div>',
					'parent_id' => is_product_category() ? get_queried_object_id() : 0,
				) );
			}
			if ( woocommerce_product_loop() ) {
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();

						/**
						 * Hook: woocommerce_shop_loop.
						 *
						 * @hooked WC_Structured_Data::generate_product_data() - 10
						 */
						do_action( 'woocommerce_shop_loop' );

						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			}
			?>
        </div>
		<?php if ( is_active_sidebar( 'sidebar_shop' ) && ( $layout == 'content-sidebar' ) ) {
			do_action( 'woocommerce_sidebar' );
		} ?>
    </div>
</div>
<?php get_footer( 'shop' ); ?>
