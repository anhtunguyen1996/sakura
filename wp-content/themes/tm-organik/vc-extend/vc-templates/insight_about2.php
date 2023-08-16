<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' ' . $style . ' insight-about2';

// Get link
$link_html   = '';
$link        = vc_build_link( $link );
$link_url    = ( isset( $link['url'] ) ) ? $link['url'] : '';
$link_text   = ( isset( $link['title'] ) ) ? $link['title'] : '';
$link_target = ( isset( $link['target'] ) ) ? $link['target'] : '';
$link_rel    = ( isset( $link['rel'] ) ) ? $link['rel'] : '';
if ( ! empty( $link_text ) ) {
	$link_html = '<a class="link" href="' . $link_url . '" target="' . $link_target . '" rel="' . $link_rel . '"> <span class="ion-plus-round"></span> ' . $link_text . '</a>';
}

$selector_icon = uniqid( 'img-icon-' );
if ( $style == 'icon_on_small_image' ) {
	if ( ! empty( $img_icon_bg_color ) ) {
		$img_icon_bg_color = "background-color:" . $img_icon_bg_color;
		Insight_Helper::apply_style( $img_icon_bg_color, '#' . $selector_icon );
	}
}

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

// Get first letter
$first_title = ( ! empty( $title ) ) ? substr( $title, 0, 1 ) : '';
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
    <div id="<?php echo esc_attr( $selector_icon ) ?>" class="insight-about2--main-img">
	    <?php if ( ! empty( $link_url ) ) { ?>
		    <a href="<?php esc_url($link_url); ?>">
	    <?php } ?>
		<?php
		if ( $image > 0 ) {
			if ( ( $custom_image_size == 'yes' ) && ( $width > 0 ) && ( $height > 0 ) ) {
				echo wp_get_attachment_image( $image, array( $width, $height ) );
			} else {
				echo wp_get_attachment_image( $image, 'full' );
			}
		}
		?>
	    <?php if ( ! empty( $link_url ) ) { ?>
		    </a>
	    <?php } ?>
        <div class="insight-about2--main-img--first-title">
			<?php echo esc_html( $first_title ) ?>
        </div>
    </div>
    <div class="insight-about2--content">
        <div class="insight-about2--content--title">
            <h5><?php echo esc_html( $title ) ?></h5>
        </div>
        <div class="insight-about2--content--text">
            <p><?php Insight_Helper::output( $content ); ?></p>
        </div>
		<?php Insight_Helper::output( $link_html ); ?>
    </div>
</div>
