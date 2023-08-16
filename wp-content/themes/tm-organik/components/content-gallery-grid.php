<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tm-organik
 */
$terms = get_the_terms( get_the_ID(), 'gallery_category' );

$terms_slugs = array();
$terms_names = array();

foreach ( $terms as $term ) {
	$terms_slugs[] = $term->slug;
	$terms_names[] = $term->name;
}
?>

<div
        id="post-<?php the_ID(); ?>" <?php post_class( 'insight-gallery-item ' . esc_attr( implode( ' ', $terms_slugs ) ) . ' ' . Insight_Helper::$class_name ); ?>>
	<?php if ( has_post_thumbnail() ) :
		$img_id = get_post_thumbnail_id( get_the_ID() ); ?>
        <div class="insight-gallery-image">
            <a href="<?php echo esc_url( Insight_Helper::img_fullsize( $img_id ) ) ?>">
				<?php if ( ! empty( $img_id ) && is_numeric( $img_id ) ) {
					echo wp_get_attachment_image( $img_id, array(
						Insight_Helper::$img_width,
						Insight_Helper::$img_height
					) );
				} ?>
                <div class="desc-wrap">
                    <div class="desc">
                        <span class="icon ion-android-search"></span>
                        <div class="title">
							<?php the_title() ?>
                        </div>
                        <div class="cates">
							<?php echo esc_html( implode( ', ', $terms_names ) ); ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>
	<?php endif; ?>
</div><!-- #post-## -->
