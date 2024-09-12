<?php

// Add menu item for API Key settings
function openai_text_generator_menu() {
    add_menu_page(
        'Trustloud API Settings',
        'Trustloud Settings',
        'manage_options',
        'openai-text-generator-settings',
        'openai_text_generator_settings_page',
        'dashicons-admin-generic',
        100
    );
}
add_action('admin_menu', 'openai_text_generator_menu');

// Display the settings page
function openai_text_generator_settings_page() {
    ?>
    <div class="wrap">
        <h1>OpenAI API Key Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('openai_settings_group');
            do_settings_sections('openai-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register the API Key setting
function openai_register_settings() {
    register_setting('openai_settings_group', 'openai_api_key');
    add_settings_section('openai_settings_section', '', null, 'openai-settings');

    add_settings_field(
        'openai_api_key',
        'OpenAI API Key',
        'openai_api_key_field_callback',
        'openai-settings',
        'openai_settings_section'
    );
}
add_action('admin_init', 'openai_register_settings');

// Callback for the API Key field
function openai_api_key_field_callback() {
    $api_key = get_option('openai_api_key');
    echo '<input type="text" name="openai_api_key" value="' . esc_attr($api_key) . '" style="width: 400px;">';
}
