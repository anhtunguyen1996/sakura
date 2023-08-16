<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

// Get css class
$css_class = vc_shortcode_custom_css_class( $css );
$el_class  = $this->getExtraClass( $el_class ) . ' ' . $css_class . ' insight-process';

if ( $style == 'small-icon' ) {
	$el_class .= ' insight-process--small-icon';
}

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

// Get steps
$steps = vc_param_group_parse_atts( $steps );
if ( is_array( $steps ) && ! empty( $steps ) ):
	?>
    <div class="<?php echo Insight_Helper::nice_class( $el_class ) ?>">
		<?php
		foreach ( $steps as $key => $step ):
			extract( $step );
			?>

			<?php
			$icon_html = '';
			if ( in_array( $icon_type, array(
				'font-icons',
			) ) ) {
				$icon_class = isset( ${"icon_" . $icon_lib} ) ? esc_attr( ${"icon_" . $icon_lib} ) : 'ionic';
				$icon_html = "<i class='" . $icon_class . "' ></i>";
			} else {
				if ( isset( $custom_icon ) && is_numeric( $custom_icon ) ) {
					$icon_html = wp_get_attachment_image( $custom_icon, 'full' );
				}
			}
			?>

			<?php if ( $style == 'small-icon' ): ?>
            <div class="col-md-3 insight-process--small-icon--step step-<?php echo esc_attr( $key + 1 ) ?>">
                <div class="insight-process--small-icon--step--icon">
					<?php Insight_Helper::output( $icon_html ) ?>
                </div>
                <div class="insight-process--small-icon--step--content">
                    <div class="insight-process--small-icon--step--content--title">
						<?php echo esc_html( $title ) ?>
                    </div>
                    <div class="insight-process--small-icon--step--content--text">
						<?php Insight_Helper::output( $content ) ?>
                    </div>
                </div>
            </div>
		<?php else: ?>
			<?php if ( $key != 0 ): ?>
                <div class="step-line"></div>
			<?php endif; ?>
            <div class="insight-process--step step-<?php echo esc_attr( $key + 1 ) ?>">
                <div class="insight-process--step--icon">
					<?php Insight_Helper::output( $icon_html ) ?>
                    <span class="order"><?php echo esc_html( $key + 1 ) ?></span>
                </div>
                <div class="insight-process--step--title">
					<?php echo esc_html( $title ) ?>
                </div>
                <div class="insight-process--step--text">
					<?php Insight_Helper::output( $content ) ?>
                </div>
            </div>
		<?php endif; ?>
		<?php
		endforeach;
		?>
    </div>
<?php
endif;
