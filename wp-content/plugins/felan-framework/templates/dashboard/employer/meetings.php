<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
wp_enqueue_script(FELAN_PLUGIN_PREFIX . 'meetings');
wp_localize_script(
    FELAN_PLUGIN_PREFIX . 'meetings',
    'felan_meetings_vars',
    array(
        'ajax_url' => FELAN_AJAX_URL,
        'not_meetings' => esc_html__('No meetings found', 'felan-framework'),
    )
);
global $current_user;
$user_id = $current_user->ID;
$action = 'edit-meetings';
$posts_per_page = 9;
$user_demo = get_the_author_meta(FELAN_METABOX_PREFIX . 'user_demo', $user_id);

$args_upcoming = array(
    'post_type' => 'meetings',
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'offset' => (max(1, get_query_var('paged')) - 1) * $posts_per_page,
    'author' => $user_id,
    'orderby' => 'date',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => FELAN_METABOX_PREFIX . 'meeting_status',
            'value' => 'completed',
            'compare' => '!='
        )
    ),
);
$data_upcoming = new WP_Query($args_upcoming);

$args_completed = array(
    'post_type' => 'meetings',
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'offset' => (max(1, get_query_var('paged')) - 1) * $posts_per_page,
    'author' => $user_id,
    'orderby' => 'date',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => FELAN_METABOX_PREFIX . 'meeting_status',
            'value' => 'completed',
            'compare' => '='
        )
    ),
);
$data_completed = new WP_Query($args_completed);
?>

