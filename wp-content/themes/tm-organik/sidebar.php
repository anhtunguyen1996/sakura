<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tm-organik
 */

if ( is_page() && Insight_Helper::get_post_meta( 'page_sidebar' ) != 'default' ) {
	$page_sidebar = Insight_Helper::get_post_meta( 'page_sidebar' );
} else {
	$page_sidebar = 'sidebar';
}
if ( is_active_sidebar( $page_sidebar ) ) {
	?>
    <div id="sidebar"
         class="sidebar col-md-3 <?php echo esc_attr( Insight::setting( 'hide_sidebar_mobile' ) == 1 ? 'hidden-sm hidden-xs' : '' ); ?>">
        <div id="secondary" class="widget-area">
			<?php dynamic_sidebar( $page_sidebar ); ?>
        </div>
    </div>
<?php }
