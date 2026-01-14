<?php

if (!defined('ABSPATH')) exit;

class Sjaakies_Funny_Joke_Plugin_Admin_Menu
{
    private const OPTION_KEY = 'sjaakie_joke_options';

    public function register_settings_page()
    {
        add_menu_page(
            'JokeAPI Settings',
            'Sjaakies Jokes',
            'manage_options',
            'sjaakie-jokeapi-settings',
            [$this, 'render_settings_page'],
            'dashicons-smiley',
            65
        );
    }

    public function init_settings()
    {
        register_setting(
            'sjaakie_joke_options_group', 
            self::OPTION_KEY              
        );

        add_settings_section(
            'sjaakie_main_section',       
            'Configuration',              
            null,                         
            'sjaakie-jokeapi-settings'    
        );

        add_settings_field(
            'sjaakie_amount',
            'Number of Jokes',
            [$this, 'joke_amount'],       
            'sjaakie-jokeapi-settings',
            'sjaakie_main_section'       
        );

        add_settings_field(
            'sjaakie_categories',
            'Categories of Jokes',
            [$this, 'jokes_categories'],
            'sjaakie-jokeapi-settings',
            'sjaakie_main_section'
        );

        add_settings_field(
            'sjaakie_blacklist',
            'Blacklist Flags',
            [$this, 'sjaakie_blacklist'], 
            'sjaakie-jokeapi-settings',
            'sjaakie_main_section'
        );
    }

    public function joke_amount()
    {
        $options = get_option(self::OPTION_KEY);
        $value = isset($options['amount']) ? $options['amount'] : 1;

        printf(
            '<input type="number" name="%s[amount]" value="%s" min="1" max="10" class="small-text">',
            self::OPTION_KEY,
            esc_attr($value)
        );
        echo '<p class="description">How many jokes to fetch at once (Max 10).</p>';
    }

    public function jokes_categories()
    {
        $options = get_option(self::OPTION_KEY);
        $stored_cats = isset($options['categories']) && is_array($options['categories'])
            ? $options['categories']
            : ['Any'];

        $available = ['Any', 'Programming', 'Misc', 'Dark', 'Pun', 'Spooky', 'Christmas'];

        echo '<fieldset>';
        foreach ($available as $cat) {
            $checked = in_array($cat, $stored_cats) ? 'checked' : '';
            printf(
                '<label><input type="checkbox" name="%s[categories][]" value="%s" %s> %s</label><br>',
                self::OPTION_KEY,
                $cat,
                $checked,
                $cat
            );
        }
        echo '</fieldset>';
    }

    public function sjaakie_blacklist()
    {
        $options = get_option(self::OPTION_KEY);
        $stored_list = isset($options['blacklist']) && is_array($options['blacklist'])
            ? $options['blacklist']
            : [];

        $flags = ['nsfw', 'religious', 'political', 'racist', 'sexist', 'explicit'];

        echo '<fieldset>';
        foreach ($flags as $flag) {
            $checked = in_array($flag, $stored_list) ? 'checked' : '';
            printf(
                '<label><input type="checkbox" name="%s[blacklist][]" value="%s" %s> %s</label><br>',
                self::OPTION_KEY,
                $flag,
                $checked,
                ucfirst($flag)
            );
        }
        echo '</fieldset>';
    }

    public function render_settings_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('sjaakie_joke_options_group');

                do_settings_sections('sjaakie-jokeapi-settings');

                submit_button('Save Settings');
                ?>
            </form>
        </div>
<?php
    }
}
