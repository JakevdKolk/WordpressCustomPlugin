<?php

class Sjaakies_Funny_Joke_Plugin_Shortcode_Widget
{

    public function shortcode_jokes_page()
    {

        wp_enqueue_script('sjaakie-jokes', SJAAKIE_PLUGIN_URL . 'public/js/fetchJoke.js', [], '1.0', true);

        wp_localize_script('sjaakie-jokes', 'SjaakieJokes', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('sjaakie_joke_nonce'),
        ]);

        return '
      <div class="sjaakie-jokes-widget">
        <div class="sjaakie-jokes-output">Click "Load jokes" to fetch jokes.</div>
        <button type="button" class="sjaakie-jokes-load">Load jokes</button>
      </div>
    ';
    }
}
