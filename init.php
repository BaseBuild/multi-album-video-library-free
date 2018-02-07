<?php

// Register settings used on Plugin's admin page
function mavl_register_plugin_settings() {
  register_setting( 'mavl_settings', 'mavl_access_token' );
  register_setting( 'mavl_settings', 'mavl_items_per_page' );
  register_setting( 'mavl_settings', 'mavl_show_recent_videos' );
  register_setting( 'mavl_settings', 'mavl_show_first_album_videos' );
}
add_action('admin_init', 'mavl_register_plugin_settings');

// Register assets used on site
function mavl_register_assets(){
  
	wp_register_style('mavl_styles', plugin_dir_url( __FILE__ ) . 'assets/css/app.css');
  wp_enqueue_style('mavl_styles');
  
  wp_register_script('mavl_js', plugin_dir_url( __FILE__ ) . 'assets/js/app.min.js');
  wp_enqueue_script('mavl_js');
}

// Run only when admin
if(! is_admin()) {
  add_action('init', 'mavl_register_assets');  
}
