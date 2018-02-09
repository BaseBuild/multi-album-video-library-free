<?php

function mavl_plugin_options(){
  if(!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  } ;
  ?>
  <h1>Multi Album Video Library Settings</h1>
  <form method="post" action="options.php">
    <?php settings_fields( 'mavl_settings' ); ?>
    <?php do_settings_sections( 'mavl_settings' ); ?>
    <table class="form-table">
      <tr valign="top">
      <th scope="row">Vimeo Access Token:</th>
      <td><input type="text" name="mavl_access_token" value="<?php echo get_option( 'mavl_access_token' ); ?>"/><br/>
      See instructions on  how to get your access token here: <a href="https://developer.vimeo.com/api/start" target="_blank">https://developer.vimeo.com/api/start</a><br/>
      Start by creating an app here: <a href="https://developer.vimeo.com/apps/new?source=getting-started" target="_blank">https://developer.vimeo.com/apps/new?source=getting-started</a>
      </td>
      </tr>
      <tr valign="top">
      <th scope="row">Show videos of first album if there's only one album?</th>
      <td>
        <input id="checkBox" type="checkbox" name="mavl_show_first_album_videos" value="true" <?php if (get_option( 'mavl_show_first_album_videos' ) == 'true') echo 'checked'; ?>>
      </td>
      </tr>
    </table>
    <?php submit_button(); ?>

    <h3>Usage Instructions: </strong></h3>
    <p>To display your album on page, use this shortcode: <strong><em>[multi_album_video_library]</em></strong>, <strong><em>[mavl]</em></strong></p>
    <p>Learn more at <a href="http://www.basebuildguys.com/blog/how-to-create-an-online-video-library-with-vimeo-not-youtube/" target="_blank">http://www.basebuildguys.com/blog/how-to-create-an-online-video-library-with-vimeo-not-youtube/</a></p>
  </form>
<?php

}

function mavl_menu(){
  add_menu_page(
    __('Multi Album Video Library'),
    'Multi Album Video Library',
    'manage_options',
    'mavl-plugin-options',
    'mavl_plugin_options'
  );
}
add_action('admin_menu', 'mavl_menu');