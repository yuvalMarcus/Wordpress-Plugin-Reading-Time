<?php

// Conditionally load CSS on plugin settings pages only
function reading_time_admin_styles( $hook ) {

  wp_register_style(
    'reading-time-admin',
    WPPLUGIN_URL . 'admin/css/reading_time_admin_style.css',
    [],
    time()
  );

  if( 'settings_page_reading-time' == $hook ) {
    wp_enqueue_style( 'reading-time-admin' );
  }

}
add_action( 'admin_enqueue_scripts', 'reading_time_admin_styles' );


// Load CSS on the frontend
function reading_time_frontend_styles() {

  wp_register_style(
    'reading-time-frontend',
    WPPLUGIN_URL . 'frontend/css/reading_time_frontend_style.css',
    [],
    time()
  );

  if( is_single() ) {
      wp_enqueue_style( 'reading-time-frontend' );
  }

}
add_action( 'wp_enqueue_scripts', 'reading_time_frontend_styles', 100 );
