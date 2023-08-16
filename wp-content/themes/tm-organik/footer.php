<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tm-organik
 */

?>
</div><!-- /.content -->
<?php
// Footer section
if ( is_search() || ( Insight_Helper::get_post_meta( 'footer_visibility' ) == 'default' ) || ( Insight_Helper::get_post_meta( 'footer_visibility' ) == '' ) ) {
	$show_footer = Insight::setting( 'footer_visibility' );
} else {
	$show_footer = Insight_Helper::get_post_meta( 'footer_visibility' ) == 'visible' ? '1' : '0';
}
if ( $show_footer == '1' ) {
	get_template_part( 'components/footer' );
}

// Copyright section
if ( is_search() || ( Insight_Helper::get_post_meta( 'copyright_visibility' ) == 'default' ) || ( Insight_Helper::get_post_meta( 'copyright_visibility' ) == '' ) ) {
	$show_copyright = Insight::setting( 'copyright_visibility' );
} else {
	$show_copyright = Insight_Helper::get_post_meta( 'copyright_visibility' ) == 'visible' ? '1' : '0';
}
if ( $show_copyright == '1' ) {
	get_template_part( 'components/copyright' );
}
?>
</div><!-- /.site -->

<?php wp_footer(); ?>

</body>
</html>
