<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package tm-organik
 */

get_header(); ?>
    <div class="container">
        <div id="primary" class="content-area row">
            <div class="col-md-12">
                <div class="content-404">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/404.png' ); ?>"
                         alt="<?php bloginfo( 'name' ); ?>"/>
                    <h3><?php esc_html_e( 'Oops! This page is not available', 'tm-organik' ); ?></h3>
                    <span><?php echo sprintf( '%s <a href="%s">%s</a>', esc_html__( 'Please go back to', 'tm-organik' ), site_url(), esc_html__( 'Homepage', 'tm-organik' ) ); ?></span>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
