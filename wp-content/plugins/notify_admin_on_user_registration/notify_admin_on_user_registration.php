<?php
/*
Plugin Name: Notify Admin on New User Registration
Description: Sends an email to the admin and shows a notification on the dashboard whenever a new user registers. Includes view all notifications page with read/unread tracking.
Version: 1.0
Author: Mattia Noris
*/

// If accessed directly, exit.
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue the custom CSS for styling notifications
function enqueue_notification_styles() {
    wp_enqueue_style('notification-style', plugin_dir_url(__FILE__) . 'notification-style.css');
}
add_action('admin_enqueue_scripts', 'enqueue_notification_styles');

// Function to send email to admin on user registration and add a notification
function notify_admin_on_user_registration($user_id) {
    // Get user data
    $user_info = get_userdata($user_id);

    // Admin email address (can be customized)
    $admin_email = 'zainuleman786@gmail.com';

    // Email subject
    $subject = 'New User Registration';

    // Email message
    $message = sprintf(
        "A new user has registered on your website.\n\nUsername: %s\nEmail: %s",
        $user_info->user_login,
        $user_info->user_email
    );

    // Send email to admin
    wp_mail($admin_email, $subject, $message);

    // Add a notification (storing first name, last name, email, and time in the WordPress options table)
    $notifications = get_option('admin_user_registration_notifications', []);
    $notifications[] = [
        'first_name' => $user_info->first_name,
        'last_name'  => $user_info->last_name,
        'email'      => $user_info->user_email,
        'time'       => current_time('mysql')
    ];
    update_option('admin_user_registration_notifications', $notifications);
}

// Hook into user registration
add_action('user_register', 'notify_admin_on_user_registration');

// Function to display the last 5 notifications in the admin dashboard
function display_new_user_registration_notification() {
    if (current_user_can('administrator')) {
        // Get the current screen information
        $current_screen = get_current_screen();

        // Only display on the dashboard page (wp-admin/index.php)
        if ($current_screen->id === 'dashboard') {
            $notifications = get_option('admin_user_registration_notifications', []);

            if (!empty($notifications)) {
                $last_notifications = array_slice(array_reverse($notifications), 0, 5);

                echo '<div class="notice notice-success notice-new-user-registration">';
                echo '<h3>Newly Registered Users</h3>';
                echo '<table class="notification-table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Name</th>';
                echo '<th>Email</th>';
                echo '<th>Time</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($last_notifications as $notification) {
                    echo '<tr>';
                    echo '<td>' . esc_html($notification['first_name'] . ' ' . $notification['last_name']) . '</td>';
                    echo '<td>' . esc_html($notification['email']) . '</td>';
                    echo '<td>' . esc_html($notification['time']) . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '<a href="' . admin_url('admin.php?page=all_notifications') . '">View All Notifications</a>';
                echo '</div>';
            }
        }
    }
}

// Hook to display the notification in the admin dashboard
add_action('admin_notices', 'display_new_user_registration_notification');

// Add a menu item for viewing all notifications
function add_notifications_menu_item() {
    add_menu_page(
        'All Notifications',
        'All Notifications',
        'manage_options',
        'all_notifications',
        'display_all_notifications_page',
        'dashicons-bell',
        6
    );
}

// Function to display all notifications on a separate page
function display_all_notifications_page() {
    if (current_user_can('administrator')) {
        echo '<div class="wrap"><h1>All Notifications</h1>';
        $notifications = array_reverse(get_option('admin_user_registration_notifications', []));

        if (!empty($notifications)) {
            echo '<div class="notice notice-success notice-new-user-registration">';
            echo '<h3>Newly Registered Users</h3>';
            echo '<table class="notification-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '<th>Email</th>';
            echo '<th>Time</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($notifications as $notification) {
                echo '<tr>';
                echo '<td>' . esc_html($notification['first_name'] . ' ' . $notification['last_name']) . '</td>';
                echo '<td>' . esc_html($notification['email']) . '</td>';
                echo '<td>' . esc_html($notification['time']) . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>No notifications found.</p>';
        }

        echo '</div>';
    }
}

// Hook to add the menu item
add_action('admin_menu', 'add_notifications_menu_item');
