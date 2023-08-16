<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tm-organik
 */

$shop_page_id = get_option( 'woocommerce_shop_page_id' );
if ( is_shop() && Insight_Helper::get_post_meta_by_id( $shop_page_id, 'page_sidebar' ) != 'default' ) {
	$shop_sidebar = Insight_Helper::get_post_meta_by_id( $shop_page_id, 'page_sidebar' );
} else {
	$shop_sidebar = 'sidebar_shop';
}

if ( is_active_sidebar( $shop_sidebar ) ) {
	?>
    <div id="sidebar"
         class="sidebar col-md-3 <?php echo esc_attr( Insight::setting( 'shop_hide_sidebar_mobile' ) == 1 ? 'hidden-sm hidden-xs' : '' ); ?>">
        <div id="secondary" class="widget-area">
			<?php dynamic_sidebar( $shop_sidebar ); ?>
        </div>
    </div>
<?php }
