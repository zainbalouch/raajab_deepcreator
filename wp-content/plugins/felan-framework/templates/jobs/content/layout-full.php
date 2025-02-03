<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $wpdb;

$id = get_the_ID();
if (!empty($jobs_id)) {
    $id = $jobs_id;
}
$jobs_meta_data = get_post_custom($id);

$jobs_type = get_the_terms($jobs_id, 'jobs-type');
$jobs_location = get_the_terms($jobs_id, 'jobs-location');
$jobs_categories = get_the_terms($jobs_id, 'jobs-categories');
$jobs_select_company = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_select_company');
$company_id = isset($jobs_select_company[0]) ? $jobs_select_company[0] : '';
$company_logo = get_post_meta($company_id, FELAN_METABOX_PREFIX . 'company_logo');
$jobs_salary_active   = felan_get_option('enable_single_jobs_salary', '1');
$jobs_salary_show = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_show', true);
$jobs_salary_rate = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_rate', true);
$jobs_salary_minimum = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_minimum', true);
$jobs_salary_maximum = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_maximum', true);
$jobs_maximum_price = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_maximum_price', true);
$jobs_minimum_price = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_minimum_price', true);
$jobs_currency_type = get_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_currency_type', true);

$jobs_item_class[] = 'felan-jobs-item';
if (!empty($layout) && $layout == 'layout-full') {
    $jobs_item_class[] = 'layout-list';
} else {
    $jobs_item_class[] = $layout;
}
if (felan_get_expiration_apply($jobs_id) !== 0) {
    $jobs_featured = isset($jobs_meta_data[FELAN_METABOX_PREFIX . 'jobs_featured']) ? $jobs_meta_data[FELAN_METABOX_PREFIX . 'jobs_featured'][0] : '0';
    if ($jobs_featured == '1') {
        $jobs_item_class[] = 'felan-jobs-featured';
    } else {
        $enable_status_urgent = felan_get_option('enable_status_urgent', '1');
        $number_status_urgent = felan_get_option('number_status_urgent', '3');
        if ($number_status_urgent > felan_get_expiration_apply($jobs_id) && $enable_status_urgent == '1' && $number_status_urgent !== '') {
            $jobs_item_class[] = 'felan-jobs-urgent';
        }
    }
}
$jobs_item_class[] = 'jobs-' . $id;
$enable_jobs_des = felan_get_option('enable_jobs_show_des');
?>
<div class="<?php echo join(' ', $jobs_item_class); ?>" data-jobid="<?php echo esc_attr($id); ?>">
    <div class="jobs-archive-header">
        <div class="jobs-header-left">
            <?php if (!empty($company_logo[0]['url'])) : ?>
                <img class="logo-company" src="<?php echo $company_logo[0]['url'] ?>" alt="" />
            <?php endif; ?>
            <div class="jobs-left-inner">
                <div class="info-company">
                    <?php if (!empty($company_id)) : ?>
                        <a class="authour" href="<?php echo get_post_permalink($company_id) ?>"><?php echo get_the_title($company_id); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="jobs-header-right">
            <span class="jobs-status"><?php echo felan_get_icon_status($jobs_id); ?></span>
            <?php felan_get_template('jobs/wishlist.php', array(
                'jobs_id' => $jobs_id,
            )); ?>
        </div>
    </div>
    <?php if (!empty(get_the_title($jobs_id))) : ?>
        <h3 class="jobs-title"><a href="<?php echo get_post_permalink($jobs_id) ?>"><?php echo get_the_title($jobs_id) ?></a>
        </h3>
    <?php endif; ?>
    <?php if (!empty(get_the_content($jobs_id)) && $enable_jobs_des) : ?>
        <div class="jobs-des">
            <?php echo wp_trim_words(get_post_field('post_content', $jobs_id), 25); ?>
        </div>
    <?php endif; ?>
    <div class="jobs-archive-footer">
        <div class="jobs-footer-left">
            <?php if (is_array($jobs_type)) {
                foreach ($jobs_type as $type) {
                    $type_link = get_term_link($type, 'jobs-type');
            ?>
                    <a class="label label-type" href="<?php echo esc_url($type_link); ?>">
                        <?php esc_html_e($type->name); ?>
                    </a>
            <?php }
            } ?>
            <?php if (is_array($jobs_location)) {
                foreach ($jobs_location as $location) {
                    $location_link = get_term_link($location, 'jobs-location');
            ?>
                    <a class="label label-location" href="<?php echo esc_url($location_link); ?>">
                        <i class="far fa-map-marker-alt"></i><?php esc_html_e($location->name); ?>
                    </a>
            <?php }
            } ?>
            <?php if (($jobs_salary_active && $jobs_salary_show == 'range' && $jobs_salary_minimum !== '' && $jobs_salary_maximum !== '')
                || ($jobs_salary_active && $jobs_salary_show == 'starting_amount' && $jobs_minimum_price !== '')
                || ($jobs_salary_active && $jobs_salary_show == 'maximum_amount' && $jobs_maximum_price !== '') || ($jobs_salary_active && $jobs_salary_show == 'agree')
            ) : ?>
                <div class="label label-price">
                    <?php echo felan_get_salary_jobs($jobs_id); ?>
                </div>
            <?php endif; ?>
            <?php
            do_action('felan/jobs/layout_full/jobs_footerleft/after');
            ?>
        </div>
        <div class="jobs-footer-right">
            <p class="days">
                <span> <?php echo felan_get_expiration_apply($jobs_id); ?> </span><?php esc_html_e('days left', 'felan-framework') ?>
            </p>
        </div>
    </div>
</div>