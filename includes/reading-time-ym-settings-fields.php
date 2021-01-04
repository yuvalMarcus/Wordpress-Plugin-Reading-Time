<?php

function reading_time_ym_settings() {

    // If plugin settings don't exist, then create them
    if (false == get_reading_time_ym_settings()) {
        add_option('reading_time_ym_settings');
    }

    add_settings_section(
            // Unique identifier for the section
            'reading-time-ym_settings_section',
            // Section Title
            __('Reading Time Plugin Settings', 'reading-time-ym'),
            // Callback for an optional description
            'reading_time_ym_settings_section_callback',
            // Admin page to add section to
            'reading-time-ym'
    );

    add_settings_field(
            // Unique identifier for field
            'reading-time-ym_settings_number_of_words_text',
            // Field Title
            __('No. of Words Per Minute', 'reading-time-ym'),
            // Callback for field markup
            'reading_time_ym_settings_number_of_words_callback',
            // Page to go on
            'reading-time-ym',
            // Section to go in
            'reading-time-ym_settings_section'
    );

    $postTypes = get_post_types(['public' => true]);
    $checkboxsField = [];

    foreach ($postTypes as $type) {

        $checkboxsField[] = [
            'label' => strtoupper($type[0]) . substr($type, 1),
            'value' => $type
        ];
    }

    add_settings_field(
            // Unique identifier for field
            'reading-time-ym_settings_post_types',
            // Field Title
            __('Supported Post Types', 'reading-time-ym'),
            // Callback for field markup
            'reading_time_ym_settings_post_types_callback',
            // Page to go on
            'reading-time-ym',
            // Section to go in
            'reading-time-ym_settings_section',
            $checkboxsField
    );

    add_settings_field(
            // Unique identifier for field
            'reading-time-ym_settings_round_type',
            // Field Title
            __('Rounding behavior', 'reading-time-ym'),
            // Callback for field markup
            'reading_time_ym_settings_round_type_callback',
            // Page to go on
            'reading-time-ym',
            // Section to go in
            'reading-time-ym_settings_section',
            ReadingTime::$roundTypes
    );

    add_settings_field(
            // Unique identifier for field
            'reading-time-ym_settings_label_shortcode_text',
            // Field Title
            __('text for label shortcode', 'reading-time-ym'),
            // Callback for field markup
            'reading_time_ym_settings_label_shortcode_callback',
            // Page to go on
            'reading-time-ym',
            // Section to go in
            'reading-time-ym_settings_section'
    );

    register_setting(
            'reading-time-ym_settings', 'reading_time_ym_settings'
    );
}

add_action('admin_init', 'reading_time_ym_settings');

function reading_time_ym_settings_section_callback() {
}

function reading_time_ym_settings_number_of_words_callback() {

    $options = get_reading_time_ym_settings();

    $numberofwords = '200';
    if (isset($options['number_of_words'])) {
        $numberofwords = esc_html($options['number_of_words']);
    }

    echo '<input type="number" id="reading_time_ym_number_of_words" name="reading_time_ym_settings[number_of_words]" value="' . $numberofwords . '" />';
}

function reading_time_ym_settings_post_types_callback($args) {

    $options = get_reading_time_ym_settings();

    $checkbox = [];
    if (isset($options['post_types'])) {
        $checkbox = $options['post_types'];
    }

    $html = '';
    $checked = '';

    foreach ($args as $item) {

        $checked = in_array($item['value'], $checkbox) ? 'checked' : '';

        $html .= '<input type="checkbox" id="reading_time_ym_settings_post_types_' . $item['value'] . '" name="reading_time_ym_settings[post_types][]" value="' . $item['value'] . '" ' . $checked . ' />';
        $html .= '&nbsp;';
        $html .= '<label for="reading_time_ym_settings_post_types_' . $item['value'] . '">' . $item['label'] . '</label><br />';
    }

    echo $html;
}

function reading_time_ym_settings_round_type_callback($args) {

    $options = get_reading_time_ym_settings();

    $select = 'round_up';
    if (isset($options['round_type'])) {
        $select = esc_html($options['round_type']);
    }

    $html = '<select id="reading_time_ym_settings_round_type" name="reading_time_ym_settings[round_type]">';

    foreach (ReadingTime::$roundTypes as $key => $value) {

        $selected = $select === $value ? 'selected' : '';
        $html .= '<option value="' . $key . '"' . selected($select, $key, false) . ' ' . $selected . '>' . $args[$key] . '</option>';
    }

    $html .= '</select>';

    echo $html;
}

function reading_time_ym_settings_label_shortcode_callback() {

    $options = get_reading_time_ym_settings();

    $labelshortcode = 'Reading Time';
    if (isset($options['label_shortcode'])) {
        $labelshortcode = esc_html($options['label_shortcode']);
    }

    echo '<input type="text" id="reading_time_ym_settings_label_shortcode" name="reading_time_ym_settings[label_shortcode]" value="' . $labelshortcode . '" />';
}