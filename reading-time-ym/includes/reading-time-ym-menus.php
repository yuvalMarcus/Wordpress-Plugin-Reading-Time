<?php

function reading_time_ym_settings_page_markup()
{
  // Double check user capabilities
  if ( !current_user_can('manage_options') ) {
      return;
  }
  include( WPPLUGIN_DIR . 'templates/admin/settings-page.php');
}

function reading_time_ym_settings_pages()
{
  add_options_page(
    __( 'Reading Time', 'reading-time-ym' ),
    __( 'Reading Time', 'reading-time-ym' ),
    'manage_options',
    'reading-time-ym',
    'reading_time_ym_settings_page_markup'
  );

}

add_action( 'admin_menu', 'reading_time_ym_settings_pages' );