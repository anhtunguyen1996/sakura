<?php
$section  = 'buttons';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'buttons_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Layout', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'buttons_style',
	'label'       => esc_html__( 'Style', 'tm-organik' ),
	'description' => esc_html__( 'Controls the position of the buttons to be in the top, left or right of the site.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 'flat',
	'choices'     => array(
		'3d'          => esc_html__( '3D', 'tm-organik' ),
		'flat'        => esc_html__( 'Flat', 'tm-organik' ),
		'transparent' => esc_html__( 'Transparent', 'tm-organik' ),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'buttons_shape',
	'label'       => esc_html__( 'Shape', 'tm-organik' ),
	'description' => esc_html__( 'Controls the position of the buttons to be in the top, left or right of the site.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 'square',
	'choices'     => array(
		'square'  => esc_html__( 'Square', 'tm-organik' ),
		'rounded' => esc_html__( 'Rounded', 'tm-organik' ),
		'pill'    => esc_html__( 'Pill', 'tm-organik' ),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'buttons_size',
	'label'       => esc_html__( 'Size', 'tm-organik' ),
	'description' => esc_html__( 'Controls the position of the buttons to be in the top, left or right of the site.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 'm',
	'choices'     => array(
		'xs' => esc_html__( 'Mini', 'tm-organik' ),
		's'  => esc_html__( 'Small', 'tm-organik' ),
		'm'  => esc_html__( 'Regular', 'tm-organik' ),
		'l'  => esc_html__( 'Large', 'tm-organik' ),
		'xl' => esc_html__( 'Extra Large', 'tm-organik' ),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'buttons_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Colors', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'button_text_color',
	'label'       => esc_html__( 'Text', 'tm-organik' ),
	'description' => esc_html__( 'Controls the color of all menu item links.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => '#fff',
	'output'      => array(
		array(
			'element'  => '.btn',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'button_background_color',
	'label'       => esc_html__( 'Background', 'tm-organik' ),
	'description' => esc_html__( 'Controls the color of all menu item links.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => Insight::SECONDARY_COLOR,
	'output'      => array(
		array(
			'element'  => '.btn',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'button_border_color',
	'label'       => esc_html__( 'Border', 'tm-organik' ),
	'description' => esc_html__( 'Controls the color of all menu item links.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => Insight::SECONDARY_COLOR,
	'output'      => array(
		array(
			'element'  => '.btn',
			'property' => 'border-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'buttons_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Hover colors', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'button_text_color_hover',
	'label'       => esc_html__( 'Text', 'tm-organik' ),
	'description' => esc_html__( 'Controls the color of all menu item links.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => '#fff',
	'output'      => array(
		array(
			'element'  => '.btn',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'button_background_color_hover',
	'label'       => esc_html__( 'Background', 'tm-organik' ),
	'description' => esc_html__( 'Controls the color of all menu item links.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => Insight::SECONDARY_COLOR,
	'output'      => array(
		array(
			'element'  => '.btn',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'button_border_color_hover',
	'label'       => esc_html__( 'Border', 'tm-organik' ),
	'description' => esc_html__( 'Controls the color of all menu item links.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => Insight::SECONDARY_COLOR,
	'output'      => array(
		array(
			'element'  => '.btn',
			'property' => 'border-color',
		),
	),
) );
