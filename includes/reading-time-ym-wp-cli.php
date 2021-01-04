<?php

class WPC_CLI {

    public function config($args, $assoc_args) {

        $type = $args[0];
        $options = get_reading_time_ym_settings();

        if ($type === 'get') {

            $display_fields = array(
                'option',
                'value',
            );
            $formatter = new \WP_CLI\Formatter($assoc_args, $display_fields);
            $formatter->display_items([
                ['option' => 'No. of Words Per Minute', 'value' => $options['number_of_words']],
                ['option' => 'Supported Post Types', 'value' => json_encode($options['post_types'])],
                ['option' => 'Rounding behavior', 'value' => ReadingTime::$roundTypes[$options['round_type']]]
            ]);
        }

        if ($type === 'set') {

            if (constant('READING_TIME_NUMBER_OF_WORDS_PER_MINUTE') &&
                    constant('SUPPORTED_POST_TYPES') &&
                    constant('ROUNDING_BEHAVIOR')) {

                $options['number_of_words'] = READING_TIME_NUMBER_OF_WORDS_PER_MINUTE;
                $options['post_types'] = SUPPORTED_POST_TYPES;
                $options['round_type'] = ROUNDING_BEHAVIOR;
                set_transient('reading_time_ym_settings', $options, 3600);
                $this->clear_cache([], []);
                //self::clear_cache();
            }

            //$reading_time_ym_NUMBER_OF_WORDS_PER_MINUTE = isset(reading_time_ym_NUMBER_OF_WORDS_PER_MINUTE) ? reading_time_ym_NUMBER_OF_WORDS_PER_MINUTE : '' ;
        }
    }

    public function clear_cache($args, $assoc_args) {

        $options = get_reading_time_ym_settings();

        $posttypes = [];
        if (isset($options['post_types'])) {
            $posttypes = $options['post_types'];
        }

        if (count($posttypes) === 0) {
            WP_CLI::line('No post types found');
            return;
        }

        WP_CLI::line('Clear previous calculation and force recalculation for all posts');

        $args = array(
            'post_type' => $posttypes,
            'orderby' => 'ID',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );
        $result = new WP_Query($args);
        if ($result->post_count) {
            $progress = \WP_CLI\Utils\make_progress_bar('progress', $result->post_count);
            foreach ($result->posts as $post) {
                if (!empty($post) && in_post_types_allowed($post->post_type)) {
                    $obj = new ReadingTime($post->ID);
                    $obj->calculated();
                    $obj->update();
                }
                $progress->tick();
            }
            $progress->finish();
        }
        WP_CLI::success($result->post_count . ' Posts is update');
    }

    public function get($args, $assoc_args) {

        $post_id = $args[0];

        $post = get_post($post_id);

        if (empty($post) || !in_post_types_allowed($post->post_type)) {

            WP_CLI::line('Reading Time For Post ID = ' . $post_id . ' No Exist');
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

        WP_CLI::line('Reading Time For Post ID = ' . $post_id . ' Is ' . $value . ' In Seconds');
    }

}
