<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = vc_shortcode_custom_css_class( $css );

$el_class = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-team-member';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

if ( $image ) {
	$image = Insight_Helper::img_fullsize( $image );
}
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
    <figure>
		<?php if ( ! empty( $image ) && is_string( $image ) ) { ?>
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>">
		<?php } ?>
    </figure>
    <div>
		<?php if ( $name ) { ?>
            <h5 class="name"><?php echo '' . $name; ?></h5>
		<?php } ?>

		<?php if ( $biography ) { ?>
            <p class="biography"><?php echo '' . $biography; ?></p>
		<?php } ?>

		<?php $social_links_arr = $this->getSocialLinks( $atts ); ?>
		<?php if ( ! empty( $social_links_arr ) ) { ?>
            <ul class="social-list">
				<?php foreach ( $social_links_arr as $key => $link ) { ?>
                    <li class="<?php echo esc_attr( $key ); ?> hint--top hint--bounce"
                        aria-label="<?php echo ucfirst( esc_attr( $key ) ); ?>">
                        <a href="<?php echo esc_url( $link ) ?>"
                           target="<?php echo esc_attr( $link_new_page == 'yes' ? '_blank' : '_self' ); ?>">
                            <i class="fab fa-<?php echo esc_attr( $key ); ?>"></i>
                        </a>
                    </li>
				<?php } ?>
            </ul>
		<?php } ?>
    </div>
</div>
