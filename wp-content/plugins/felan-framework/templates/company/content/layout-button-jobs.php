<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $wpdb;

$id = get_the_ID();
if (!empty($company_id)) {
    $id = $company_id;
}
$company_meta_data = get_post_custom($id);
$company_location = get_the_terms($company_id, 'company-location');
$company_categories =  get_the_terms($company_id, 'company-categories');
$company_size =  get_the_terms($company_id,  'company-size');
$company_logo   = get_post_meta($company_id, FELAN_METABOX_PREFIX . 'company_logo');
$company_item_class[] = 'felan-company-item';
if (!empty($layout)) {
    $company_item_class[] = $layout;
}
$company_item_class[] = 'company-' . $id;
$meta_query = felan_posts_company($id);
?>
<div class="<?php echo join(' ', $company_item_class); ?>">
    <div class="company-top">
        <a class="company-img" href="<?php echo get_the_permalink($company_id); ?>">
            <?php if (!empty($company_logo[0]['url'])) : ?>
                <img class="logo-company" src="<?php echo $company_logo[0]['url'] ?>" alt="" />
            <?php else : ?>
                <div class="logo-company"><i class="far fa-camera"></i></div>
            <?php endif; ?>
        </a>
        <?php if (!empty(get_the_title($company_id))) : ?>
            <h2 class="company-title">
                <a href="<?php echo get_the_permalink($company_id); ?>"><?php echo get_the_title($company_id); ?></a>
            </h2>
            <?php felan_company_green_tick($company_id); ?>
        <?php endif; ?>
        <div class="company-inner">
            <?php if (is_array($company_location)) { ?>
                <div class="company-location">
                    <?php foreach ($company_location as $location) {
                        $location_link = get_term_link($location, 'company-size'); ?>
                        <a href="<?php echo esc_url($location_link); ?>" class="cate felan-link-bottom">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5599 20.8207C12.2247 21.0598 11.7753 21.0598 11.4401 20.8207C6.61138 17.3773 1.48557 10.2971 6.6667 5.18128C8.08118 3.78463 9.99963 3 12 3C14.0004 3 15.9188 3.78463 17.3333 5.18128C22.5144 10.2971 17.3886 17.3773 12.5599 20.8207Z" stroke="#111111" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z" stroke="#111111" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <?php esc_html_e($location->name); ?>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php echo felan_get_total_rating('company', $company_id); ?>
        </div>
    </div>
    <?php if (!empty(get_the_content($company_id))) : ?>
        <div class="des-company">
            <?php echo wp_trim_words(get_the_content($company_id), 8); ?>
        </div>
    <?php endif; ?>
    <?php if ($meta_query->post_count > 0) : ?>
        <div class="company-available">
            <span><?php echo $meta_query->post_count; ?></span> <?php esc_html_e('jobs available', 'felan-framework') ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($company_id)) { ?>
        <a class="felan-button button-outline-accent" href="<?php echo esc_url(get_post_type_archive_link('jobs')) . '/?company_id=' . $company_id ?>">
            <span><?php esc_html_e('View jobs', 'felan-framework') ?></span>
        </a>
    <?php } ?>
</div>