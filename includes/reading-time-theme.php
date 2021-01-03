<?php

function the_reading_time() {

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

    echo $value;
    return true;
}

function get_reading_time() {

    $post = get_post();

    if (empty($post) || !in_post_types_allowed($post->post_type)) {
        return;
    }

    $value = get_transient('post_reading_time_' . $post->ID);

    if ($value === false) {
        $obj = new ReadingTime($post->ID);
        $obj->calculated();
        $value = $obj->readingTime;
        set_transient('post_reading_time_' . $post->ID, $value, 3600);
    }
    return $value;
}