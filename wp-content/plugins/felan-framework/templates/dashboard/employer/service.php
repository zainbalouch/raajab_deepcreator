<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $current_user;
$user_id = $current_user->ID;
$order_id = isset($_GET['order_id']) ? felan_clean(wp_unslash($_GET['order_id'])) : '';

if (!empty($order_id)) { ?>
    <div class="felan-employer-service entry-my-page">
        <div class="entry-title">
            <h4><?php esc_html_e('Service History', 'felan-framework'); ?></h4>
        </div>
        <?php felan_get_template('dashboard/employer/service/order-detail.php'); ?>
    </div>
<?php } else { ?>
    <div class="felan-employer-service entry-my-page">
        <div class="entry-title">
            <h4><?php esc_html_e('My Services', 'felan-framework'); ?></h4>
        </div>
        <div class="tab-dashboard">
            <ul class="tab-list">
                <li class="tab-item tab-orders-item"><a href="#tab-orders"><?php esc_html_e('My Orders', 'felan-framework'); ?></a></li>
                <li class="tab-item tab-service-item"><a href="#tab-wishlist"><?php esc_html_e('My Wishlist', 'felan-framework'); ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-info" id="tab-wishlist">
                    <?php felan_get_template('dashboard/employer/service/my-wishlist.php'); ?>
                </div>
                <div class="tab-info" id="tab-orders">
                    <?php felan_get_template('dashboard/employer/service/my-orders.php'); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>