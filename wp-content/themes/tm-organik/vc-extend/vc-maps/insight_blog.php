<?php

class WPBakeryShortCode_Insight_Blog extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Blog', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_blog',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'imgradio',
			'admin_label' => true,
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'value'       => array(
				'list'             => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/blog/blog_list.jpg',
					'title' => 'List',
				),
				'grid'             => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/blog/blog_grid.png',
					'title' => 'Grid',
				),
				'grid_has_padding' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/blog/blog_grid-padding.png',
					'title' => 'Grid has padding',
				),
			),
			'std'         => 'list',
			'admin_label' => true,
		),
		array(
			'type'        => 'colorpicker',
			'class'       => '',
			'heading'     => 'Item Background Color',
			'param_name'  => 'item_bg_color',
			'dependency'  => array( 'element' => 'style', 'value' => array( 'grid_has_padding' ) ),
			'admin_label' => true,
		),
		Insight_Helper::get_param( 'categories' ),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Order by',
			'param_name'  => 'order_by',
			'value'       => array(
				'Default'            => '',
				'Date'               => 'date',
				'Post ID'            => 'ID',
				'Author'             => 'author',
				'Last modified date' => 'modified',
				'Random order'       => 'rand',
				'Title'              => 'title',
				'Comment count'      => 'comment_count',
				'Menu order'         => 'menu_order',
			),
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Order',
			'param_name'  => 'order',
			'value'       => array(
				'Default'    => '',
				'Descending' => 'DESC',
				'Ascending'  => 'ASC',
			),
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Number', 'tm-organik' ),
			'param_name'  => 'number',
			'min'         => 0,
			'suffix'      => esc_html__( 'Number of post (0 is all)', 'tm-organik' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Excerpt length', 'tm-organik' ),
			'param_name'  => 'excerpt_length',
			'min'         => 0,
			'max'         => 1000,
			'suffix'      => esc_html__( 'words(s)', 'tm-organik' ),
			'admin_label' => true,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
