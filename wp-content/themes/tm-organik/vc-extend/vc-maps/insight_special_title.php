<?php

class WPBakeryShortCode_Insight_Special_Title extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Special Title', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_special_title',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Align', 'tm-organik' ),
			'param_name' => 'align',
			'value'      => array(
				esc_html__( 'Left', 'tm-organik' )  => 'left',
				esc_html__( 'Right', 'tm-organik' ) => 'right',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'tm-organik' ),
			'param_name'  => 'title',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Number', 'tm-organik' ),
			'param_name'  => 'number',
			'admin_label' => true,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
