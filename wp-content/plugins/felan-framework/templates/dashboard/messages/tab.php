<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$data_list_all = felan_get_data_list_message(false);
$data_list_unread = felan_get_data_list_message(false, true);
$total_unread = $data_list_unread->found_posts;
$no_image_src = FELAN_PLUGIN_URL . 'assets/images/no-image.jpg';
?>

<a href="#" class="icon-nav-mess">
    <i class="far fa-comments"></i>
</a>
<div class="tab-mess">
    <div class="mess-tab-head">
        <ul class="tab-list-mess">
            <li class="tab-item tab-all"><a href="#tab-all"><?php esc_html_e('All', 'felan-framework'); ?></a></li>
            <li class="tab-item tab-unread"><a href="#tab-unread"><?php esc_html_e('Unread', 'felan-framework'); ?><span>(<?php echo $total_unread; ?>)</span></a>
            </li>
        </ul>
        <span class="mess-refresh">
            <i class="far fa-sync fa-spin"></i>
            <span><?php esc_html_e('Refresh', 'felan-framework'); ?></span>
        </span>
    </div>
    <div class="tab-content custom-scrollbar">
        <div class="tab-info" id="tab-all">
            <?php felan_get_template('dashboard/messages/list-user.php', array(
                'data_list' => $data_list_all,
            )); ?>
        </div>
        <div class="tab-info" id="tab-unread">
            <?php felan_get_template('dashboard/messages/list-user.php', array(
                'data_list' => $data_list_unread,
            )); ?>
        </div>
    </div>
</div>