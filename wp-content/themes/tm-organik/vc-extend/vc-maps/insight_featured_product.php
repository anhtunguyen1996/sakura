<?php

class WPBakeryShortCode_Insight_Featured_Product extends WPBakeryShortCode {
}

$group_label = esc_html__( 'Label options', 'tm-organik' );

vc_map( array(
	'name'                      => esc_html__( 'Featured Product Box', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_featured_product',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'imgradio',
			'admin_label' => true,
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'value'       => array(
				'default'  => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/featured-product/1.png',
					'title' => 'Default',
				),
				'style-02' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/featured-product/2.png',
					'title' => 'Style 02',
				),
				'style-03' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/featured-product/3.png',
					'title' => 'Style 03',
				),
				'style-04' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/featured-product/4.png',
					'title' => 'Style 04',
				),
				'style-05' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/featured-product/5.png',
					'title' => 'Style 05',
				),
				'style-06' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/featured-product/6.png',
					'title' => 'Style 06',
				),
				'style-07' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/featured-product/7.png',
					'title' => 'Style 07',
				),
			),
			'std'         => 'default',
		),
		array(
			'type'        => 'attach_image',
			'heading'     => 'Image',
			'param_name'  => 'image',
			'save_always' => true,
		),
		array(
			'type'       => 'colorpicker',
			'class'      => '',
			'heading'    => 'Background Color',
			'param_name' => 'box_bg_color',
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title 1', 'tm-organik' ),
			'param_name'  => 'title_1',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title 2', 'tm-organik' ),
			'param_name'  => 'title_2',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title 3', 'tm-organik' ),
			'param_name'  => 'title_3',
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'style',
				'value'   => array( 'default', 'style-05', 'style-06', 'style-07' )
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Vertical Text', 'tm-organik' ),
			'param_name'  => 'vertical_text',
			'admin_label' => true,
		),
		Insight_Helper::get_param( 'content' ),
		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Button', 'tm-organik' ),
			'param_name' => 'link',
		),
		array(
			'type'        => 'datetimepicker',
			'class'       => '',
			'admin_label' => true,
			'heading'     => esc_html__( 'Target Time For Countdown', 'tm-organik' ),
			'param_name'  => 'datetime',
			'value'       => '',
			'description' => esc_html__( 'Date and time format (yyyy/mm/dd hh:mm).', 'tm-organik' ),
			'settings'    => array(
				'minDate' => 0,
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Price', 'tm-organik' ),
			'param_name'  => 'price',
			'admin_label' => true,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Day (Singular)',
			'value'      => 'Day',
			'param_name' => 'day_singular',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Days (Plural)',
			'value'      => 'Days',
			'param_name' => 'days_plural',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Hour (Singular)',
			'value'      => 'Hour',
			'param_name' => 'hour_singular',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Hours (Plural)',
			'value'      => 'Hours',
			'param_name' => 'hours_plural',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Minute (Singular)',
			'value'      => 'Minute',
			'param_name' => 'minute_singular',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Minutes (Plural)',
			'value'      => 'Minutes',
			'param_name' => 'minutes_plural',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Second (Singular)',
			'value'      => 'Second',
			'param_name' => 'second_singular',
			'group'      => $group_label,
		),
		array(
			'type'       => 'textfield',
			'class'      => '',
			'heading'    => 'Seconds (Plural)',
			'value'      => 'Seconds',
			'param_name' => 'seconds_plural',
			'group'      => $group_label,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
