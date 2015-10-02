<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @description the same as the page templates, but outputs a date
 * @package preschoolexpansion
 * 
 * TODO: Add the comment section back to the template
 */

get_header(); ?>
 <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #f4f4f4;" class="container">
    
    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'template-parts/content', 'single' ); ?>
                  
    <?php endwhile; // End of the loop. ?>

<?php // removed the get_sidebar() call for now, we may want that back ?>
<?php get_footer(); ?>
