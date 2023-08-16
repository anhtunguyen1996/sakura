<?php

class WPBakeryShortCode_Insight_Title extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Title', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_title',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Style', 'tm-organik' ),
			'param_name' => 'style_type',
			'value'      => array(
				esc_html__( 'Default', 'tm-organik' ) => '1',
				esc_html__( 'Style 2', 'tm-organik' ) => '2',
			),
		),
		Insight_Helper::get_param( 'title' ),
		array(
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Sub title enable', 'tm-organik' ),
			'param_name' => 'sub_title_enable',
			'value'      => '',
			'options'    => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' ),
				),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Sub title', 'tm-organik' ),
			'param_name'  => 'sub_title',
			'admin_label' => true,
			'dependency'  => array( 'element' => 'sub_title_enable', 'value' => array( 'yes' ) ),
		),
		array(
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Separator enable', 'tm-organik' ),
			'param_name' => 'separator_enable',
			'value'      => '',
			'options'    => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' ),
				),
			),
		),
		array(
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Leaf enable', 'tm-organik' ),
			'param_name' => 'leaf_enable',
			'value'      => '',
			'options'    => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' ),
				),
			),
			'dependency' => array( 'element' => 'sub_title_enable', 'value' => array( 'yes' ) ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Style Color', 'tm-organik' ),
			'param_name' => 'style',
			'value'      => array(
				esc_html__( 'Default color', 'tm-organik' )              => 'default',
				esc_html__( 'Default color (align left)', 'tm-organik' ) => 'default-left',
				esc_html__( 'Style 2', 'tm-organik' )                    => '2',
				esc_html__( 'Custom color', 'tm-organik' )               => 'color',
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'tm-organik' ),
			'param_name' => 'color',
			'value'      => '#ffffff',
			'dependency' => array( 'element' => 'style', 'value' => array( 'color' ) ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Separator Icon Color', 'tm-organik' ),
			'param_name' => 'separator_icon_color',
			'value'      => '#ffffff',
			'dependency' => array( 'element' => 'style', 'value' => array( 'color' ) ),
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	),
) );
