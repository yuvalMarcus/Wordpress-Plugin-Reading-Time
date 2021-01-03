<?php

function readingtime_settings_page_markup()
{
  // Double check user capabilities
  if ( !current_user_can('manage_options') ) {
      return;
  }
  include( WPPLUGIN_DIR . 'templates/admin/settings-page.php');
}

function readingtime_settings_pages()
{
  add_options_page(
    __( 'Reading Time', 'reading-time' ),
    __( 'Reading Time', 'reading-time' ),
    'manage_options',
    'reading-time',
    'readingtime_settings_page_markup'
  );

}
add_action( 'admin_menu', 'readingtime_settings_pages' );

// Add a link to your settings page in your plugin
function readingtimeym_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=reading-time">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$filter_name = "readingtime_action_links_" . plugin_basename( __FILE__ );
add_filter( $filter_name, 'readingtime_add_settings_link' );
