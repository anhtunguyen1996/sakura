<?php

class WPBakeryShortCode_Insight_Button extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Button', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_button',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Link', 'tm-organik' ),
			'param_name'  => 'link',
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => 'Style',
			'param_name'  => 'style',
			'value'       => array(
				'Default' => 'default',
				'Brown'   => 'brown',
				'Arrow'   => 'arrow',
			),
			'save_always' => true,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
