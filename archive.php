<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package preschoolexpansion
 */

get_header(); ?>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #f4f4f4;" class="container">

		<?php if ( have_posts() ) : ?>

                                <tr>
				<?php
					the_archive_title( '<td><h1 class="page-title">', '</h1></td>' );
					the_archive_description( '<td><div class="taxonomy-description">', '</div></td>' );
				?>
                                </tr>		

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>
</table>
<?php get_footer(); ?>
