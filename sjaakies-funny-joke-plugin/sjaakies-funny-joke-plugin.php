<?php

/**
 * Plugin Name: Sjaakies funny joke plugin
 * Description: funny funny jokes
 * Version: 1.0.0
 * Author: Sjaakie
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'Functions/admin-menu.php';
require_once plugin_dir_path(__FILE__) . 'Functions/fetch-handler.php';
require_once plugin_dir_path(__FILE__) . 'Functions/shortcode-widget.php';


class Sjaakies_Funny_Joke_Plugin
{


    public function __construct()
    {


        $admin_menu = new Sjaakies_Funny_Joke_Plugin_Admin_Menu();
        $fetch_handler = new Sjaakies_Funny_Joke_Plugin_Fecht_Handler();
        $shortcode_widget = new Sjaakies_Funny_Joke_Plugin_Shortcode_Widget();
        add_action('admin_menu', [$admin_menu, 'register_settings_page']);

        add_shortcode('sjaakie_jokes', [$shortcode_widget, 'shortcode_jokes_page']);

        add_action('wp_ajax_sjaakie_get_joke', [$fetch_handler, 'get_joke']);
        add_action('wp_ajax_nopriv_sjaakie_get_jokes', [$fetch_handler, 'get_joke']);
    }
}



new Sjaakies_Funny_Joke_Plugin();
