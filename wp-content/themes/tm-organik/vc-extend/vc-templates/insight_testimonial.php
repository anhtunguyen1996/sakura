<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-testimonials';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$background_color = '';

if ( $style ) {
	$el_class .= ' style' . $style;
}

if ( $enable_carousel != 'true' ) {
	$el_class .= ' list';
}

$testimonials = (array) vc_param_group_parse_atts( $testimonials );
$uid          = uniqid( 'insight-testimonials-' );
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>" id="<?php echo esc_attr( $uid ); ?>">
	<?php foreach ( $testimonials as $testimonial ) { ?>
		<div class="item">
			<?php if ( $style === '9' && isset( $testimonial['background_color'] ) ) { ?>
			<div class="inner" style="background-color: <?php echo esc_attr( $testimonial['background_color'] ); ?>">
				<?php } ?>
				<div class="text">
					<?php if ( $style === '9' ) { ?>
						<div class="heading"><?php echo esc_html( $testimonial['heading'] ); ?></div>
					<?php } ?>
					<?php echo esc_html( $testimonial['content'] ); ?>
				</div>
				<div class="info">
					<?php if ( isset( $testimonial['photo'] ) && $testimonial['photo'] ) { ?>
						<div class="photo"><?php echo wp_get_attachment_image( $testimonial['photo'], 'full' ); ?></div>
					<?php } ?>
					<div class="author">
						<span class="name"><?php echo esc_html( $testimonial['name'] ); ?></span>
						<span class="tagline"><?php echo esc_html( $testimonial['tagline'] ); ?></span>
					</div>
				</div>
				<?php if ( $style === '9' && isset( $testimonial['background_color'] ) ) { ?>
			</div>
		<?php } ?>

		</div>
	<?php } ?>
</div>
<?php if ( $enable_carousel == 'true' ) { ?>
	<script>
		jQuery( document ).ready( function( $ ) {
			$( "#<?php echo esc_attr( $uid ); ?>" ).slick( {
				<?php if($style == 1) { ?>
				slidesToShow: 1,
				slidesToScroll: 1,
				<?php } else { ?>
				slidesToShow: <?php echo esc_js( $slides_to_display ); ?>,
				slidesToScroll: <?php echo esc_js( $slides_to_display ); ?>,
				<?php } ?>

				<?php if ( $enable_autoplay == 'true' ) { ?>
				autoplay: true,
				autoplaySpeed: 6000,
				<?php } else { ?>
				autoplay: false,
				<?php } ?>

				<?php if ( $display_bullets == 'true' ) { ?>
				dots: true,
				<?php } else { ?>
				dots: false,
				<?php } ?>

				<?php if ( $display_arrows == 'true' ) { ?>
				arrows: true,
				<?php } else { ?>
				arrows: false,
				<?php } ?>

				infinite: true,
				responsive: [
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
				]
			} );
		} );
	</script>
<?php } ?>
