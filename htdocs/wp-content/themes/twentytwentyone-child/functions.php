<?php
function enqueue_custom_styles() {
    wp_enqueue_style('custom-guestrooms-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.0', 'all');

}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
