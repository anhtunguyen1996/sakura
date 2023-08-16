<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package   InsightFramework
 */
class Insight_Extras {

	/**
	 * The constructor.
	 */
	public function __construct() {
		// Adds custom classes to the array of body classes.
		add_filter( 'body_class', array( $this, 'body_classes' ) );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	public function body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Setup page layout use class
		if ( is_page() ) {
			// Add class by customizer
			$classes[] = 'page--' . Insight::setting( 'page_layout' );
			// Add class by page options
			$classes[] = 'page-private--' . Insight_Helper::get_post_meta( 'page_layout' );
		}

		// Setup page overlay header class
		if ( is_page() ) {
			// Add class by page options
			if ( Insight_Helper::get_post_meta( 'overlay_header' ) == 'yes' ) {
				$classes[] = 'overlay-header';
			}

			// Page padding
			if ( Insight_Helper::get_post_meta( 'page_padding' ) == 'no' ) {
				$classes[] = 'no-padding';
			}
		}

		// Setup post layout use class
		if ( is_single() ) {
			$classes[] = 'post--' . Insight::setting( 'post_layout' );
		}

		if ( ! is_search() && Insight_Helper::get_post_meta( 'body_class' ) != '' ) {
			$classes[] = Insight_Helper::get_post_meta( 'body_class' );
		}

		$classes[] = 'tm-organik';

		return $classes;
	}
}
