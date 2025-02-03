<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!is_user_logged_in()) {
    felan_get_template('global/access-denied.php', array('type' => 'not_login'));
    return;
}
global $current_user;
$user_id   = $current_user->ID;
$user_name = $current_user->display_name;

wp_enqueue_script('chart');
wp_enqueue_script(FELAN_PLUGIN_PREFIX . 'chart');
$number_days = '7';
$labels = array();
for ($i = $number_days; $i >= 0; $i--) {
    $date = strtotime(date("Y-m-d", strtotime("-" . $i . " day")));
    $labels[] = date('M j, Y', $date);
}

$args = array(
    'post_type'           => 'applicants',
    'ignore_sticky_posts' => 1,
    'posts_per_page'      => 5,
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'author'              => $user_id,
);
$data = new WP_Query($args);

$show_my_jobs = felan_get_option( 'show_my_jobs', '1' );
$show_meetings = felan_get_option( 'show_freelancer_meetings', '1' );
?>
<div class="felan-dashboard felan-dashboard-freelancer area-main-control">
    <div class="entry-my-page">
        <h2 class="entry-title"><?php echo sprintf(__('Welcome back! %s', 'felan-framework'), $user_name); ?></h2>
        <div class="total-action">
            <ul class="action-wrapper row">
                <?php if($show_my_jobs) : ?>
                    <li class="col-xl-3 col-sm-6">
                        <div class="icon-dashboard-01 felan-boxdb">
                            <div class="entry-detai ">
                                <h3 class="entry-title"><?php esc_html_e('Applied Jobs', 'felan-framework'); ?></h3>
                                <span class="entry-number"><?php echo felan_total_my_apply(); ?></span>
                            </div>
                            <div class="icon-total">
                                <img src="<?php echo esc_attr(FELAN_PLUGIN_URL . 'assets/images/icon-dashboard-01.svg'); ?>" alt="<?php esc_attr_e('jobs', 'felan-framework'); ?>">
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="col-xl-3 col-sm-6">
                    <div class="icon-dashboard-04 felan-boxdb">
                        <div class="entry-detai ">
                            <h3 class="entry-title"><?php esc_html_e('My Following', 'felan-framework'); ?></h3>
                            <span class="entry-number"><?php echo felan_total_post('company', 'my_follow') ?></span>
                        </div>
                        <div class="icon-total">
                            <img src="<?php echo esc_attr(FELAN_PLUGIN_URL . 'assets/images/icon-dashboard-04.svg'); ?>" alt="<?php esc_attr_e('applications', 'felan-framework'); ?>">
                        </div>
                    </div>
                </li>
                <li class="col-xl-3 col-sm-6">
                    <div class="icon-dashboard-03 felan-boxdb">
                        <div class="entry-detai ">
                            <h3 class="entry-title"><?php esc_html_e('MY Reviews', 'felan-framework'); ?></h3>
                            <span class="entry-number"><?php echo felan_get_total_reviews(); ?></span>
                        </div>
                        <div class="icon-total">
                            <img src="<?php echo esc_attr(FELAN_PLUGIN_URL . 'assets/images/icon-dashboard-03.svg'); ?>" alt="<?php esc_attr_e('interviews', 'felan-framework'); ?>">
                        </div>
                    </div>
                </li>
                <?php if($show_meetings) : ?>
                    <li class="col-xl-3 col-sm-6">
                        <div class="icon-dashboard-02 felan-boxdb">
                            <div class="entry-detail">
                                <h3 class="entry-title"><?php esc_html_e('Meetings', 'felan-framework'); ?></h3>
                                <span class="entry-number"><?php echo felan_total_meeting('freelancer') ?></span>
                            </div>
                            <div class="icon-total">
                                <i class="far fa-video" style="color: #fff"></i>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="notification-dashboard">
            <div class="row">
                <div class="col-md-7">
                    <div class="felan-chart-warpper felan-chart-freelancer">
                        <div class="chart-header">
                            <h4 class="title-chart"><?php esc_html_e('Profile Views', 'felan-framework'); ?></h4>
                            <div class="form-chart">
                                <div class="select2-field">
                                    <select name="chart_freelancer" class="felan-select2">
                                        <option value="7"><?php esc_html_e('7 days', 'felan-framework'); ?></option>
                                        <option value="15"><?php esc_html_e('15 days', 'felan-framework'); ?></option>
                                        <option value="30"><?php esc_html_e('30 days', 'felan-framework'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <canvas id="felan-dashboard_freelancer" data-labels="<?php echo esc_attr(json_encode($labels)); ?>" data-values="<?php echo esc_attr(json_encode(felan_total_view_freelancer($number_days))); ?>" data-label="<?php esc_attr_e('Your Profile Views', 'felan-framework'); ?>">
                        </canvas>
                        <div class="felan-loading-effect"><span class="felan-dual-ring"></span></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="jobs-dashboard-wrap">
                        <h4 class="title-jobs"><?php esc_html_e('Recently Applied jobs', 'felan-framework'); ?></h4>
                        <div class="jobs-innner">
                            <?php if ($data->have_posts()) { ?>
                                <div class="jobs-content">
                                    <?php while ($data->have_posts()) : $data->the_post();
                                        $applicants_id = get_the_ID();
                                        $jobs_id = get_post_meta($applicants_id, FELAN_METABOX_PREFIX . 'applicants_jobs_id');
                                        if (!empty($jobs_id)) {
                                            $jobs_id = intval($jobs_id[0]);
                                        }
                                        global $current_user;
                                        wp_get_current_user();
                                        $user_id = $current_user->ID;
                                        $jobs_type = wp_get_post_terms($jobs_id, 'jobs-type');
                                        $jobs_categories =  wp_get_post_terms($jobs_id, 'jobs-categories');
                                        $jobs_location =  wp_get_post_terms($jobs_id, 'jobs-location');
                                        $jobs_select_company    = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_select_company');
                                        $company_id = isset($jobs_select_company[0]) ? $jobs_select_company[0] : '';
                                        $company_logo   = get_post_meta($company_id, FELAN_METABOX_PREFIX . 'company_logo');
                                        $public_date = get_the_date(get_option('date_format'));
                                        ?>
                                        <div class="company-header">
                                            <div class="img-comnpany">
                                                <?php if (!empty($company_logo[0]['url'])) : ?>
                                                    <img class="logo-comnpany" src="<?php echo $company_logo[0]['url'] ?>" alt="" />
                                                <?php else : ?>
                                                    <div class="logo-comnpany"><i class="far fa-camera"></i></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="info-jobs">
                                                <h3 class="title-jobs-dashboard">
                                                    <a href="<?php echo get_permalink($jobs_id); ?>" target="_blank">
                                                        <?php echo get_the_title($applicants_id); ?>
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </h3>
                                                <div>
                                                    <?php if (is_array($jobs_categories)) {
                                                        foreach ($jobs_categories as $categories) { ?>
                                                            <?php esc_html_e($categories->name); ?>
                                                        <?php }
                                                    } ?>
                                                    <?php if (is_array($jobs_type)) {
                                                        foreach ($jobs_type as $type) { ?>
                                                            <?php esc_html_e('/ ' . $type->name); ?>
                                                        <?php }
                                                    } ?>
                                                    <?php if (is_array($jobs_location)) {
                                                        foreach ($jobs_location as $location) { ?>
                                                            <?php esc_html_e('/ ' . $location->name); ?>
                                                        <?php }
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php } else { ?>
                                <div class="item-not-found"><?php esc_html_e('No item found', 'felan-framework'); ?></div>
                            <?php } ?>
                        </div>
                        <a href="<?php echo esc_url(felan_get_permalink('my_jobs')) ?>" class="felan-button button-block button-outline button-rounded"><?php esc_html_e('All Applied', 'felan-framework'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
