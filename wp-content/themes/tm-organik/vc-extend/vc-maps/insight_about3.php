<?php

class WPBakeryShortCode_Insight_About3 extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'About 3', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_about3',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'attach_image',
			'heading'     => 'Image 1',
			'param_name'  => 'image1',
			'save_always' => true,
		),
		array(
			'type'        => 'attach_image',
			'heading'     => 'Image 2',
			'param_name'  => 'image2',
			'save_always' => true,
		),
		array(
			'type'        => 'attach_image',
			'heading'     => 'Image 3',
			'param_name'  => 'image3',
			'save_always' => true,
		),
		array(
			'type'        => 'attach_image',
			'heading'     => 'Image 4',
			'param_name'  => 'image4',
			'save_always' => true,
		),

		Insight_Helper::get_param( 'title' ),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Sub title', 'tm-organik' ),
			'param_name'  => 'sub_title',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Quote text', 'tm-organik' ),
			'param_name'  => 'quote_text',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Quote author', 'tm-organik' ),
			'param_name'  => 'quote_author',
			'value'       => '',
			'admin_label' => true,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
