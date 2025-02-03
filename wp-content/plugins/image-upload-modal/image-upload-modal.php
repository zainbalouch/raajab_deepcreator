<?php
/**
 * Plugin Name: Image Upload Modal
 * Description: A plugin to display a modal for image upload on the freelancer dashboard page.
 * Version: 1.0
 * Author: Mattia Noris
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Function to display the modal
function ium_add_modal() {
    if (is_page('freelancer-dashboard')) {
        global $current_user;
        wp_get_current_user();
        $user_id = $current_user->ID;
        $ium_is_first_login = get_user_meta($user_id, 'ium_is_first_login', true);
        
        if ($ium_is_first_login == 1) : 

            $freelancer_avatar_url = get_user_meta($user_id, 'author_avatar_image_url', true);
            $freelancer_avatar_id = get_user_meta($user_id, 'author_avatar_image_id', true);
        ?>
            <div id="felan-first-login-modal" class="felan-modal">
                <div class="felan-modal-content">
                    <span class="felan-close-modal">&times;</span>
                    <h2>Welcome to Deep Creator!  </h2>
                    <p>Upload your profile image to see the magic ✨</p>
                    
                    <div class="freelancer-fields-avatar felan-fields-avatar">
                        <div class="form-field">
                            <div id="felan_avatar_errors" class="errors-log"></div>
                            <div id="felan_avatar_container" class="file-upload-block preview">
                                <div id="felan_avatar_view" data-image-id="<?php echo esc_attr($freelancer_avatar_id); ?>" data-image-url="<?php echo esc_url($freelancer_avatar_url); ?>"></div>
                                <div id="felan_add_avatar">
                                    <i class="far fa-arrow-from-bottom large la-upload"></i>
                                    <p id="felan_drop_avatar">
                                        <button type="button" id="felan_select_avatar"><?php esc_html_e('Upload', 'felan-framework') ?></button>
                                    </p>
                                </div>
                                <input type="hidden" class="avatar_url form-control" name="author_avatar_image_url" value="<?php echo esc_url($freelancer_avatar_url); ?>" id="avatar_url">
                                <input type="hidden" class="avatar_id" name="author_avatar_image_id" value="<?php echo esc_attr($freelancer_avatar_id); ?>" id="avatar_id" />
                                <input type="hidden" value="<?php echo $user_id ?>" name="user_id">
                                <input type="hidden" value="<?php echo home_url('/freelancer-profile/'); ?>" name="redirect_url" id="redirect_url">
                            </div>
                        </div>
                        <div class="field-note"><?php echo sprintf(__('Maximum file size: %s.', 'felan-framework'), '2MB'); ?></div>
                    </div>
                    <button type="button" id="ium-save-profile-image" class="felan-button button-primary">Save and Continue</button>
                </div>
            </div>
        <?php endif;
    }
}
add_action('wp_footer', 'ium_add_modal');

// Enqueue scripts
function ium_enqueue_scripts() {
    if (is_page('freelancer-dashboard')) {
        // Enqueue Plupload
        wp_enqueue_script('plupload-all');
        
        // Enqueue your modal script
        wp_enqueue_script('ium-modal-script', plugins_url('ium-modal.js', __FILE__), array('jquery', 'plupload-all'), '1.0', true);
        
        // Enqueue the modal CSS
        wp_enqueue_style('ium-modal-style', plugins_url('style.css', __FILE__));

        // Make sure the avatar script is loaded
        if (function_exists('felan_get_avatar_enqueue')) {
            felan_get_avatar_enqueue();
        }

        // Add necessary variables for the avatar upload
        wp_localize_script('ium-modal-script', 'felan_avatar_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'avatar_upload_nonce' => wp_create_nonce('felan_avatar_upload')
        ));
    }
}
add_action('wp_enqueue_scripts', 'ium_enqueue_scripts');



