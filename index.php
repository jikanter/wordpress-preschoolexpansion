<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package preschoolexpansion
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h2 class="heading2 page-title screen-reader-text"><?php single_post_title(); ?></h2>
				</header>
			<?php endif; ?>

			<?php /* Start the Loop */ ?>
			<?php 
                          if (have_posts()): 
                            while ( have_posts() ) : 
                              the_post(); 
                          ?>

				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
  
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php 
                         
                        endwhile; 
                        else:
                          echo apply_filters('the_content', get_option('404_content'), '<h2>Sorry</h2><p>The Page you were looking for could not be found. Please return to <a href="/">Home</a></p>');
                        endif;
                      ?>

			

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main> #main 
	</div> #primary 


<?php get_footer(); ?>