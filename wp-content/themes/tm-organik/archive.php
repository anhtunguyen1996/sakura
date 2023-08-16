<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-organik
 */

get_header();
$layout = Insight::setting( 'archive_layout' );
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
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'components/content', 'list' );
					endwhile;
					Insight::paging_nav();
				else :
					get_template_part( 'components/content', 'none' );
				endif; ?>
            </div>
			<?php if ( is_active_sidebar( 'sidebar' ) && ( $layout == 'content-sidebar' ) ) {
				get_sidebar();
			} ?>
        </div>
    </div>
<?php
get_footer();
