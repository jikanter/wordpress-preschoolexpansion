<?php
/* 
 * Copyright (c) 2015 Jordan Kanter. All rights reserved. 
 */

$body_class = '1';
$splash = new splash_page_type();
splash_page_type::load_fields();
global $splash_data;
// What I want here is to query the value for 2 textboxes and an html area from the admin interface, 
// Each splash section should have it's own instance of 2 textboxes and an html area in the admin interface
// perhaps under the section "Splash Editor" or something.
//$content = new splash_page_section(the_ID(), array('name' => 'splash_page_section_' + $body_class)); // get the content here
?>

          <tr>
            <td align="center" valign="top" style="padding: 0 20px;">
              <table class="container" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td align="center" valign="top">
                    <img src="<?php echo(preschoolexpansion_theme_image('images/image' . $body_class . '.jpg')); ?>" width="560" alt="image1" class="container"/>
                  </td>
                </tr>
                <!-- start space -->
                <tr>
                  <td valign="top" height="50">
                  </td>
                </tr>
                <!-- end space -->
                <tr>
                  <td align="center" valign="top" style="padding: 0 20px;">
                    <h3 class="section-heading"><?php echo($splash_data['preschoolexpansion_text_field_0']); ?></h3>
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
                    <?php echo($splash_data['preschoolexpansion_textarea_field_1']); ?>
                  </td>
                </tr>
                <!-- start space -->
                <tr>
                  <td valign="top" height="44">
                  </td>
                </tr>
                <!-- end space -->
                <tr>
                  <td align="center" valign="top" >
                    <a href="<?php echo($splash_data['preschoolexpansion_text_link_field_1_5']); ?>"><img class="container" src="<?php echo(preschoolexpansion_theme_image('images/link-img.png')); ?>" width="69" alt="link-img" /></a>
                  </td>
                </tr>
                <!-- start space -->
                <tr>
                  <td valign="top" height="54">
                  </td>
                </tr>
                <!-- end space -->
              </table>
            </td>
          </tr>
