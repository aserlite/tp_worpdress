<?php

namespace Guestrooms;

class ACF
{
    public function register(): void
    {
        add_action('init', function () {
            if (function_exists('acf_add_local_field_group')) {
                acf_add_local_field_group(array(
                    'key' => __('guestrooms_fields'),
                    'title' => __('Guestrooms Fields'),
                    'fields' => array(
                        array(
                            'key' => __('field_number_of_beds'),
                            'label' => __('Nombre de couchages'),
                            'name' => __('number_of_beds'),
                            'type' => __('number'),
                            'wrapper' => array(
                                'width' => '50%',
                            ),
                        ),
                        array(
                            'key' => __('field_price_indicative'),
                            'label' => __('Prix'),
                            'name' => __('price_indicative'),
                            'type' => __('number'),
                            'wrapper' => array(
                                'width' => '50%',
                            ),
                        ),
                    ),
                    'location' => array(
                        array(
                            array(
                                'param' => 'post_type',
                                'operator' => '==',
                                'value' => 'guestrooms',
                            ),
                        ),
                    ),
                ));
            }
        });
    }
}
