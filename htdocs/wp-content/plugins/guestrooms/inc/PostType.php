<?php

namespace Guestrooms;

class PostType
{
    public const SLUG = 'guestrooms';

    public function register(): void
    {
        add_action('init', function () {
            $labels = array(
                'name' => __("Chambres"),
                'all_items' => __("Toutes les Chambres d'hote"),
                'singular_name' => __('Chambre'),
                'add_new_item' => __('Ajouter une chambre'),
                'add_new' => __('Ajouter une chambre'),
                'edit_item' => __('Modifier la chambre'),
                'menu_name' => __('Guestroom')
            );

            $args = array(
                'labels' => $labels,
                'supports'     => array(
                    'title',
                    'editor',
                    'excerpt',
                    'author',
                    'thumbnail',
                    'comments',
                    'revisions',
                    'custom-fields',
                ),
                'show_in_rest' => true,
                'hierarchical' => false,
                'public'       => true,
                'has_archive'  => true,
                'rewrite'      => array('slug' => self::SLUG),
                'show_in_nav_menus' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-admin-multisite',
            );

            register_post_type( self::SLUG, $args );
        });
    }
}