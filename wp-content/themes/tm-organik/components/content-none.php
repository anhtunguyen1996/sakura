<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-organik
 */

?>

<section class="no-results not-found">
    <h2 class="entry-title">
		<?php esc_html_e( 'Nothing Found', 'tm-organik' ); ?>
    </h2>
    <div class="entry-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
            <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'tm-organik' ), 'insight-a' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'tm-organik' ); ?></p>
		<?php
		else : ?>
            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'tm-organik' ); ?></p>
			<?php
			get_search_form();
		endif; ?>
    </div>
</section><!-- .no-results -->
