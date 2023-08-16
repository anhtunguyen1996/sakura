<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-organik
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'insight-post-full' ); ?>
            </a>
        </div>
	<?php endif;
	if ( 'post' === get_post_type() ) {
		get_template_part( 'components/content', 'meta' );
	}
	the_title( '<h1 class="entry-title">', '</h1>' );
	?>
    <div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'tm-organik' ), 'insight-span' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tm-organik' ),
			'after'  => '</div>',
		) );
		?>
    </div>
	<?php get_template_part( 'components/content', 'footer' ); ?>
</article><!-- #post-## -->
