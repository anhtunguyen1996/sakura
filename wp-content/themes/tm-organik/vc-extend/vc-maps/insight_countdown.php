<?php

class WPBakeryShortCode_Insight_Countdown extends WPBakeryShortCode {
}

$group_label = esc_html__( 'Label options', 'tm-organik' );

vc_map( array(
	'name'                      => esc_html__( 'Countdown', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_countdown',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'std'         => 'default',
			'value'       => array(
				esc_html__( 'Default', 'tm-organik' ) => 'default',
				esc_html__( 'Small', 'tm-organik' )   => 'small',

			),
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Color', 'tm-organik' ),
			'param_name'  => 'color',
			'std'         => 'white',
			'value'       => array(
				esc_html__( 'White', 'tm-organik' )   => 'white',
				esc_html__( 'Primary', 'tm-organik' ) => 'primary',
				esc_html__( 'Dark', 'tm-organik' )    => 'dark',

			),
			'admin_label' => true,
		),
		array(
			'type'        => 'datetimepicker',
			'class'       => '',
			'admin_label' => true,
			'heading'     => esc_html__( 'Target Time For Countdown', 'tm-organik' ),
			'param_name'  => 'datetime',
			'value'       => '',
			'description' => esc_html__( 'Date and time format (yyyy/mm/dd hh:mm).', 'tm-organik' ),
			'settings'    => array(
				'minDate' => 0,
			),
		),

		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),

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
	),
) );
