<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package preschoolexpansion
 */

?>
<tr class="no-results not-found">
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
          <h3 class="section-heading"><?php esc_html_e( 'Nothing Found', 'preschoolexpansion' ); ?></h3>
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
          <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'preschoolexpansion' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'preschoolexpansion' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'preschoolexpansion' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
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

