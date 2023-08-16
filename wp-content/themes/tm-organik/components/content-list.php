<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-organik
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'row blog-list-style' ); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
        <div class="col-md-5">
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'insight-post-list' ); ?>
                </a>
            </div>
        </div>
	<?php } ?>
    <div class="<?php echo esc_attr( has_post_thumbnail() ? 'col-md-7' : 'col-md-12 no-thumbnail' ); ?>">
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
    </div>
</div><!-- #post-## -->
