<?php
/*
Template Name: Full Width
*/
get_header(); ?>

    <div id="primary" class="content-area">
        <main class="main">
			<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'components/content', 'page' );
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile; // End of the loop.
			?>
        </main>
    </div>
<?php
get_footer();
