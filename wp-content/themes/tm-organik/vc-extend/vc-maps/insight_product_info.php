<?php

class WPBakeryShortCode_Insight_Product_Info extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Product Info', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_product_info',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Info', 'tm-organik' ),
			'param_name' => 'info',
			'params'     => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Name', 'tm-organik' ),
					'param_name'  => 'name',
					'value'       => '',
					'admin_label' => true
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Value', 'tm-organik' ),
					'param_name' => 'value',
					'value'      => ''
				),
			),
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
