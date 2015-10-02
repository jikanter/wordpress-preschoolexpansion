<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package preschoolexpansion
 * @description Adapted from the kidsox elementary template for the preschoolexpansion.org project
 */
?>
<tr>
  <td align="center" valign="top" style="padding: 0 20px;">
    <table class="container" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <!-- start space -->
      <tr>
        <td valign="top" height="50">
        </td>
      </tr>
      <!-- end space -->
      <tr>
        <td align="center" valign="top" style="padding: 0 20px;">
          <h3 class="section-heading <?php the_ID() ?>"><?php the_title() ?></h3>
          <span class="section-subheading"></span>
        </td>
      </tr>
      <!-- start space -->
      <tr>
        <td valign="top" height="20">
        </td>
      </tr>
      <!-- end space -->
      <tr>
        <td class="section-content" align="center" valign="top">
          <?php the_content(); ?>
        </td>
      </tr>
      <!-- start space -->
      <tr>
        <td valign="top" height="44">
        </td>
      </tr>
      <tr>
        <td valign="top" height="54">
        </td>
      </tr>
      <!-- end space -->
    </table>
  </td>
</tr>



