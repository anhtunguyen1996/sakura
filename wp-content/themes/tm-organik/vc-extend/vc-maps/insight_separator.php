<?php

class WPBakeryShortCode_Insight_Separator extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Separator', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_separator',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'Default color', 'tm-organik' ) => 'default',
				esc_html__( 'Custom color', 'tm-organik' )  => 'color'
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Icon Color', 'tm-organik' ),
			'param_name' => 'icon_color',
			'value'      => '#ffffff',
			'dependency' => array( 'element' => 'style', 'value' => array( 'color' ) )
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Line Color', 'tm-organik' ),
			'param_name' => 'color',
			'value'      => '#ffffff',
			'dependency' => array( 'element' => 'style', 'value' => array( 'color' ) )
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
