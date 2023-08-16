<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-product-info';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

$info = (array) vc_param_group_parse_atts( $info );

if ( count( $info ) > 0 ) {
	?>
    <div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
		<?php
		foreach ( $info as $item ) { ?>
            <div class="item">
                <div class="name"><?php echo esc_html( $item['name'] ); ?></div>
                <div class="value"><?php echo esc_html( $item['value'] ); ?></div>
            </div>
			<?php
		}
		?>
    </div>
<?php }
