<?php
/*
Plugin Name: Guestrooms
Description: Add Guestrooms to manage your reservations
Version: 5.2.7
Author: Arthur Cuvillon
*/

require_once 'inc/PostType.php';
require_once 'inc/ACF.php';
require_once 'inc/GridBlock.php';

class Guestrooms {
    public function init() {
        (new \Guestrooms\PostType())->register();
        (new \Guestrooms\ACF())->register();
        (new Guestrooms\GridBlock())->register();
    }

    public function check_dependencies() {
        if (is_plugin_active('advanced-custom-fields/acf.php')) {
            $this->init();
        } else {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die('Ce plugin nécessite ACF. Veuillez l\'activer avant d\'activer ce plugin.');
        }
    }
}

$plugin = new Guestrooms();

register_activation_hook(__FILE__, array($plugin, 'check_dependencies'));

$plugin->init();