<div class="entry-my-page meetings-dashboard mettings-action-dashboard">
    <div class="entry-title">
        <h4><?php esc_html_e('Meetings', 'felan-framework') ?></h4>
    </div>
    <div class="tab-dashboard tab-upcoming">
        <div class="tabs-header">
            <ul class="tab-list">
                <li class="tab-item"><a href="#tab-upcoming"><?php esc_html_e('Upcoming', 'felan-framework'); ?></a></li>
                <li class="tab-item"><a href="#tab-completed"><?php esc_html_e('Completed', 'felan-framework'); ?></a>
                </li>
            </ul>
            <a href="#" class="felan-button" id="btn-meeting-settings"><?php esc_html_e('Zoom Settings', 'felan-framework'); ?></a>
        </div>
        <div class="tab-content">
            <div class="tab-info" id="tab-upcoming">
                <?php if ($data_upcoming->have_posts()) { ?>
                    <div class="row">
                        <?php while ($data_upcoming->have_posts()) : $data_upcoming->the_post();
                            global $current_user;
                            $user_id = $current_user->ID;
                            $meeting_id = get_the_ID();
                            $meeting_date = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_date', true);
                            $meeting_time = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_time', true);
                            $meeting_time_duration = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_time_duration', true);
                            $meeting_message = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_message', true);
                            $meeting_with = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_with', true);
                            $zoom_link = get_user_meta($user_id, FELAN_METABOX_PREFIX . 'metting_zoom_link', true);
                            $zoom_pw = get_user_meta($user_id, FELAN_METABOX_PREFIX . 'metting_zoom_pw', true);
                            $current_date = date('Y-m-d');
                            $time_date_current = date('H:i');
                            $time_date_current = get_date_from_gmt($time_date_current, 'H:i');
                            $time_date_end = date('H:i', strtotime('+' . $meeting_time_duration . 'minutes', strtotime($meeting_time)));
                            $meeting_date_val = felan_convert_date_format($meeting_date);

                            if ((strtotime($meeting_date) < strtotime($current_date)) ||
                                (strtotime($meeting_date) == strtotime($current_date) && strtotime($time_date_end) < strtotime($time_date_current))){
                                $additional_class = 'expired';
                            } else {
                                $additional_class = '';
                            }
                            ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="meetings-warpper <?php echo esc_attr($additional_class); ?>">
                                    <div class="meetings-top">
                                        <?php if ((strtotime($meeting_date) < strtotime($current_date))
                                            || (strtotime($meeting_date) == strtotime($current_date) && strtotime($time_date_end) < strtotime($time_date_current))
                                        ) : ?>
                                            <span class="label label-close"><?php esc_html_e('Expired', 'felan-framework') ?></span>
                                        <?php endif; ?>

                                        <?php if (strtotime($meeting_date) == strtotime($current_date)) : ?>
                                            <p class="calendar is-active">
                                                <i class="far fa-calendar-alt"></i><?php esc_html_e('Today', 'felan-framework') ?>
                                                <span class="dot">.</span> <?php esc_html_e($meeting_time) ?>
                                            </p>
                                        <?php else : ?>
                                            <p class="calendar">
                                                <i class="far fa-calendar-alt"></i><?php esc_html_e($meeting_date_val) ?>
                                                <span class="dot">.</span> <?php esc_html_e($meeting_time) ?>
                                            </p>
                                        <?php endif; ?>
                                        <h6><?php echo get_the_title(); ?></h6>
                                        <p class="meeting-width"><?php esc_html_e('Meeting with:', 'felan-framework'); ?>
                                            <span class="athour"><?php esc_html_e($meeting_with) ?></span>
                                        </p>
                                        <p class="meeting_message"><?php esc_html_e($meeting_message) ?></p>
                                    </div>
                                    <div class="meetings-bottom">
                                        <span class="social zoom">
                                            <i class="far fa-video-plus"></i>
                                            <span><?php esc_html_e('Via Zoom', 'felan-framework'); ?></span>
                                        </span>
                                        <span class="social time">
                                            <i class="far fa-clock"></i>
                                            <span><?php esc_html_e($meeting_time_duration) ?> <?php esc_html_e('Minutes', 'felan-framework'); ?></span>
                                        </span>
                                        <div class="action action-setting">
                                            <a href="#" class="icon-setting"><i class="far fa-ellipsis-v"></i></a>
                                            <ul class="action-dropdown">
                                                <li><a class="btn-edit btn-reschedule-meetings" data-id="<?php echo esc_attr($meeting_id); ?>" href="#"><?php esc_html_e('Edit', 'felan-framework') ?></a></li>
                                                <li><a class="btn-completed" meeting-id="<?php echo esc_attr($meeting_id); ?>" href="#"><?php esc_html_e('Completed', 'felan-framework') ?></a>
                                                </li>
                                                <?php if ($user_demo == 'yes') : ?>
                                                    <li><a class="btn-add-to-message" data-text="<?php echo esc_attr('Oops! Sorry. This action is restricted on the demo site.', 'felan-framework'); ?>" href="#"><?php esc_html_e('Delete', 'felan-framework') ?></a></li>
                                                <?php else : ?>
                                                    <li><a class="btn-delete" meeting-id="<?php echo esc_attr($meeting_id); ?>" href="#"><?php esc_html_e('Delete', 'felan-framework') ?></a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php if (strtotime($meeting_date) == strtotime($current_date) && $time_date_current >=  $meeting_time && $time_date_current <= $time_date_end) : ?>
                                        <div class="meeting-info-settings">
                                            <div class="meeting-zoom-link">
                                                <span><?php esc_html_e('Start meeting:', 'felan-framework'); ?></span>
                                                <a href="<?php echo esc_url($zoom_link) ?>"><?php esc_html_e('Here', 'felan-framework'); ?></a>
                                            </div>
                                            <div class="meeting-zoom-pw">
                                                <span><?php esc_html_e('Password:', 'felan-framework'); ?></span>
                                                <?php esc_html_e($zoom_pw) ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php } else { ?>
                    <div class="item-not-found"><?php esc_html_e('No item found', 'felan-framework'); ?></div>
                <?php } ?>
                <div class="felan-loading-effect"><span class="felan-dual-ring"></span></div>
                <?php $max_num_upcoming = $data_upcoming->max_num_pages;
                $total_post_upcoming = $data_upcoming->found_posts;
                ?>
                <div class="pagination-dashboard">
                    <?php felan_get_template('global/pagination.php', array('total_post' => $total_post_upcoming, 'max_num_pages' => $max_num_upcoming, 'layout' => 'number'));
                    wp_reset_postdata(); ?>
                </div>
            </div>
            <div class="tab-info" id="tab-completed">
                <?php if ($data_completed->have_posts()) { ?>
                    <div class="row">
                        <?php while ($data_completed->have_posts()) : $data_completed->the_post();
                            $meeting_id = get_the_ID();
                            $meeting_date = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_date', true);
                            $meeting_time = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_time', true);
                            $meeting_time_duration = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_time_duration', true);
                            $meeting_message = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_message', true);
                            $meeting_with = get_post_meta($meeting_id, FELAN_METABOX_PREFIX . 'meeting_with', true);
                        ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="meetings-warpper">
                                    <div class="meetings-top">
                                        <p class="calendar"><i class="far fa-calendar-alt"></i><?php esc_html_e($meeting_date) ?>
                                            <span class="dot">.</span> <?php esc_html_e($meeting_time) ?>
                                        </p>
                                        <h6><?php echo get_the_title(); ?></h6>
                                        <p class="meeting-width"><?php esc_html_e('Meeting with:', 'felan-framework'); ?>
                                            <span class="athour"><?php esc_html_e($meeting_with) ?></span>
                                        </p>
                                        <p class="meeting_message"><?php esc_html_e($meeting_message) ?></p>
                                    </div>
                                    <div class="meetings-bottom">
                                        <span class="social zoom">
                                            <i class="far fa-video-plus"></i>
                                            <span><?php esc_html_e('Via Zoom', 'felan-framework'); ?></span>
                                        </span>
                                        <span class="social time">
                                            <i class="far fa-clock"></i>
                                            <span><?php esc_html_e($meeting_time_duration) ?> <?php esc_html_e('Minutes', 'felan-framework'); ?></span>
                                        </span>
                                        <div class="action action-setting">
                                            <a href="#" class="icon-setting"><i class="far fa-ellipsis-v"></i></a>
                                            <ul class="action-dropdown">
                                                <li><a class="btn-upcoming" meeting-id="<?php echo esc_attr($meeting_id); ?>" href="#"><?php esc_html_e('Upcoming', 'felan-framework') ?></a>
                                                </li>

                                                <?php if ($user_demo == 'yes') : ?>
                                                    <li><a class="btn-add-to-message" data-text="<?php echo esc_attr('Oops! Sorry. This action is restricted on the demo site.', 'felan-framework'); ?>" href="#"><?php esc_html_e('Delete', 'felan-framework') ?></a></li>
                                                <?php else : ?>
                                                    <li><a class="btn-delete" meeting-id="<?php echo esc_attr($meeting_id); ?>" href="#"><?php esc_html_e('Delete', 'felan-framework') ?></a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php } else { ?>
                    <div class="item-not-found"><?php esc_html_e('No item found', 'felan-framework'); ?></div>
                <?php } ?>
                <div class="felan-loading-effect"><span class="felan-dual-ring"></span></div>
                <?php $max_num_completed = $data_completed->max_num_pages;
                $total_post_completed = $data_completed->found_posts;
                ?>
                <div class="pagination-dashboard">
                    <?php felan_get_template('global/pagination.php', array('total_post' => $total_post_completed, 'max_num_pages' => $max_num_completed, 'layout' => 'number'));
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="mettings_action" value="<?php echo esc_attr($action) ?>" />
</div>