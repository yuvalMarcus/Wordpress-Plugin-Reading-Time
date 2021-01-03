<?php

function update_reading_time($post_ID, $post) {

    if (empty($post) || !in_post_types_allowed($post->post_type)) {
        return;
    }

    $obj = new ReadingTime($post_ID);
    $obj->calculated();
    $obj->update();

    return $obj->readingTime;
}

add_action('save_post', 'update_reading_time', 10, 2);

function update_option_update_all_reading_time($old_value, $value) {

    if (json_encode($old_value) !== json_encode($value)) {
        set_transient('reading_time_settings', $value, 3600);
    }

    ReadingTime::updateAll();
}

add_action('update_option_reading_time_settings', 'update_option_update_all_reading_time', 10, 2);

function wp_ajax_update_all_reading_time() {

    ReadingTime::updateAll();
}

add_action('wp_ajax_update_all_reading_time', 'wp_ajax_update_all_reading_time', 10, 0);

function reading_time_shortcode($atts) {

    $options = get_reading_time_settings();

    $labelshortcode = 'Reading Time';
    if (isset($options['label_shortcode'])) {
        $labelshortcode = esc_html($options['label_shortcode']);
    }

    $post = get_post();

    if (empty($post) || !in_post_types_allowed($post->post_type)) {
        return;
    }

    $value = get_transient('post_reading_time_' . $post->ID);

    if ($value === false) {
        $obj = new ReadingTime($post->ID);
        $obj->calculated();
        $obj->update();
        $value = $obj->readingTime;
        set_transient('post_reading_time_' . $post->ID, $value, 3600);
    }

    $className = apply_filters('shortcode_reading_time_class', 'shortcode_reading_time');
    $atts['class'] = !empty($atts['class']) ? $atts['class'] : '';
    
    $html = '<p class="' . $className . ' ' . $atts['class'] . '">';
    $html .= '<label>' . $labelshortcode . '</label>';
    $html .= '<span>';
    $html .= $value . ' Seconds';
    $html .= '</span>';
    $html .= '</p>';

    return $html;
}

add_shortcode('reading_time', 'reading_time_shortcode');

function reading_time_activation() {

    $options = [];
    $options['numberofwords'] = 200;
    $options['posttypes'] = json_encode(['post', 'page']);
    $options['roundtype'] = 'round_up';
    add_option('reading_time_settings', $options);
    set_transient('reading_time_settings', $options, 3600);
}

register_activation_hook(__FILE__, 'reading_time_activation');

function reading_time_uninstall() {

    ReadingTime::removeAll();
    delete_transient('reading_time_settings');
    delete_option('reading_time_settings');
}

register_uninstall_hook(__FILE__, 'reading_time_uninstall');
