<?php

function the_reading_time() {

    $post = get_post();

    if (empty($post) || !in_post_types_allowed($post->post_type)) {
        return false;
    }

    $value = get_transient('post_reading_time_ym_' . $post->ID);

    if ($value === false) {
        $obj = new ReadingTime($post->ID);
        $obj->calculated();
        $obj->update();
        $value = $obj->readingTime;
        set_transient('post_reading_time_ym_' . $post->ID, $value, 3600);
    }

    echo esc_html($value . ' Seconds', 'reading-time-ym');
    return true;
}

function get_reading_time() {

    $post = get_post();

    if (empty($post) || !in_post_types_allowed($post->post_type)) {
        return false;
    }

    $value = get_transient('post_reading_time_ym_' . $post->ID);

    if ($value === false) {
        $obj = new ReadingTime($post->ID);
        $obj->calculated();
        $value = $obj->readingTime;
        set_transient('post_reading_time_ym_' . $post->ID, $value, 3600);
    }
    return esc_html($value, 'reading-time-ym');
}
