<?php

class WPBakeryShortCode_Insight_Gallery extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Gallery', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_gallery',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'imgradio',
			'admin_label' => true,
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'value'       => array(
				'grid'    => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/gallery/grid.png',
					'title' => 'Grid',
				),
				'masonry' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/gallery/masonry.png',
					'title' => 'Masonry',
				),
				'std'     => 'grid',
			),
		),
		Insight_Helper::get_param( 'gallery_categories' ),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Order by',
			'param_name'  => 'order_by',
			'value'       => array(
				'Default'            => '',
				'Title'              => 'title',
				'Date'               => 'date',
				'Random'             => 'rand',
				'Comment count'      => 'comment_count',
				'Slug'               => 'slug',
				'ID'                 => 'id',
				'Last modified date' => 'modified',
				'Author'             => 'author',
			),
			'save_always' => true,
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Order',
			'param_name'  => 'order',
			'value'       => array(
				'Default' => '',
				'ASC'     => 'ASC',
				'DESC'    => 'DESC',
			),
			'save_always' => true,
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Number', 'tm-organik' ),
			'param_name' => 'number',
			'min'        => - 1,
			'suffix'     => esc_html__( 'Number of image(s) per page', 'tm-organik' ),
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Image Width', 'tm-organik' ),
			'param_name' => 'width',
			'min'        => 0,
			'value'      => 370,
			'suffix'     => esc_html__( 'px', 'tm-organik' ),
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Image Height', 'tm-organik' ),
			'param_name' => 'height',
			'value'      => 230,
			'min'        => 0,
			'suffix'     => esc_html__( 'px', 'tm-organik' ),
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
