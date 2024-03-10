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

        add_action('enqueue_block_assets', array($this, 'enqueue_guestroom_block_styles'));

    }


    public function enqueue_guestroom_block_styles()
    {
        wp_enqueue_style(
            'guestroom-block-styles',
            plugin_dir_url(__FILE__) . '../css/block-styles.css',
            array(),
            '1.0.0'
        );

        wp_enqueue_style(
            'guestroom-styles',
            plugin_dir_url(__FILE__) . '../css/style.css',
            array(),
            '1.0.0'
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
                $output .= '</a>';
                $output .= '</li>';
            }

            $output .= '</ul>';
            $output .= '<div class="guest_link_wrapper"><a href="';
            $output .= get_post_type_archive_link('guestrooms');
            $output .= '" class="guestroom_archive_link">Voir toutes les chambres</a></div>';
        } else {
            $output = '<p>Aucune chambre n\'a été trouvée.</p>';
        }

        return $output;
    }

}
