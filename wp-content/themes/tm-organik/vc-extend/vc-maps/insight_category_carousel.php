<?php

class WPBakeryShortCode_Insight_Category_Carousel extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Category Carousel', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_category_carousel',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Testimonials', 'tm-organik' ),
			'param_name' => 'categories',
			'params'     => array(
				Insight_Helper::get_param( 'woo_categories_dropdown' ),
				array(
					'type'        => 'attach_image',
					'heading'     => 'Image',
					'param_name'  => 'image',
					'save_always' => true,
					'admin_label' => true
				),
			),
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
