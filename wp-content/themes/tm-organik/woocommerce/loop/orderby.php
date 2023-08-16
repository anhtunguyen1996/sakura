<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
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
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$shop_product_columns = get_option( 'woocommerce_catalog_columns', 4 );
$column               = 'col-md-' . ( 12 / $shop_product_columns );
?>
<div class="shop-filter-right col-md-6">
	<?php if ( Insight::setting( 'shop_archive_view_switch' ) == 1 ) { ?>
        <div class="switch-view">
		<span id="switch-view-list" class="switcher list hint--top hint--bounce hint--success"
              aria-label="<?php esc_html_e( 'List', 'tm-organik' ); ?>" rel="list"
              data-col="<?php echo esc_attr( $column ); ?>"><i
                    class="ion-navicon"></i></span> <span
                    id="switch-view-grid" class="switcher grid hint--top hint--bounce hint--success"
                    aria-label="<?php esc_html_e( 'Grid', 'tm-organik' ); ?>"
                    rel="grid" data-col="<?php echo esc_attr( $column ); ?>"><i class="ion-grid"></i></span>
        </div>
	<?php } ?>
    <form class="woocommerce-ordering" method="get">
        <select name="orderby" class="orderby">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>>
					<?php echo esc_html( $name ); ?>
                </option>
			<?php endforeach; ?>
        </select>
        <input type="hidden" name="paged" value="1"/>
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
    </form>
</div>
</div><!-- end .shop-filter -->
