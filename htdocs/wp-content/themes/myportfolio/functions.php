<?php
/**
 * This file is part of the AmphiBee package.
 * (c) AmphiBee <contact@amhibee.fr>
 */

add_action( 'wp_enqueue_scripts', 'enqueue_child_styles');
function enqueue_child_styles() {
    wp_enqueue_style( 'portfolio-style', get_stylesheet_directory_uri() . '/style.css' );
}
