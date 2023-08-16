<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' ' . $style . ' insight-featured-product';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

// Get link
$link_html   = '';
$link        = vc_build_link( $link );
$link_url    = ( isset( $link['url'] ) ) ? $link['url'] : '';
$link_text   = ( isset( $link['title'] ) ) ? $link['title'] : '';
$link_target = ( isset( $link['target'] ) && ! empty( $link['target'] ) ) ? $link['target'] : '_self';
$link_rel    = ( isset( $link['rel'] ) && ! empty( $link['rel'] ) ) ? $link['rel'] : '';
if ( ! empty( $link_text ) ) {
	$link_html = '<a class="insight-btn small" href="' . $link_url . '" target="' . $link_target . '" rel="' . $link_rel . '">' . $link_text . '</a>';
}

// Get Image
$image_full = Insight_Helper::img_fullsize( $image );
$style_img  = '';
if ( ! empty( $image_full ) && is_string( $image_full ) && 'style-07' != $style ) {
	$style_img = 'background-image: url("' . $image_full . '");';
}

if ( ! empty( $box_bg_color ) ) {
	$style_img .= 'background-color: ' . $box_bg_color . ';';
}

$countdown_id = uniqid( 'insight-countdown-' );
$last         = $delimiter = '';

$prefix = uniqid();

$selector = uniqid( 'insight-' );
if ( ! empty( $style ) && ( 'default' != $style ) ) {
	Insight_Helper::apply_style( $style_img, '#' . $selector );
}
?>
<div id="<?php echo esc_attr( $selector ) ?>" class="<?php echo Insight_Helper::nice_class( $el_class ); ?>"
     style="background-color: <?php echo esc_attr( $box_bg_color ) ?>">
    <div class="insight-featured-product--box">
        <div class="insight-featured-product--box--content">
			<?php if ( empty( $style ) || 'default' == $style ): ?>
                <h3 class="title-1"
                    style="background-color: <?php echo esc_attr( $box_bg_color ) ?>"><?php echo esc_html( $title_1 ) ?></h3>
                <h1 class="title-2 special-heading"><?php echo esc_html( $title_2 ) ?></h1>
				<?php if ( ! empty( $title_3 ) ): ?>
                    <h4 class="title-3"><?php echo esc_html( $title_3 ) ?></h4>
				<?php endif; ?>
			<?php elseif ( 'style-04' == $style ): ?>
                <h3 class="title-1"><?php echo esc_html( $title_1 ) ?></h3>
                <h1 class="title-2"><?php echo esc_html( $title_2 ) ?></h1>
			<?php elseif ( 'style-05' == $style || 'style-06' == $style ): ?>
				<?php if ( ! empty( $link_url ) ): ?>
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ) ?>" rel="<?php echo esc_attr( $link_rel ) ?>">
				<?php endif; ?>
                <h5 class="title-1"><?php echo esc_html( $title_1 ) ?></h5>
                <h1 class="title-2"><?php echo esc_html( $title_2 ) ?></h1>
				<?php if ( ! empty( $title_3 ) ): ?>
                    <h5 class="title-3"><?php echo esc_html( $title_3 ) ?></h5>
				<?php endif; ?>
				<?php if ( ! empty( $link_url ) ): ?>
                    </a>
				<?php endif; ?>
			<?php elseif ( 'style-07' == $style ): ?>
                <h1 class="title-1 special-heading"><?php echo esc_html( $title_1 ) ?></h1>
                <h4 class="title-2"><?php echo esc_html( $title_2 ) ?></h4>
				<?php if ( ! empty( $title_3 ) ): ?>
                    <h1 class="title-3"><?php echo esc_html( $title_3 ) ?></h1>
				<?php endif; ?>
			<?php else: ?>
                <h3 class="title-1 special-heading"><?php echo esc_html( $title_1 ) ?></h3>
                <h4 class="title-2"><?php echo esc_html( $title_2 ) ?></h4>
			<?php endif; ?>
			<?php if ( ! empty( $content ) ): ?>
                <div class="text">
					<?php Insight_Helper::output( $content ); ?>
                </div>
			<?php endif; ?>

			<?php if ( 'style-07' == $style ): ?>
                <div class="countdown-container">
                    <div class="countdown" id="<?php echo esc_attr( $countdown_id ) ?>">
						<?php echo esc_html( $datetime ) ?>
                    </div>
                </div>
				<?php if ( ! empty( $price ) ): ?>
                    <div class="price">
						<?php Insight_Helper::output( $price ); ?>
                    </div>
				<?php endif; ?>
			<?php endif; ?>

			<?php Insight_Helper::output( $link_html ); ?>
        </div>
    </div>
	<?php
	if ( ! empty( $image ) && is_numeric( $image ) ) {
		echo wp_get_attachment_image( $image, 'full' );
	}
	if ( ! empty( $vertical_text ) ) { ?>
        <div class="vertical-text">
			<?php Insight_Helper::output( $vertical_text ); ?>
        </div>
	<?php } ?>
</div>

<?php if ( 'style-07' == $style ): ?>
    <script>
		jQuery( document ).ready( function() {
			var target = new Date( jQuery( '#<?php echo esc_attr( $countdown_id ) ?>' ).text() );
			var current = new Date();
			if ( target.getTime() < current.getTime() ) {
				document.getElementById( '<?php echo esc_attr( $countdown_id ) ?>' ).innerHTML = "";
				return;
			}

			countdown.resetLabels();
			countdown.setLabels(
				' millisecond| <span><?php echo '' . $second_singular ?></span></span>| <span><?php echo '' . $minute_singular ?></span> | <span><?php echo '' . $hour_singular ?></span> | <span><?php echo '' . $day_singular ?></span> | <span>week</span> | <span>month</span> | <span>year</span> | <span>decade</span> | <span>century</span> | <span>millennium</span>',
				' milliseconds| <span><?php echo '' . $seconds_plural ?></span> | <span><?php echo '' . $minutes_plural ?></span> | <span><?php echo '' . $hours_plural ?></span> | <span><?php echo '' . $days_plural ?></span> | <span>weeks</span> | <span>months</span> | <span>years</span> | <span>decades</span> | <span>centuries</span> | <span>millennia</span>',
				'<?php echo '' . $last ?>',
				'<?php echo '' . $delimiter ?>',
				'',
				function( n ) {
					if ( n < 10 ) {
						return '0' + n.toString();
					}
					return n.toString();
				} );
			var timerId<?php echo esc_attr( $prefix ) ?> =
				countdown(
					new Date( jQuery( '#<?php echo esc_attr( $countdown_id ) ?>' ).text() ),
					function( ts ) {
						if ( ts.hours === 0 ) {
							ts.hours = '0';
						}
						if ( ts.minutes === 0 ) {
							ts.minutes = '0';
						}
						if ( ts.seconds === 0 ) {
							ts.seconds = '0';
						}
						// if (ts.days === 0) {
						// 	ts.days = '0';
						// }
						document.getElementById( '<?php echo esc_attr( $countdown_id ) ?>' ).innerHTML = ts.toHTML( "div" );
					},
					countdown.HOURS + countdown.MINUTES + countdown.SECONDS );
		} );
    </script>
<?php endif; ?>
