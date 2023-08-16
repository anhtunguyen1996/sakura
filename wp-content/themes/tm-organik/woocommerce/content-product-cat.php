<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cat_color             = array(
	'#ebd3c3',
	'#bed4a0',
	'#e0d1a1',
	'#c6e6f6',
	'#c1c9e6',
	'#dfc2d5',
	'#9bd5b0',
	'#f8c9c2',
);
$shop_category_columns = get_option( 'woocommerce_catalog_columns', 3 );
$column                = 'col-md-' . ( 12 / $shop_category_columns );
$arr_rand              = array_rand( $cat_color, 1 );
?>
<div <?php wc_product_cat_class( $column, $category ); ?>>
    <div class="cat-wrap" style="background-color: <?php echo esc_attr( $cat_color[ $arr_rand ] ); ?>">
	    <?php
	    /**
	     * The woocommerce_before_subcategory hook.
	     *
	     * @hooked woocommerce_template_loop_category_link_open - 10
	     */
	    do_action( 'woocommerce_before_subcategory', $category );

	    /**
	     * The woocommerce_before_subcategory_title hook.
	     *
	     * @hooked woocommerce_subcategory_thumbnail - 10
	     */
	    do_action( 'woocommerce_before_subcategory_title', $category );

	    /**
	     * The woocommerce_shop_loop_subcategory_title hook.
	     *
	     * @hooked woocommerce_template_loop_category_title - 10
	     */
	    do_action( 'woocommerce_shop_loop_subcategory_title', $category );

	    /**
	     * The woocommerce_after_subcategory_title hook.
	     */
	    do_action( 'woocommerce_after_subcategory_title', $category );

	    /**
	     * The woocommerce_after_subcategory hook.
	     *
	     * @hooked woocommerce_template_loop_category_link_close - 10
	     */
	    do_action( 'woocommerce_after_subcategory', $category );
	    ?>
    </div>
</div>
