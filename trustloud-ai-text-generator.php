<?php
/*
Plugin Name: TrustLoud AI text Generator
Description: A simple plugin to generat story text by use of OpenAI.
Version: 1.0
Author: Trustloud
Author URI: https://www.trustloud.com
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include the admin settings file
require_once plugin_dir_path(__FILE__) . 'admin-settings.php';

// Register the shortcode
function openai_text_generator_shortcode() {
    ob_start();
    ?>
    <div id="text-generation-tool">
        <input type="text" id="topic" placeholder="Your Topic...">
        <button id="generate-button">Generate Story!</button>
        <div id="result-container" style="display: none;">
            <div class="result-wrapper">
                <div class="result-content">
                    <textarea id="result" readonly></textarea>
                </div>
                <div class="copy-button-container">
                    <button id="copy-button">Copy</button>
                </div>
            </div>
        </div>
        <div id="loading" class="loader" style="display: none;"></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('trustloud_text_generator', 'openai_text_generator_shortcode');

// Enqueue scripts and styles
function openai_enqueue_scripts() {
    wp_enqueue_script('openai-text-generator-js', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
    wp_enqueue_style('openai-text-generator-css', plugin_dir_url(__FILE__) . 'assets/css/style.css');

    // Localize script to pass AJAX URL
    wp_localize_script('openai-text-generator-js', 'openai_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'openai_enqueue_scripts');
// Check if MyCred plugin is active
function check_mycred_plugin() {
    if (!is_plugin_active('mycred/mycred.php')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('This plugin requires the MyCred plugin to be installed and activated.');
    }
}
add_action('admin_init', 'check_mycred_plugin');

// Ajax function to generate text
function openai_generate_text() {
    $prompt = sanitize_text_field($_POST['prompt']);

    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to use this tool.');
    }

    $user_id = get_current_user_id();
    $user_points = mycred_get_users_balance($user_id);

    if ($user_points < 5) {
        wp_send_json_error('You need at least 5 points in your Mycred wallet to use this tool please Recharge your Wallet or Buy Plan');
    }

    $api_key = get_option('openai_api_key');

    if (!$api_key) {
        wp_send_json_error('API key is not set. Please configure the API key in the settings.');
    }

    $api_url = 'https://api.openai.com/v1/chat/completions';
    $headers = [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $api_key
    ];

    $body = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [['role' => 'user', 'content' => $prompt]],
        'temperature' => 0.7
    ];

    $args = [
        'method' => 'POST',
        'headers' => $headers,
        'body' => json_encode($body),
        'timeout' => 120
    ];

    $response = wp_remote_post($api_url, $args);

    if (is_wp_error($response)) {
        wp_send_json_error('An error occurred: ' . $response->get_error_message());
    } else {
        $data = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($data['error'])) {
            wp_send_json_error('An error occurred: ' . $data['error']['message']);
        } elseif (!isset($data['choices'])) {
            wp_send_json_error('An error occurred: No valid response from the API.');
        } else {
            mycred_subtract('openai-text-generation', 5, $user_id, 'Deducted 5 points for text generation');
            wp_send_json_success($data);
        }
    }

    wp_die();
}
add_action('wp_ajax_openai_generate_text', 'openai_generate_text');
add_action('wp_ajax_nopriv_openai_generate_text', 'openai_generate_text');
