<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class ) . ' insight-our-services';

if ( $animation !== '' ) {
	$el_class .= ' tm-animation ' . $animation;
}

if ( $image ) {
	$image = Insight_Helper::img_fullsize( $image );
}
?>
<div class="<?php echo Insight_Helper::nice_class( $el_class ); ?>">
	<?php
	if ( $link != '' ) {
		echo '<a href="' . esc_url( $link ) . '">';
	} ?>
	<?php if ( ( $type == 'image' ) && ! empty( $image ) && is_string( $image ) ) { ?>
        <div class="image text-center">
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>">
        </div>
	<?php } else { ?>
        <div class="icon">
			<?php
			$icon_class = isset( ${'icon_' . $icon_lib} ) ? esc_attr( ${'icon_' . $icon_lib} ) : 'ionic';
			echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
			?>
        </div>
	<?php } ?>
    <div class="title">
		<?php echo esc_html( $title ); ?>
    </div>
    <div class="content">
		<?php echo esc_html( $content ); ?>
    </div>
	<?php
	if ( $link != '' ) {
		echo '<div class="more"><i class="ion-plus-round"></i></div>';
		echo '</a>';
	}
	?>
</div>