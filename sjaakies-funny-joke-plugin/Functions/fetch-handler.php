<?php

class Sjaakies_Funny_Joke_Plugin_Fecht_Handler
{

    private const OPTION_KEY = 'sjaakie_joke_options';

    public function get_joke()
    {

        check_ajax_referer('sjaakie_joke_nonce', 'nonce');

        $url = $this->build_url();

        $res = wp_remote_get($url, ['timeout' => 10, 'headers' => ['Accept' => 'application/json']]);

        if (is_wp_error($res)) {
            wp_send_json_error(['message' => $res->get_error_message()], $res->get_error_code());
        }

        $code = wp_remote_retrieve_response_code($res);
        $body = wp_remote_retrieve_body($res);

        $data = json_decode($body, true);

        if (!is_array($data) || !empty($data['error'])) {
            $msg = is_array($data) && isset($data['message']) ? (string)$data['message'] : 'Invalid API response';
            wp_send_json_error(['message' => $msg], 500);
        }

        wp_send_json_success($data);
    }

    public function build_url()
    {
        $opts = $this->get_options();

        $categories = array_values(array_filter(array_map('trim', $opts['categories'])));
        if (empty($categories)) $categories = ['Any'];

        $amount = max(1, min(10, $opts['amount']));

        $blacklist = array_values(array_filter(array_map('trim', $opts['blacklist'])));

        $base =     $base = 'https://v2.jokeapi.dev/joke/' . implode(',', array_map('rawurlencode', $categories));

        $qeury = [
            'amount' => $amount
        ];

        if (!empty($blacklist)) {
            $qeury['blacklistFlags'] = implode(',', $blacklist);
        }

        return $base . '?' . http_build_query($qeury);
    }

    public function get_options()
    {
        $defaults = [
            'categories' => ['Any'],
            'blacklist' => [],
            'amount' => 1
        ];

        $stored = get_option(self::OPTION_KEY, []);

        if (!is_array($stored)) {
            $stored = [];
        }

        $stored['categories'] = isset($stored['categories']) ? $stored['categories'] : $defaults['categories'];
        $stored['blacklist']  = isset($stored['blacklist']) ? $stored['blacklist'] : $defaults['blacklist'];
        $stored['amount']     = isset($stored['amount']) ? $stored['amount'] : $defaults['amount'];

        return array_merge($defaults, $stored);
    }
}
