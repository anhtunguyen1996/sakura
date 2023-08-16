<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Content Block Class
 *
 * @package Core
 */
class Insight_Posttypes {

	/**
	 * The constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ), 9 );
	}

	public function init() {
		add_filter( 'insight_posttypes', array( $this, 'insight_posttypes' ) );
		add_filter( 'insight_taxonomy', array( $this, 'insight_taxonomy' ) );
	}

	public function insight_posttypes() {

		if ( empty( $posttypes ) ) {
			$posttypes = array();
		}

		// Gallery
		$posttypes['gallery'] = array(
			'labels'        => array(
				'name'          => esc_html__( 'Gallery Image', 'tm-organik' ),
				'singular_name' => esc_html__( 'Gallery Image Item', 'tm-organik' ),
				'add_item'      => esc_html__( 'New Gallery Image Item', 'tm-organik' ),
				'add_new_item'  => esc_html__( 'Add New Gallery Image Item', 'tm-organik' ),
				'edit_item'     => esc_html__( 'Edit Gallery Image Item', 'tm-organik' )
			),
			'public'        => false,
			'has_archive'   => false,
			'rewrite'       => array( 'slug' => 'ic_gallery' ),
			'menu_position' => 4,
			'show_ui'       => true,
			'supports'      => array(
				'author',
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'page-attributes',
			),
		);

		return $posttypes;
	}

	public function insight_taxonomy() {

		if ( empty( $taxonomy ) ) {
			$taxonomy = array();
		}

		// Gallery category
		$taxonomy['gallery_category'] = array(
			array( 'gallery' ),
			array(
				'hierarchical' => false,
				'labels'       => array(
					'name'              => esc_html__( 'Gallery Categories', 'tm-organik' ),
					'singular_name'     => esc_html__( 'Gallery Category', 'tm-organik' ),
					'search_items'      => esc_html__( 'Search Gallery Categories', 'tm-organik' ),
					'all_items'         => esc_html__( 'All Gallery Categories', 'tm-organik' ),
					'parent_item'       => esc_html__( 'Parent Gallery Category', 'tm-organik' ),
					'parent_item_colon' => esc_html__( 'Parent Gallery Category:', 'tm-organik' ),
					'edit_item'         => esc_html__( 'Edit Gallery Category', 'tm-organik' ),
					'update_item'       => esc_html__( 'Update Gallery Category', 'tm-organik' ),
					'add_new_item'      => esc_html__( 'Add New Gallery Category', 'tm-organik' ),
					'new_item_name'     => esc_html__( 'New Gallery Category Name', 'tm-organik' ),
					'menu_name'         => esc_html__( 'Gallery Categories', 'tm-organik' ),
				),
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => array( 'slug' => 'ic_gallery_category' ),
			),
		);

		return $taxonomy;
	}

}

new Insight_Posttypes;
