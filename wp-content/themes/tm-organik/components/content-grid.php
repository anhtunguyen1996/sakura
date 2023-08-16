<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-organik
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'col-md-4 blog-grid-style' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'full' ); ?>
            </a>
        </div>
	<?php endif; ?>
    <div class="entry-meta">
		<?php Insight_Templates::posted_on_list(); ?>
    </div>
    <a href="<?php the_permalink(); ?>"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></a>
    <div class="entry-content">
		<?php echo get_the_excerpt(); ?>
    </div>
    <div class="entry-more">
		<?php echo '<a href="' . get_permalink() . '">' . esc_html__( 'Read more', 'tm-organik' ) . '</a>'; ?>
    </div>
</div><!-- #post-## -->
