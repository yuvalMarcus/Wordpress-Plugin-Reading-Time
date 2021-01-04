# Wordpress Plugin Reading Time
The Reading Time plugin allows us to add to the posts / pages and other types of posts we want, information about the reading time of the content that is displayed to us.

## The Calculation Of Reading Time
The time of reading the post is calculated according to the following parameters, each time according to the need of certain events, and is saved for cash for future uses.

### Parameters
- C = The total number of words in the fields / meta fields used for content.
- N = Value of “No. of words per minute” field.

### The Formula
- RTs = Reading Time (in seconds) = round(60 × (C / N)).

### Event In Which The Data Reading Time Is Updated
- Post is created.
- Post is updated
- When the reading time is requested and no previous value exists
- In any other case when there is a chance that the value is no longer correct

## The Admin Settings Page
With the plugin settings management page you can manage
- Reading time calculation settings
- Reading time data which is in the system

### Path Page
``` Settings > Reading Time ```

### Parameters Settings
- No. of Words Per Minute \
The number of words that can be read per minute
- Supported Post Types \
The post types will have support for the Reading Time feature
- Rounding Behavior \
One of “Round Up”, “Round Down”, “Round up in 1⁄2 minute steps”, “Round down in 1⁄2 minute steps”
- Shortcode Label Text \
Text that will appear on the label in shotcode

### Actions
- Clear Previous calculations \
Remove all data of reading time in the cached

## Reading Time in Theme
When we want to use reading time data, we can do so using the following methods
- Using the shortcode ``` [reading_time] ``` in post content. \
This function prints the amount of read time per second for the current post, with format in html
#### example
```
<p class="shortcode_reading_time">
  <label>Reading Time</label>
  <span>4 Seconds</span>
</p>
```

- By calling a php function named ``` the_reading_time() ``` \
This function prints the amount of reading time per second for the current post
#### example
```
4 Seconds
```

- By echoing the return value of a php function named ``` get_reading_time() ``` \
This function returns the amount of reading time per second to the current post
#### example
```
4
```

## For Developers
### Custom Html Class Shortcode
You can use add_filter to edit the class which is added to the html tag (p) in the shortcode
#### example
```
function example_callback( $className ) {
    // Maybe modify $className in some way.
    return $className;
}
add_filter( 'shortcode_reading_time_ym_class', 'example_callback' );
```

## Working With WP CLI
- Show the values of the settings \
``` wp reading-time config get ```
- CONFIG VALUE – Update the value of a setting \
``` wp reading-time config set ```
CONFIG VALUE example
```
define('READING_TIME_NUMBER_OF_WORDS_PER_MINUTE', 300);
define('SUPPORTED_POST_TYPES', ['post']);
define('ROUNDING_BEHAVIOR', 'round_up');
```
```
'round_up' => 'Round Up',
'round_down' => 'Round Down',
'round_up_in_half_minute_steps' => 'Round up in 1⁄2 minute steps',
'round_down_in_half_minute_steps' => 'Round down in 1⁄2 minute steps'
```
- Clear previous calculation and force recalculation for all posts \
``` wp reading-time clear_cache ```
- Show the calculated reading time value for a specific post \
``` wp reading-time get PID ```
