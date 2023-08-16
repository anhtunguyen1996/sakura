<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-organik
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
		<?php if ( 'post' === get_post_type() ) : ?>
			<?php get_template_part( 'components/content', 'meta' ); ?>
		<?php endif; ?>
    </header>
    <div class="entry-summary">
		<?php the_excerpt(); ?>
    </div>
	<?php get_template_part( 'components/content', 'footer' ); ?>
</article>
