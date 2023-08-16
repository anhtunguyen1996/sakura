<?php
$section  = 'title_breadcrumbs';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'title_visibility',
	'label'       => esc_html__( 'Title visibility', 'tm-organik' ),
	'description' => esc_html__( 'Show/hide the title by default. You also can show/hide the title for each page by settings in Page Options.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'breadcrumbs_visibility',
	'label'       => esc_html__( 'Breadcrumbs visibility', 'tm-organik' ),
	'description' => esc_html__( 'Show/hide the breadcrumbs by default. You also can show/hide the breadcrumbs for each page by settings in Page Options.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'page_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Style', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'typography',
	'settings'  => 'page_title_typo',
	'label'     => esc_html__( 'Font family', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => array(
		'font-family'    => Insight::SECONDARY_FONT,
		'variant'        => 'regular',
		'color'          => '#ffffff',
		'font-size'      => '56px',
		'line-height'    => '1.5',
		'letter-spacing' => '0em',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'    => array(
		array(
			'element' => '.page-title .title, .page-title-style',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'page_title_padding_top',
	'label'     => esc_html__( 'Padding top', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 110,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.page-title',
			'property' => 'padding-top',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'page_title_padding_bottom',
	'label'     => esc_html__( 'Padding bottom', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 170,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.page-title',
			'property' => 'padding-bottom',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'color-alpha',
	'settings'    => 'page_title_bg_color',
	'label'       => esc_html__( 'Background', 'tm-organik' ),
	'description' => esc_html__( 'Controls the color of title background.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => '#7fca90',
	'output'      => array(
		array(
			'element'  => '.page-title',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'image',
	'settings'    => 'page_title_bg_img',
	'label'       => esc_html__( 'Background Image', 'tm-organik' ),
	'description' => esc_html__( 'Select an image file for title background.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => INSIGHT_THEME_URI . '/assets/images/big_title_bg_1.png',
	'transport'   => 'postMessage',
	'output'      => array(
		array(
			'element'  => '.page-title',
			'property' => 'background-image'
		),
	),
) );