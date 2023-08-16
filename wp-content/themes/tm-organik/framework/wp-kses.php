<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'wp_kses_allowed_html', 'tm_organik_wp_kses_allowed_html', 2, 99 );

function tm_organik_wp_kses_allowed_html( $allowedtags, $context ) {
	if ( $context == 'insight-default' ) {
		$allowedtags = array(
			'a'      => array(
				'id'     => array(),
				'class'  => array(),
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'title'  => array(),
			),
			'strong' => array(),
			'span'   => array(
				'id'    => array(),
				'class' => array(),
			),
			'i'      => array(
				'id'    => array(),
				'class' => array(),
			),
		);
	} elseif ( $context == 'insight-widget' ) {
		$allowedtags = array(
			'h3'      => array(
				'id'    => array(),
				'class' => array(),
			),
			'section' => array(
				'id'    => array(),
				'class' => array(),
			),
			'aside'   => array(
				'id'    => array(),
				'class' => array(),
			),
			'div'     => array(
				'id'    => array(),
				'class' => array(),
			),
			'span'    => array(
				'id'    => array(),
				'class' => array(),
			),
			'a'       => array(
				'id'     => array(),
				'class'  => array(),
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'title'  => array(),
			),
			'img'     => array(
				'src'   => array(),
				'alt'   => array(),
				'id'    => array(),
				'class' => array(),
			),
		);
	} elseif ( $context == 'insight-breadcrumbs' ) {
		$allowedtags = array(
			'ul' => array(
				'class' => array(),
			),
			'li' => array(
				'class' => array(),
			),
			'a'  => array(
				'id'     => array(),
				'class'  => array(),
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'title'  => array(),
			),
		);
	} elseif ( $context == 'insight-title' ) {
		$allowedtags = array(
			'h1'     => array(
				'id'    => array(),
				'class' => array(),
			),
			'h2'     => array(
				'id'    => array(),
				'class' => array(),
			),
			'h3'     => array(
				'id'    => array(),
				'class' => array(),
			),
			'a'      => array(
				'id'     => array(),
				'class'  => array(),
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'title'  => array(),
			),
			'span'   => array(
				'id'    => array(),
				'class' => array(),
			),
			'strong' => array(),
		);
	} elseif ( $context == 'insight-price' ) {
		$allowedtags = array(
			'span' => array(
				'id'    => array(),
				'class' => array(),
			),
			'ins'  => array(),
			'del'  => array(),
		);
	} elseif ( $context == 'insight-span' ) {
		$allowedtags = array(
			'span' => array( 'id' => array(), 'class' => array() ),
		);
	} elseif ( $context == 'insight-i' ) {
		$allowedtags = array(
			'i' => array( 'id' => array(), 'class' => array() ),
		);
	} elseif ( $context == 'insight-a' ) {
		$allowedtags = array(
			'a' => array(
				'id'     => array(),
				'class'  => array(),
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'title'  => array(),
			),
		);
	} elseif ( $context == 'insight-table' ) {
		$allowedtags = array(
			'tr' => array(
				'class' => array(),
			),
			'td' => array(
				'class' => array(),
			),
			'a'  => array(
				'id'     => array(),
				'class'  => array(),
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'title'  => array(),
			),
		);
	} elseif ( $context == 'insight-heading' ) {
		$allowedtags = array(
			'h1'     => array( 'id' => array(), 'class' => array() ),
			'h2'     => array( 'id' => array(), 'class' => array() ),
			'h3'     => array( 'id' => array(), 'class' => array() ),
			'h4'     => array( 'id' => array(), 'class' => array() ),
			'h5'     => array( 'id' => array(), 'class' => array() ),
			'h6'     => array( 'id' => array(), 'class' => array() ),
			'p'      => array( 'id' => array(), 'class' => array() ),
			'div'    => array( 'id' => array(), 'class' => array() ),
			'span'   => array( 'id' => array(), 'class' => array() ),
			'a'      => array(
				'id'     => array(),
				'class'  => array(),
				'href'   => array(),
				'target' => array(),
				'rel'    => array(),
				'title'  => array()
			),
			'strong' => array(),
		);
	}

	return $allowedtags;
}
