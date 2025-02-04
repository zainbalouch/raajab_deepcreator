<?php
/**
 * Plugin Name: Image Replacement API
 * Description: A custom plugin to replace images through API.
 * Version: 1.1
 * Author: Mattia Noris
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Hook to initialize the plugin
function image_replacement_api_init() {
    // Enqueue JavaScript for handling the AJAX call
    // wp_enqueue_script('image-replacement-api-js', plugin_dir_url(__FILE__) . 'image-replacement-api.js', array('jquery'), null, true);
    wp_localize_script('image-replacement-api-js', 'imageReplacementApi', array(
        'ajax_url' => admin_url('admin-ajax.php'), // WordPress AJAX URL
    ));
}

add_action('wp_enqueue_scripts', 'image_replacement_api_init');

// Handle the image replacement AJAX request
function handle_image_replacement() {
    // Check if the required data is sent
    if (isset($_POST['image_url'])) {
        $image_url = sanitize_text_field($_POST['image_url']);
        // $image_url = 'https://i1.rgstatic.net/ii/profile.image/11431281111388999-1672948153451_Q512/Zain-Ul-Eman.jpg';
        $style_image_url = 'https://pics.craiyon.com/2023-09-05/803e50d8347b470e8cb6b1eff41132bb.webp';
        $text_prompt = 'make it animated Cyberpunk style character';

        // Step 1: Make a POST request to the cartoon API to generate the image
        $cartoon_response = generate_cartoon_image($image_url, $style_image_url, $text_prompt);
        
        if (is_wp_error($cartoon_response)) {
            wp_send_json_error(array('message' => $cartoon_response->get_error_message()));
            wp_die();
        }

        $order_id = $cartoon_response['orderId'];
        // $order_id = '7e659a3327f848e6a5586f1c49d3d996';
        
        // Step 2: Make a POST request to the order-status API to get the image URL
        $status_response = get_image_generation_status($order_id);
        // print_r($status_response);
        if (is_wp_error($status_response)) {
            wp_send_json_error(array('message' => 'Error in is_wp_error: '.$status_response->get_error_message()));
            wp_die();
        }

        $new_image_url = $status_response['output'];
        // Step 3: Download and replace the image
        $tmp_file = download_image_from_url($new_image_url);

        if (!$tmp_file) {
            wp_send_json_error(array('message' => 'Failed to download the new image.'));
            wp_die();
        }

        
        $parsed_url = parse_url(sanitize_text_field($_POST['image_url']));  // Extract the directory and filename from the original image URL
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $parsed_url['path']; // Full path to the original image
        $directory = dirname($file_path); // Get the directory of the original image
        $filename = basename($file_path); // Get the filename of the original image

        // Make sure the directory exists before replacing the image
        if (!is_dir($directory)) {
            wp_send_json_error(array('message' => 'Directory not found.'));
            wp_die();
        }

        // Target path to save the new image (same name, same directory)
        $target_path = $directory . '/' . $filename;

        // Replace the old image with the new one
        if (rename($tmp_file, $target_path)) {
            // Delete the old image (if it exists and isn't the same as the new one)
                // if (file_exists($file_path) && $file_path !== $target_path) {
                //     unlink($file_path); // Delete the old file
                // }


            // Return the new image URL
            wp_send_json_success(array(
                'new_image_url' => $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path']
            ));
        } else {
            error_log('Constructed URL: ' . $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path']);
            wp_send_json_error(array('message' => 'Failed to save the image.'));
        }
    } else {
        wp_send_json_error(array('message' => 'No image URL, style image URL, or text prompt provided'));
    }

    wp_die(); // Always call this to properly terminate the AJAX request
}

add_action('wp_ajax_replace_image', 'handle_image_replacement'); // For logged-in users
add_action('wp_ajax_nopriv_replace_image', 'handle_image_replacement'); // For non-logged-in users

// Helper function to download image from URL
function download_image_from_url($image_url) {
    // Get the image content
    $image_content = file_get_contents($image_url);

    if (!$image_content) {
        return false;
    }

    // Create a temporary file to store the image
    $tmp_file = tempnam(sys_get_temp_dir(), 'image_replace_');
    file_put_contents($tmp_file, $image_content);

    return $tmp_file;
}

// Function to generate cartoon image using the external API
function generate_cartoon_image($image_url, $style_image_url, $text_prompt) {
    $api_url = 'https://api.lightxeditor.com/external/api/v1/cartoon';
    $api_key = 'c673d02654c34f5b90b3866e53230889_b4a8a2723de54d54849e538292cc2734_andoraitools';

    $body = json_encode(array(
        'imageUrl' => $image_url,
        'styleImageUrl' => $style_image_url,
        'textPrompt' => $text_prompt
    ));

    $response = wp_remote_post($api_url, array(
        'method'    => 'POST',
        'headers'   => array(
            'Content-Type'  => 'application/json',
            'x-api-key'     => $api_key,
        ),
        'body'      => $body
    ));

    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Error communicating with the API');
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    if ($data['statusCode'] !== 2000) {
        return new WP_Error('api_error', 'API request failed in generate_cartoon_image fun: ' . $data['message']);
    }

    return $data['body'];
}

// Function to check the status of the image generation
function get_image_generation_status($order_id) {
    $api_url = 'https://api.lightxeditor.com/external/api/v1/order-status';
    $api_key = 'c673d02654c34f5b90b3866e53230889_b4a8a2723de54d54849e538292cc2734_andoraitools';

    $body = json_encode(array(
        'orderId' => $order_id
    ));

    $max_attempts = 5;
    $attempts = 0;
    $status = 'init';
    $response_data = null;

    while ($status === 'init' && $attempts < $max_attempts) {
        $response = wp_remote_post($api_url, array(
            'method'    => 'POST',
            'headers'   => array(
                'Content-Type'  => 'application/json',
                'x-api-key'     => $api_key,
            ),
            'body'      => $body
        ));

        if (is_wp_error($response)) {
            return new WP_Error('api_error', 'Error communicating with the API');
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);

        if ($data['statusCode'] !== 2000) {
            return new WP_Error('api_error', 'API request failed in get_image_generation_status: ('. $order_id.')' . $data['message']);
        }

        $status = $data['body']['status'];
        $response_data = $data['body'];

        if ($status === 'init') {
            // Wait for 3 seconds before the next attempt
            sleep(3);
        }

        $attempts++;
    }

    if ($status !== 'active') {
        return new WP_Error('api_error', 'Image generation is still in progress after maximum attempts.');
    }

    // Successful image generation, return the data
    return $response_data;
}
