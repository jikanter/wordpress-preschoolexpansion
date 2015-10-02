<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package preschoolexpansion
 */
get_header();
?>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #f4f4f4;" class="container">

  <?php if (have_posts()) : ?>

    <?php /* Start the Loop */ ?>
    <?php while (have_posts()) : the_post(); ?>

      <?php
        /**
         * Run the loop for the search to output the results.
         * If you want to overload this in a child theme then include a file
         * called content-search.php and that will be used instead.
         */
        get_template_part('template-parts/content', 'search');
      ?>

    <?php endwhile; ?>

  <?php else : ?>

    <?php get_template_part('template-parts/content', 'none'); ?>

  <?php endif; ?>
</table>

<?php get_footer(); ?>
