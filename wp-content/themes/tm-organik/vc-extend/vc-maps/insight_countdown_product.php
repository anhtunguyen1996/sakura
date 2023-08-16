<?php

class WPBakeryShortCode_Insight_Countdown_Product extends WPBakeryShortCode {
}

$group_label = esc_html__( 'Label options', 'tm-organik' );

vc_map( array(
	'name'                      => esc_html__( 'Countdown Product Box', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_countdown_product',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Products', 'tm-organik' ),
			'param_name' => 'products',
			'params'     => array(
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Image', 'tm-organik' ),
					'param_name'  => 'product_image',
					'admin_label' => true,
				),
				Insight_Helper::get_param( 'sale_products' ),
			),
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Day (Singular)',
			'value'      => 'Day',
			'param_name' => 'day_singular',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Days (Plural)',
			'value'      => 'Days',
			'param_name' => 'days_plural',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Hour (Singular)',
			'value'      => 'Hour',
			'param_name' => 'hour_singular',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Hours (Plural)',
			'value'      => 'Hours',
			'param_name' => 'hours_plural',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Minute (Singular)',
			'value'      => 'Minute',
			'param_name' => 'minute_singular',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Minutes (Plural)',
			'value'      => 'Minutes',
			'param_name' => 'minutes_plural',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Second (Singular)',
			'value'      => 'Second',
			'param_name' => 'second_singular',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Seconds (Plural)',
			'value'      => 'Seconds',
			'param_name' => 'seconds_plural',
			'group'      => $group_label,
		),
		Insight_Helper::get_param( 'note' ),
	)
) );
