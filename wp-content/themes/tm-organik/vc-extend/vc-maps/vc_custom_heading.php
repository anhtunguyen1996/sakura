<?php
vc_add_params( 'vc_custom_heading', array(
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__( 'Custom color', 'tm-organik' ),
		'param_name' => 'cst_color',
		'value'      => array(
			esc_html__( 'Default', 'tm-organik' )         => '',
			esc_html__( 'Primary color', 'tm-organik' )   => 'pri-color',
			esc_html__( 'Secondary color', 'tm-organik' ) => 'nd-color',
		),
	),
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__( 'Special style', 'tm-organik' ),
		'param_name' => 'special_style',
		'value'      => array(
			esc_html__( 'None', 'tm-organik' )             => '',
			esc_html__( 'Page title style', 'tm-organik' ) => 'page-title-style',
		),
	),
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__( 'Text transform', 'tm-organik' ),
		'param_name' => 'text_transform',
		'value'      => array(
			esc_html__( 'None', 'tm-organik' )       => 'none',
			esc_html__( 'Capitalize', 'tm-organik' ) => 'capitalize',
			esc_html__( 'Uppercase', 'tm-organik' )  => 'uppercase',
			esc_html__( 'Lowercase', 'tm-organik' )  => 'lowercase',
			esc_html__( 'Initial', 'tm-organik' )    => 'initial',
			esc_html__( 'Inherit', 'tm-organik' )    => 'inherit',
		),
	),
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__( 'Font weight', 'tm-organik' ),
		'param_name' => 'font_weight',
		'value'      => array(
			esc_html__( 'Default', 'tm-organik' ) => '',
			100                                   => 100,
			200                                   => 200,
			300                                   => 300,
			400                                   => 400,
			500                                   => 500,
			600                                   => 600,
			700                                   => 700,
			800                                   => 800,
			900                                   => 900,
		),
	),
	array(
		'type'       => 'textfield',
		'heading'    => esc_html__( 'Letter spacing', 'tm-organik' ),
		'param_name' => 'letter_spacing',
	),
	Insight_Helper::get_param( 'animation' ),
	Insight_Helper::get_param( 'note' ),
) );

vc_map_update( 'vc_custom_heading', array(
	'category' => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'name'     => esc_html__( 'Custom Heading', 'tm-organik' ),
	'icon'     => 'tm-shortcode-ico default-icon',
) );
