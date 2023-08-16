<?php
$section  = 'logo';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => 'logo_title',
	'label'       => esc_html__( 'Logo title', 'tm-organik' ),
	'description' => esc_html__( 'Enter the text used as the title attribute.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => get_bloginfo( 'name' ),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => 'logo_alt',
	'label'       => esc_html__( 'Logo alt', 'tm-organik' ),
	'description' => esc_html__( 'Enter the text used as the alt attribute.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => get_bloginfo( 'description' ),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'logo_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Default logo', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'image',
	'settings'    => 'branding_logo_image',
	'label'       => esc_html__( 'Normal logo', 'tm-organik' ),
	'description' => esc_html__( 'Select an image file for your logo.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => INSIGHT_THEME_URI . '/assets/images/logo_dark.png',
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'logo_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Sticky', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'image',
	'settings'    => 'sticky_header_logo',
	'label'       => esc_html__( 'Sticky header logo', 'tm-organik' ),
	'description' => esc_html__( 'Select an image file for your sticky header logo.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => INSIGHT_THEME_URI . '/assets/images/logo_dark.png',
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'logo_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Mobile', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'image',
	'settings'    => 'mobile_logo',
	'label'       => esc_html__( 'Mobile logo', 'tm-organik' ),
	'description' => esc_html__( 'Select an image file for your logo.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => INSIGHT_THEME_URI . '/assets/images/logo_dark.png',
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'logo_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Overlay header', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'image',
	'settings'    => 'overlay_header_logo',
	'label'       => esc_html__( 'Overlay header logo', 'tm-organik' ),
	'description' => esc_html__( 'Select an image file for your logo.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => INSIGHT_THEME_URI . '/assets/images/logo_white.png',
) );
