<?php
/* 
 * Copyright (c) 2015 Jordan Kanter. All rights reserved. 
 */
$body_class = '2';
$content = ""; // get the content here
global $splash_data;
?>
<tr>
            <td align="center" valign="top" style="padding: 0 20px;">
              <table class="container" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td align="center" valign="top">
                    <img src="<?php echo(preschoolexpansion_theme_image('images/image' . $body_class . '.jpg')); ?>" width="560" alt="image2" class="container" />
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
                    <h3 class="section-heading"><?php echo($splash_data['preschoolexpansion_text_field_2']); ?></h3>
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
                    <?php echo($splash_data['preschoolexpansion_textarea_field_3']); ?>
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
                    <a href="index.html" ><img class="container" src="<?php echo(preschoolexpansion_theme_image('images/link-img.png')); ?>" width="69" alt="link-img"/></a>
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

