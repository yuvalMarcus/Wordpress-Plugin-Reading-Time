<div class="wrap">

    <h1><?php esc_html_e(get_admin_page_title()); ?></h1>

    <form method="post" action="options.php">
        <!-- Display necessary hidden fields for settings -->
        <?php settings_fields('reading-time-ym_settings'); ?>
        <!-- Display the settings sections for the page -->
        <?php do_settings_sections('reading-time-ym'); ?>
        <!-- Default Submit Button -->
        <?php submit_button(); ?>
    </form>
</div>

<div class="wrap">
    <h2>Update All Reading Time</h2>
    <p>
        Update all reading times on all relevant posts
    </p>
    <div class="message">
        
    </div>
    <button id="update_all_reading_time_ym" class="button button-primary">Clear Previous calculations</button>
    <span class="loading">
        <div class="loader"></div>
    </span>
</div>
