<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-organik
 */

get_header();
if ( ( Insight_Helper::get_post_meta( 'page_layout' ) == 'default' ) || ( Insight_Helper::get_post_meta( 'page_layout' ) == '' ) ) {
	$layout = Insight::setting( 'page_layout' );
} else {
	$layout = Insight_Helper::get_post_meta( 'page_layout' );
}
?>
<?php Insight::page_title(); ?>
<?php Insight::breadcrumbs(); ?>
    <div class="container">
        <div id="primary" class="content-area row">
			<?php if ( is_active_sidebar( 'sidebar' ) && ( $layout == 'sidebar-content' ) ) {
				get_sidebar();
			} ?>
            <div
                    class="<?php echo esc_attr( is_active_sidebar( 'sidebar' ) && ( $layout == 'content-sidebar' || $layout == 'sidebar-content' ) ? 'col-md-9' : 'col-md-12' ); ?>">
				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'components/content', 'page' );
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
				?>
            </div>
			<?php if ( is_active_sidebar( 'sidebar' ) && ( $layout == 'content-sidebar' ) ) {
				get_sidebar();
			} ?>
        </div>
    </div>
<?php
get_footer();
