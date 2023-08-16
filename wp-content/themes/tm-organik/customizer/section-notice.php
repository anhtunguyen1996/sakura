<?php
$section  = 'notice';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'notice_cookie_enable',
	'label'       => esc_html__( 'Cookie notice', 'tm-organik' ),
	'description' => esc_html__( 'The notice about cookie auto show when a user visits the site.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'textarea',
	'settings'    => 'notice_cookie_message',
	'label'       => esc_html__( 'Cookie message', 'tm-organik' ),
	'description' => esc_html__( 'Use the link with the class "cookie_notice_ok" to hide the notice.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => __( 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it. <a class="cookie_notice_ok">OK, GOT IT</a>', 'tm-organik' ),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'notice_cart_enable',
	'label'       => esc_html__( 'Added to cart notice', 'tm-organik' ),
	'description' => esc_html__( 'Enable the notice when added one product to cart successful.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );