<?php

class WPBakeryShortCode_Insight_Featured_Category extends WPBakeryShortCode {
}

vc_map( array(
		'name'                      => esc_html__( 'Featured Category', 'tm-organik' ),
		'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
		'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
		'base'                      => 'insight_featured_category',
		'icon'                      => 'tm-shortcode-ico default-icon',
		'allowed_container_element' => 'vc_row',
		'params'                    => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'tm-organik' ),
				'param_name' => 'style',
				'std'         => '01',
				'value'      => array(
					esc_html__( 'Style 01', 'tm-organik' ) => '01',
					esc_html__( 'Style 02', 'tm-organik' ) => '02',
				),
			),
			array(
				'type'        => 'attach_image',
				'heading'     => 'Image',
				'param_name'  => 'image',
				'save_always' => true,
				'admin_label' => true,
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => 'Background Color',
				'param_name' => 'color',
			),
			Insight_Helper::get_param( 'woo_categories_dropdown' ),
			Insight_Helper::get_param( 'el_class' ),
			Insight_Helper::get_param( 'animation' ),
			Insight_Helper::get_param( 'note' ),
		),
	)
);
