<?php

/**
 * @package reading time
 */
/*
  Plugin Name: Reading Time
  Plugin URI: https://akismet.com/
  Description: The Reading Time plugin allows us to add to the posts / pages and other types of posts we want, information about the reading time of the content that is displayed to us.
  Version: 1.0.0
  Author: Yuval Marcus
  License: GPLv2 or later
  Text Domain: reading-time
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin paths and URLs
define('WPPLUGIN_URL', plugin_dir_url(__FILE__));
define('WPPLUGIN_DIR', plugin_dir_path(__FILE__));

// Include Core Functions Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-function.php');

// Include Core Class Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-class.php');

// Include Core WP CLI Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-wp-cli.php');

// Include Core Theme Functions Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-theme.php');

// Include Core Hook Functions Plugin
include( plugin_dir_path(__FILE__) . 'includes/reading-time-hook.php');

// Create Settings Fields
include( plugin_dir_path(__FILE__) . 'includes/reading-time-settings-fields.php');

// Enqueue Plugin CSS
include( plugin_dir_path(__FILE__) . 'includes/reading-time-styles.php');

// Enqueue Plugin JavaScript
include( plugin_dir_path(__FILE__) . 'includes/reading-time-scripts.php');

// Create Plugin Admin Menus and Setting Pages
include( plugin_dir_path(__FILE__) . 'includes/reading-time-menus.php');

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('reading-time', 'WPC_CLI');
}
