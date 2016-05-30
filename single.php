<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package birder
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div id="articles" class="articles-container">
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

				the_post_navigation( array(
					'prev_text' => '<span class="glyphicon glyphicon-chevron-left"></span>%title',
					'next_text' => '%title<span class="glyphicon glyphicon-chevron-right"></span>'
				) );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
			</div><!-- #articles -->


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
