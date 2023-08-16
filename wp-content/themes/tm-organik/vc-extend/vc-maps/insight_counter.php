<?php

class WPBakeryShortCode_Insight_Counter extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Counter', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_counter',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Prefix', 'tm-organik' ),
			'param_name'  => 'prefix',
			'value'       => '+',
			'admin_label' => true,
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Number', 'tm-organik' ),
			'param_name'  => 'number',
			'value'       => '100',
			'min'         => 1,
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Suffix', 'tm-organik' ),
			'param_name'  => 'suffix',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Text', 'tm-organik' ),
			'param_name'  => 'text',
			'admin_label' => true,
		),
		array(
			'heading'    => esc_html__( 'Text align', 'tm-organik' ),
			'type'       => 'dropdown',
			'param_name' => 'text_align',
			'value'      => array(
				esc_html__( 'Left', 'tm-organik' )   => 'text-left',
				esc_html__( 'Center', 'tm-organik' ) => 'text-center',
				esc_html__( 'Right', 'tm-organik' )  => 'text-right',
			),
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
