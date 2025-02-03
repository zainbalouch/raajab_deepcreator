<?php
/*
Plugin Name: User Badge Manager
Description: Adds a badge dropdown for users and displays it on their profile page with customizable colors.
Version: 1.0
Author: Mattia Noris
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add badge field to user profile and edit screens
function ubm_add_badge_field($user)
{
    $badge = get_user_meta($user->ID, 'ubm_user_badge', true);
    $settings_url = admin_url('admin.php?page=ubm-settings'); // Badge settings page URL
?>
    <h3>User Badge</h3>
    <table class="form-table">
        <tr>
            <th><label for="ubm_user_badge">Badge</label></th>
            <td>
                <select name="ubm_user_badge" id="ubm_user_badge">
                    <option value="none" <?php selected($badge, 'none'); ?>>None</option>
                    <option value="beginner" <?php selected($badge, 'beginner'); ?>>Beginner</option>
                    <option value="intermediate" <?php selected($badge, 'intermediate'); ?>>Intermediate</option>
                    <option value="advanced" <?php selected($badge, 'advanced'); ?>>Advanced</option>
                </select>
                <p class="description">
                    Change badge background color of each badge in the 
                    <a href="<?php echo esc_url($settings_url); ?>" target="_blank">Badge Settings</a> page.
                </p>
            </td>
        </tr>
    </table>
<?php
}

add_action('show_user_profile', 'ubm_add_badge_field');
add_action('edit_user_profile', 'ubm_add_badge_field');

// Save badge field data
function ubm_save_badge_field($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'ubm_user_badge', $_POST['ubm_user_badge']);
}
add_action('personal_options_update', 'ubm_save_badge_field');
add_action('edit_user_profile_update', 'ubm_save_badge_field');


// Admin settings for badge colors
function ubm_register_settings()
{
    register_setting('ubm_settings_group', 'ubm_badge_colors');
}
add_action('admin_init', 'ubm_register_settings');

function ubm_settings_page()
{
    add_menu_page(
        'Badge Settings',
        'Badge Settings',
        'manage_options',
        'ubm-settings',
        'ubm_render_settings_page',
        'dashicons-admin-customizer',
        100
    );
}
add_action('admin_menu', 'ubm_settings_page');

function ubm_render_settings_page()
{
    $colors = get_option('ubm_badge_colors', [
        'none' => '#ccc',
        'beginner' => '#28a745',
        'intermediate' => '#ffc107',
        'advanced' => '#dc3545',
    ]);
?>
    <div class="wrap">
        <h1>Badge Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('ubm_settings_group'); ?>
            <?php do_settings_sections('ubm_settings_group'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="ubm_badge_colors[none]">None</label></th>
                    <td><input type="color" name="ubm_badge_colors[none]" value="<?php echo esc_attr($colors['none']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="ubm_badge_colors[beginner]">Beginner</label></th>
                    <td><input type="color" name="ubm_badge_colors[beginner]" value="<?php echo esc_attr($colors['beginner']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="ubm_badge_colors[intermediate]">Intermediate</label></th>
                    <td><input type="color" name="ubm_badge_colors[intermediate]" value="<?php echo esc_attr($colors['intermediate']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="ubm_badge_colors[advanced]">Advanced</label></th>
                    <td><input type="color" name="ubm_badge_colors[advanced]" value="<?php echo esc_attr($colors['advanced']); ?>"></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Shortcode to display the user badge
function ubm_user_badge_shortcode($atts)
{
    // Extract shortcode attributes
    $atts = shortcode_atts(
        ['user_id' => get_current_user_id()], // Default to current user
        $atts,
        'user_badge'
    );

    // Get the user ID
    $user_id = intval($atts['user_id']);
    if (!$user_id) {
        return '<p>No user badge to display.</p>';
    }

    // Get the badge and badge colors
    $badge = get_user_meta($user_id, 'ubm_user_badge', true);
    $badge_colors = get_option('ubm_badge_colors', [
        'none' => '#ccc',
        'beginner' => '#28a745',
        'intermediate' => '#ffc107',
        'advanced' => '#dc3545',
    ]);

    $color = isset($badge_colors[$badge]) ? $badge_colors[$badge] : '#ccc';

    // Return the styled badge HTML
    return '<div style="display: inline-block; padding: 5px 10px; background-color: ' . esc_attr($color) . '; color: #fff; border-radius: 5px;">'
        . ucfirst($badge)
        . '</div>';
}
add_shortcode('user_badge', 'ubm_user_badge_shortcode');
