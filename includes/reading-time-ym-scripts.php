<?php

// Conditionally load JS on plugin settings pages only
function reading_time_ym_admin_scripts( $hook ) {

  wp_register_script(
    'reading-time-ym-admin',
    WPPLUGIN_URL . 'admin/js/reading_time_ym_admin.js',
    ['jquery'],
    time()
  );

  wp_localize_script( 'reading-time-ym-admin', 'reading_time_ym', [
      'hook' => $hook
  ]);
    
  if( 'settings_page_reading-time-ym' == $hook ) {
      wp_enqueue_script( 'reading-time-ym-admin' );
  }

}
add_action( 'admin_enqueue_scripts', 'reading_time_ym_admin_scripts' );
