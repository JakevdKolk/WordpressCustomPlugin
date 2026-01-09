<?php

class Sjaakies_Funny_Joke_Plugin_Shortcode_Widget
{
    public function enqueue_scripts() {}

    public function shortcode_jokes_page()
    {

        wp_enqueue_script('sjaakie-jokes', plugin_dir_url(__FILE__) . 'public/js/fetchJoke.js', [], '1.0', true);

        wp_localize_script('sjaakie-jokes', 'SjaakieJokes', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('sjaakie_joke_nonce'),
        ]);

        var_dump(plugin_dir_url(__FILE__) . 'public/');
        return '
      <div class="sjaakie-jokes-widget">
        <div class="sjaakie-jokes-output">Click "Load jokes" to fetch jokes.</div>
        <button type="button" class="sjaakie-jokes-load">Load jokes</button>
      </div>
    ';
    }
}
