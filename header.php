<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until the end of the header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package preschoolexpansion
 * We should never get here! Always render via header-preschoolexpansion
 */

?><!DOCTYPE html>
<html <?php language_attributes('xhtml'); ?>>
  <head>
   <meta charset="<?php bloginfo( 'charset' ); ?>" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="keywords" values="preschool, education, support" />
   <link rel="profile" href="http://gmpg.org/xfn/11" />
   <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
   
  <?php 
  global $template_class;
  $query = new WP_Query(array('pagename' => $template_class));
  wp_head(); 
  ?>
 </head>
 <body <?php body_class('content') ?>>
   <table class="background" width="100%" border="0" background="<?php echo(preschoolexpansion_theme_image('images/background-pattern.gif'));?>" background-repeat="repeat-y" cellspacing="0" cellpadding="0" align="center" style=" width:100% !important; background-image: url(<?php echo(get_template_directory_uri() . "/images/background-pattern.gif")?>); background-repeat: repeat;">
    <tr>
      <td align="center" valign="top">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <!-- start space -->
          <tr>
            <td valign="top" height="72">
            </td>
          </tr>
          <!-- end space --> 
        </table>

        <!-- start header layout -->
        <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="container">
          <tr>
            <td align="center" valign="top">                
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <!-- start space -->
                <tr>
                  <td valign="top" height="119" class="indent">
                  </td>
                </tr>
                <!-- end space -->
                <tr>
                  <td align="center" valign="top">
                    <a href="/" ><img src="<?php echo(preschoolexpansion_theme_image('images/logo.png')); ?>" width="301" alt="logo" style="vertical-align:bottom !important; display: inline-block !important;" class="logo" /></a>
                  </td>
                </tr>
                <!-- start space -->
                <tr>
                  <td valign="top" height="115"  class="indent">
                  </td>
                </tr>
                <!-- end space -->
                <tr>
                  <td align="center" valign="top">
                    <img src="<?php echo(preschoolexpansion_theme_image('images/header-img.jpg'));?>" width="600" alt="header-img" style="vertical-align:bottom !important; display: inline-block !important;" class="container"/>
                  </td>
                </tr>
                <!-- start space -->
                <tr>
                  <td valign="top" height="56">
                  </td>
                </tr>
                <!-- end space -->
                <tr>
                  <td align="center" valign="top" style="padding: 0 70px;" class="indent-70">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td align="center" valign="top">
                          <h2 style="color:#404040; padding: 0; margin: 0; font-size: 60px; line-height: 62px; text-transform: uppercase; font-family:Trebuchet MS, sans-serif; font-weight: normal;" class="heading2"><?php bloginfo('title') ?></h2>
                        </td>
                      </tr>
                      <!-- start space -->
                      <tr>
                        <td valign="top" height="36">
                        </td>
                      </tr>
                      <!-- end space -->
                      <tr>
                        <td align="center" valign="top" style="color:#c7c7c7; font-size: 20px; line-height: 25px; text-transform: uppercase; font-family:Trebuchet MS, sans-serif;">
                          <?php bloginfo('description'); ?>
                        </td>
                      </tr>
                      <!-- start space -->
                      <tr>
                        <td valign="top" height="20">
                        </td>
                      </tr>
                      <!-- end space -->
                      <tr>
                        <td align="center" valign="top" style="color:#c8c8c1; font-size: 14px; line-height: 24px;  font-family:Arial, Helvetica, sans-serif;">
                          <?php 
                          // run a loop here for the splash page only
                          if (strtolower($template_class) == 'splash'):
                            while ($query->have_posts()) : 
                              $query->the_post();
                              the_content();
                            endwhile;
                          $query->reset_postdata();
                          endif;
                          ?>
                        </td>
                      </tr>
                      <!-- start space -->
                      <tr>
                        <td valign="top" height="70">
                        </td>
                      </tr>
                      <!-- end space -->
                    </table>
                  </td>
                </tr>
              </table>        
            </td>
          </tr>
<!-- end header layout -->

