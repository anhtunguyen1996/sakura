<?php
$section  = 'navigation';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'navigation_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Typography', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'typography',
	'settings'  => 'menu_typo',
	'label'     => esc_html__( 'Font family', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => array(
		'font-family'    => Insight::PRIMARY_FONT,
		'variant'        => 'bold',
		'line-height'    => '1.5',
		'letter-spacing' => '0em',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'    => array(
		array(
			'element' => '.header .menu',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'menu_level_1_font_size',
	'label'     => esc_html__( 'Level 1 Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 14,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.header .menu',
			'property' => 'font-size',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'menu_level_2_font_size',
	'label'     => esc_html__( 'Level 2 Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 15,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.header .menu .sub-menu',
			'property' => 'font-size',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'navigation_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Spacing', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'navigation_lvl_1_padding_top',
	'label'     => esc_html__( 'Padding top', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 60,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '#menu .menu__container > li > a',
			'property' => 'padding-top',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'navigation_lvl_1_padding_bottom',
	'label'     => esc_html__( 'Padding bottom', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 60,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '#menu .menu__container > li > a',
			'property' => 'padding-bottom',
			'units'    => 'px',
		),
	),
) );


Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'navigation_lvl_1_padding_left',
	'label'     => esc_html__( 'Padding left', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 20,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '#menu .menu__container > li > a',
			'property' => 'padding-left',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'navigation_lvl_1_padding_right',
	'label'     => esc_html__( 'Padding right', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 20,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '#menu .menu__container > li > a',
			'property' => 'padding-right',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'navigation_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Color', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'menu_link_lv1_color',
	'label'     => esc_html__( 'Link normal', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::TEXT_COLOR,
	'output'    => array(
		array(
			'element'  => '.menu a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'menu_link_lv1_color_hover',
	'label'     => esc_html__( 'Link hover', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::PRIMARY_COLOR,
	'output'    => array(
		array(
			'element'  => '.menu a:hover',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'overlay_navigation_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Color for Overlay Header', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'overlay_menu_link_lv1_color',
	'label'     => esc_html__( 'Link normal', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#fff',
	'output'    => array(
		array(
			'element'  => implode( ',', array(
				'.overlay-header .header .menu a',
				'.overlay-header header.header .header-left .header-call *',
				'.overlay-header header.header .header-left .header-call span',
				'.overlay-header .header-right .mini-cart .mini-cart-icon',
				'.overlay-header header.header .mini-cart .mini-cart-text',
				'.overlay-header .header-right .mini-cart .mini-cart-text .mini-cart-total',
			) ),
			'property' => 'color',
		),

	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'overlay_menu_link_lv1_color_hover',
	'label'     => esc_html__( 'Link hover', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::PRIMARY_COLOR,
	'output'    => array(
		array(
			'element'  => '.overlay-header .header .menu a:hover',
			'property' => 'color',
		),
	),
) );
