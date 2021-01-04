<?php

// Conditionally load CSS on plugin settings pages only
function reading_time_ym_admin_styles( $hook ) {

  wp_register_style(
    'reading-time-ym-admin',
    WPPLUGIN_URL . 'admin/css/reading_time_ym_admin_style.css',
    [],
    time()
  );

  if( 'settings_page_reading-time-ym' == $hook ) {
    wp_enqueue_style( 'reading-time-ym-admin' );
  }

}
add_action( 'admin_enqueue_scripts', 'reading_time_ym_admin_styles' );


// Load CSS on the frontend
function reading_time_ym_frontend_styles() {

  wp_register_style(
    'reading-time-ym-frontend',
    WPPLUGIN_URL . 'frontend/css/reading_time_ym_frontend_style.css',
    [],
    time()
  );

  if( is_single() ) {
      wp_enqueue_style( 'reading-time-ym-frontend' );
  }

}
add_action( 'wp_enqueue_scripts', 'reading_time_ym_frontend_styles', 100 );
