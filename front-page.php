<?php

/* 
 * Copyright (c) 2015 Jordan Kanter. All rights reserved. 
 */
  
  $template_class = get_the_title(); // Should be 'Splash', 
  // get the splash data
  $splash_data = get_option( 'preschoolexpansion_settings' );
  // render the three sections 
  get_header();
  // this loop might not be necessary...
  while (have_posts()): the_post();
  ?>
  <!-- start content layout -->
  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #f4f4f4;" class="container">
    <!-- start space -->
    <tr>
      <td valign="top" height="49">
      </td>
    </tr>
    <!-- end space -->
    <?php preschoolexpansion_render_section_template(strtolower($template_class), '1'); ?>
     <!-- start space -->
     <tr>
        <td valign="top" height="47">
        </td>
     </tr>
     <!-- end space -->
     <?php preschoolexpansion_render_section_template(strtolower($template_class), '2'); ?>
     <!-- start space -->
     <tr>
        <td valign="top" height="47">
        </td>
     </tr>
     <!-- end space -->
     <?php preschoolexpansion_render_section_template(strtolower($template_class), '3'); ?>
     <!-- start space -->
     <tr>
        <td valign="top" height="45">
        </td>
     </tr>
     <!-- end space -->
  </table>
  <!-- end content layout -->
  <?php
  get_footer();
  endwhile;
?>