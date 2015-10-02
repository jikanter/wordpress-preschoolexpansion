<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package preschoolexpansion
 * 
 * Don't use the standard header. We should never get there.
 */

get_header(); ?>
 <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #f4f4f4;" class="container">
  
   <?php while (have_posts()): the_post(); ?>
   
    <?php get_template_part('template-parts/content', 'page'); ?>
  
   <?php endwhile; // End of Loop ?>
   
 </table>

<?php get_footer(); ?>
