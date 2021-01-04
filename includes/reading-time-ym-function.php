<?php

function get_reading_time_ym_settings() {

    $options = get_transient('reading_time_ym_settings');

    if ($options === false) {

        $options = get_option('reading_time_ym_settings');
        set_transient('reading_time_ym_settings', $options, 3600);
    }

    return $options;
}

function in_post_types_allowed($post_type) {

    $options = get_reading_time_ym_settings();

    $posttypes = [];
    if (isset($options['post_types'])) {
        $posttypes = $options['post_types'];
    }

    if (in_array($post_type, $posttypes)) {
        return true;
    }

    return false;
}
