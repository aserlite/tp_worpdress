<?php

namespace Guestrooms;

class GridBlock {

    public function register() {
        register_block_type(
            'custom/guestrooms-block',
            array(
                'editor_script' => 'guestrooms-block-editor',
                'render_callback' => array($this, 'render_guestrooms_block'),
            )
        );

        wp_enqueue_script(
            'guestrooms-block-editor',
            plugin_dir_url(__FILE__) . '../blocks/guestrooms_grid/guestrooms_grid.js',
            array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'),
            true
        );
    }

    public function render_guestrooms_block($attributes)
    {
        $guestrooms = get_posts(array(
            'post_type' => 'guestrooms',
            'posts_per_page' => 8,
        ));

        if ($guestrooms) {
            $output = '<ul class="guestrooms-list">';

            foreach ($guestrooms as $guestroom) {
                $thumbnail = get_the_post_thumbnail($guestroom->ID, 'large');
                $permalink = get_permalink($guestroom->ID);
                $title = get_the_title($guestroom->ID);

                $output .= '<li class="guestroom-item">';
                $output .= '<a href="' . esc_url($permalink) . '">';
                $output .= '<div class="guestroom-thumbnail">' . $thumbnail . '</div>';
                $output .= '<h2>' . esc_html($title) . '</h2>';
                $output .= '</a>';
                $output .= '</li>';
            }

            $output .= '</ul>';
        } else {
            $output = '<p>Aucune chambre n\'a été trouvée.</p>';
        }

        return $output;
    }

}
