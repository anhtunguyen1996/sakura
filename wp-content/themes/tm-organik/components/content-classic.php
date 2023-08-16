<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'blog-classic-style' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'insight-post-full' ); ?>
			</a>
		</div>
	<?php endif; ?>
	<div class="entry-desc">
		<div class="entry-meta">
			<?php Insight_Templates::posted_on_list(); ?>
		</div>
		<a href="<?php the_permalink(); ?>"><?php the_title( '<h4 class="entry-title">', '</h4>' ); ?></a>
		<div class="entry-content">
			<?php echo get_the_excerpt(); ?>
		</div>
		<div class="row">
			<div class="entry-more col-md-6">
				<?php echo '<a class="insight-btn" href="' . get_permalink() . '">' . esc_html__( 'Read more', 'tm-organik' ) . '</a>'; ?>
			</div>
			<div class="entry-share col-md-6">
					<span>
					<i class="ion-android-share-alt"></i> <?php esc_html_e( 'Share this post', 'tm-organik' ); ?>
						</span>
				<span>
					<a target="_blank"
					   href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>"><i
							class="fab fa-facebook"></i></a>
				</span>
				<span>
					<a target="_blank"
					   href="http://twitter.com/share?text=<?php echo urlencode( get_the_title() ); ?>&url=<?php echo urlencode( get_permalink() ); ?>"><i
							class="fab fa-twitter"></i></a>
				</span>
				<span>
					<a target="_blank"
					   href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ); ?>"><i
							class="fab fa-google-plus-g"></i></a>
				</span>
			</div>
		</div>
	</div>

</div><!-- #post-## -->
