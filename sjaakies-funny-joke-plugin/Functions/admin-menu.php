<?php

if (!defined('ABSPATH')) exit;

class Sjaakies_Funny_Joke_Plugin_Admin_Menu
{

    public function register_settings_page()
    {
        add_menu_page(
            'JokeAPI Settings',
            'Sjaakies jokes',
            'manage_options',
            'sjaakie-jokeapi-settings',
            [$this, 'render_settings_page'],
            'dashicons-smiley',
            65
        );
    }

    public function render_settings_page()
    {
        echo '<div> hello world </div>';
    }
}
