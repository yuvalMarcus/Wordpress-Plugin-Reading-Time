<?php

function update_reading_time_ym($post_ID, $post) {

    if (empty($post) || !in_post_types_allowed($post->post_type)) {
        return;
    }

    $obj = new ReadingTime($post_ID);
    $obj->calculated();
    $obj->update();

    return $obj->readingTime;
}

add_action('save_post', 'update_reading_time_ym', 10, 2);

function update_option_update_all_reading_time_ym($old_value, $value) {

    if (json_encode($old_value) !== json_encode($value)) {
        set_transient('reading_time_ym_settings', $value, 3600);
    }

    ReadingTime::updateAll();
}

add_action('update_option_reading_time_ym_settings', 'update_option_update_all_reading_time_ym', 10, 2);

function wp_ajax_update_all_reading_time_ym() {

    ReadingTime::updateAll();
}

add_action('wp_ajax_update_all_reading_time_ym', 'wp_ajax_update_all_reading_time_ym', 10, 0);

function reading_time_ym_shortcode($atts) {

    $options = get_reading_time_ym_settings();

    $labelshortcode = 'Reading Time';
    if (isset($options['label_shortcode'])) {
        $labelshortcode = $options['label_shortcode'];
    }

    $post = get_post();

    if (empty($post) || !in_post_types_allowed($post->post_type)) {
        return;
    }

    $value = get_transient('post_reading_time_ym_' . $post->ID);

    if ($value === false) {
        $obj = new ReadingTime($post->ID);
        $obj->calculated();
        $obj->update();
        $value = $obj->readingTime;
        set_transient('post_reading_time_ym_' . $post->ID, $value, 3600);
    }

    $className = apply_filters('shortcode_reading_time_class', 'shortcode_reading_time_ym');
        
    $className = esc_html($className, 'reading-time-ym');
    
    $html = '<p class="' . $className . '">';
    $html .= '<label>' . $labelshortcode . '</label>';
    $html .= '<span>';
    $html .= $value . ' Seconds';
    $html .= '</span>';
    $html .= '</p>';

    return $html;
}

add_shortcode('reading_time', 'reading_time_ym_shortcode');
