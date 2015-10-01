<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package preschoolexpansion
 */
?>

</table><!-- #content(.background) (end news layout) -->

<!-- start contacts layout -->
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #272a31;" class="container">
  <tr>
    <td align="center" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <!-- start space -->
        <tr>
          <td valign="top" height="44">
          </td>
        </tr>
        <!-- end space -->
        <tr>
          <td align="center" valign="top" style="padding: 0 70px;" class="indent-70">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td align="center" valign="top" >
                  <h4 style="">Talk to Us</h4>
                </td>
              </tr>
              <!-- start space -->
              <tr>
                <td valign="top" height="10">
                </td>
              </tr>
              <!-- end space -->
              <tr>
                <td align="center" valign="top" style="color:#434855; font-size: 14px; line-height: 23px; font-family:Trebuchet MS, sans-serif;">
                  Address: 2626 S. Clearbrook Drive, Arlington Heights, IL
                </td>
              </tr>
              <tr>
                <td class="phone-contact" align="center" valign="top" style="">
                  <img class="phone-contact-image" src="<?php echo(preschoolexpansion_theme_image('images/phone-img.png')); ?>"  width="13" alt="phone-img" style="" /> &nbsp; 224-366-8526
                </td>
              </tr>
              <!-- start space -->
              <tr>
                <td valign="top" height="4">
                </td>
              </tr>
              <!-- end space -->
              <tr>
                <td align="center" valign="top"  style="color:#ffffff; font-size: 14px; line-height: 23px; font-family:Trebuchet MS, sans-serif;">
                  <img class="email-contact-image" src="<?php echo(preschoolexpansion_theme_image('images/email-img.png')); ?>"  width="20" alt="email-img" style="" /> &nbsp; Email: <a class="email-contact" href="index.html" style="color:#434855; font-size: 14px; line-height: 25px; font-family:Trebuchet MS, sans-serif; text-decoration: none;">peg@cntrmail.org</a>
                </td>
              </tr>
              <!-- start space -->
              <tr>
                <td valign="top" height="16">
                </td>
              </tr>
              <!-- end space -->
              <tr>
                <td align="center" valign="top" >
                  <table width="174" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td valign="top" align="center">
                        <a href="index.html"><img src="<?php echo(preschoolexpansion_theme_image('images/facebook.png')); ?>" alt="facebook" width="51" style="vertical-align:bottom !important;" class="social-icon" /></a>
                      </td>
                      <td valign="top" align="center">
                        <a href="index.html"><img src="<?php echo(preschoolexpansion_theme_image('images/twitter.png')); ?>" alt="twitter" width="51" style="vertical-align:bottom !important;" class="social-icon" /></a>
                      </td>
                      <td valign="top" align="center">
                        <a href="index.html"><img src="<?php echo(preschoolexpansion_theme_image('images/skype.png')); ?>" alt="skype" width="51" style="vertical-align:bottom !important;" class="social-icon" /></a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <!-- start space -->
              <tr>
                <td valign="top" height="32">
                </td>
              </tr>
              <!-- end space -->
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!-- end contacts layout -->

<!-- start footer layout -->
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #1f2227;" class="container">
  <tr>
    <td align="center" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <!-- start space -->
        <tr>
          <td valign="top" height="84">
          </td>
        </tr>
        <!-- end space -->
        <tr>
          <td align="center" valign="top" style="padding: 0 60px;" class="indent-70">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td class="disclaimer" align="center" valign="top" style="color:#434855; font-size: 14px; line-height: 23px; font-family:Trebuchet MS, sans-serif;">
                  The <a class="disclaimer-link" href="#top">Preschool Expansion Grant</a> is a collaboration between <a class="disclaimer-link" href="http://ec.thecenterweb.org">The Early Childhood Center for Professional Development Project</a>, the Illinois State Board of Education, and the Governor's office of Early Childhood Development.
                </td>
              </tr>
              <!-- start space -->
              <tr>
                <td valign="top" height="24">
                </td>
              </tr>
              <!-- end space -->
              <tr>
                <td align="center" valign="top" style="color:#434855; font-size: 12px; line-height: 23px; font-family:Trebuchet MS, sans-serif;">
                  <span style="color:#f2b33d; ">The Center</span> © 2015.  <a href="index.html" style="color:#434855; text-decoration:none; ">Privacy Policy</a>
                </td>
              </tr>
              <!-- start space -->
              <tr>
                <td valign="top" height="62">
                </td>
              </tr>
              <!-- end space -->
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!-- end footer layout -->
<?php wp_footer(); ?>

</body>
</html>
