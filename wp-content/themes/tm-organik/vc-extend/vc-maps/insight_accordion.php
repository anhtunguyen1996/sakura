<?php

class WPBakeryShortCode_Insight_Accordion extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Accordion', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_accordion',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Icon Position', 'tm-organik' ),
			'param_name' => 'icon_position',
			'value'      => array(
				esc_html__( 'Right', 'tm-organik' ) => 'right',
				esc_html__( 'Left', 'tm-organik' )  => 'left',
				esc_html__( 'None', 'tm-organik' )  => 'none',
			),
		),
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Accordions', 'tm-organik' ),
			'param_name' => 'accordions',
			'params'     => array(
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Icon type', 'tm-organik' ),
					'param_name' => 'icon_type',
					'value'      => array(
						esc_html__( 'Default', 'tm-organik' ) => 'default',
						esc_html__( 'Custom', 'tm-organik' )  => 'custom'
					)
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon library', 'tm-organik' ),
					'std'         => 'ionicons',
					'value'       => array(
						esc_html__( 'Font Awesome', 'tm-organik' ) => 'fontawesome',
						esc_html__( 'Ionicons', 'tm-organik' )     => 'ionicons'

					),
					'param_name'  => 'icon_lib',
					'description' => esc_html__( 'Select icon library.', 'tm-organik' ),
					'dependency'  => array( 'element' => 'icon_type', 'value' => array( 'custom' ) ),
				),
				Insight_Helper::fonticon( 'fontawesome' ),
				Insight_Helper::fonticon( 'ionicons' ),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Name', 'tm-organik' ),
					'param_name'  => 'title',
					'value'       => '',
					'admin_label' => true
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Content', 'tm-organik' ),
					'param_name' => 'content',
					'value'      => ''
				),
			),
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
