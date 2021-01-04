<?php

class ReadingTime {

    private $post;
    private $numberOfWords;
    private $wordsCount;
    private $roundType;
    private $readingTime;
    public static $roundTypes = [
        'round_up' => 'Round Up',
        'round_down' => 'Round Down',
        'round_up_in_half_minute_steps' => 'Round up in 1⁄2 minute steps',
        'round_down_in_half_minute_steps' => 'Round down in 1⁄2 minute steps'
    ];

    public function __construct($post_ID = 0) {

        $option = get_reading_time_ym_settings();
        $post = get_post($post_ID);

        if ($post) {
            $this->post = $post;
            $this->wordsCount = str_word_count($post->post_content);
        }

        $this->numberOfWords = intval($option['number_of_words']);
        $this->roundType = $option['round_type'];
    }

    public function calculated() {

        $result = 60 * ($this->wordsCount / $this->numberOfWords);
        $readingTime = 0;

        switch ($this->roundType) {
            case 'round_up':
                $readingTime = ceil($result);
                break;
            case 'round_down':
                $readingTime = floor($result);
                break;
            case 'round_up_in_half_minute_steps':
                $readingTime = round($result, 0, PHP_ROUND_HALF_UP);
                break;
            case 'round_down_in_half_minute_steps':
                $readingTime = round($result, 0, PHP_ROUND_HALF_DOWN);
                break;
            default:
                $readingTime = ceil($result);
                break;
        }

        $this->readingTime = $readingTime;
    }

    public function __get($property) {

        if ($property === 'readingTime') {

            return $this->readingTime;
        }

        return 'Access is not allowed';
    }

    public function update() {

        if ($this->post) {
            set_transient('post_reading_time_ym_' . $this->post->ID, $this->readingTime, 3600);
            //update_post_meta($this->post->ID, 'reading_time_ym', $this->readingTime);
        }
    }

    public static function updateAll() {

        $options = get_reading_time_ym_settings();

        $posttypes = [];
        if (isset($options['post_types'])) {
            $posttypes = $options['post_types'];
        }

        if (count($posttypes) === 0) {
            return;
        }

        $args = array(
            'post_type' => $posttypes,
            'orderby' => 'ID',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );
        $result = new WP_Query($args);
        if ($result->post_count) {
            foreach ($result->posts as $post) {
                if (!empty($post) && in_post_types_allowed($post->post_type)) {
                    $obj = new ReadingTime($post->ID);
                    $obj->calculated();
                    $obj->update();
                }
            }
        }
    }

    public static function removeAll() {

        $options = get_reading_time_ym_settings();

        $posttypes = [];
        if (isset($options['post_types'])) {
            $posttypes = $options['post_types'];
        }

        if (count($posttypes) === 0) {
            return;
        }

        $args = array(
            'post_type' => $posttypes,
            'orderby' => 'ID',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );
        $result = new WP_Query($args);
        if ($result->post_count) {
            foreach ($result->posts as $post) {
                if (!empty($post) && in_post_types_allowed($post->post_type)) {
                    delete_transient('post_reading_time_ym_' . $this->post->ID);
                }
            }
        }
    }

}
