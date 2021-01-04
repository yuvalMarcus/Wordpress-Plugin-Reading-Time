<?php

/**
 * @package reading time ym
 */
/*
  Plugin Name: Reading Time
  Plugin URI: https://github.com/yuvalMarcus/Wordpress-Plugin-Reading-Time
  Description: The Reading Time plugin allows us to add to the posts / pages and other types of posts we want, information about the reading time of the content that is displayed to us.
  Version: 1.0.0
  Author: Yuval Marcus
  License: GPLv2 or later
  Text Domain: reading-time-ym
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin paths and URLs
define('WPPLUGIN_URL', plugin_dir_url(__FILE__));
define('WPPLUGIN_DIR', plugin_dir_path(__FILE__));

// Include Core Functions Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-function.php');

// Include Core Class Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-class.php');

// Include Core WP CLI Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-wp-cli.php');

// Include Core Theme Functions Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-theme.php');

// Include Core Hook Functions Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-hook.php');

// Create Settings Fields
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-settings-fields.php');

// Enqueue Plugin CSS
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-styles.php');

// Enqueue Plugin JavaScript
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-scripts.php');

// Create Plugin Admin Menus and Setting Pages
include( plugin_dir_path(__FILE__) . 'includes/reading-time-ym-menus.php');

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('reading-time', 'WPC_CLI');
}

function reading_time_ym_activation() {

    $options = get_reading_time_ym_settings();

    if (empty($options)) {

        $options = [];
        $options['number_of_words'] = 200;
        $options['post_types'] = ['post'];
        $options['round_type'] = 'round_up';
        add_option('reading_time_ym_settings', $options);
        set_transient('reading_time_ym_settings', $options, 3600);
        ReadingTime::updateAll();
    }
}

register_activation_hook(__FILE__, 'reading_time_ym_activation');

function reading_time_ym_uninstall() {

    delete_transient('reading_time_ym_settings');
    delete_option('reading_time_ym_settings');
}

register_uninstall_hook(__FILE__, 'reading_time_ym_uninstall');
