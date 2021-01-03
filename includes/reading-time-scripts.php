<?php

// Conditionally load JS on plugin settings pages only
function reading_time_admin_scripts( $hook ) {

  wp_register_script(
    'reading-time-admin',
    WPPLUGIN_URL . 'admin/js/reading_time_admin.js',
    ['jquery'],
    time()
  );

  wp_localize_script( 'reading-time-admin', 'reading_time', [
      'hook' => $hook
  ]);
    
  if( 'settings_page_reading-time' == $hook ) {
      wp_enqueue_script( 'reading-time-admin' );
  }

}
add_action( 'admin_enqueue_scripts', 'reading_time_admin_scripts' );
