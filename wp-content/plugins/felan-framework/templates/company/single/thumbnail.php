<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$company_id = get_the_ID();
if (!empty($company_single_id)) {
    $company_id = $company_single_id;
}
$classes = array();
$custom_company_image_size = felan_get_option('single_company_image_size');
$width = $height = '';
if (preg_match('/\d+x\d+/', $custom_company_image_size)) {
    $attach_id = get_post_thumbnail_id($company_id);
    $image_sizes = explode('x', $custom_company_image_size);
    $width         = $image_sizes[0];
    $height         = $image_sizes[1];
    $image_src      = felan_image_resize_id($attach_id, $width, $height, true);
}

$single_company_style = felan_get_option('single_company_style');
$single_company_style = !empty($_GET['layout']) ? felan_clean(wp_unslash($_GET['layout'])) : $single_company_style;
if ($single_company_style == 'large-cover-img') {
    $classes[] = 'has-large-thumbnail';
}

if (has_post_thumbnail($company_id)) : ?>
    <div class="company-thumbnail-details <?php echo implode(" ", $classes); ?>">
        <div class="container">
            <?php if ($width !== '' & $height !== '') { ?>
                <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($image_src) ?>" alt="<?php echo get_the_title($company_id); ?>" />
            <?php } else { ?>
                <?php echo get_the_post_thumbnail($company_id); ?>
            <?php } ?>
        </div>
    </div>
<?php endif; ?>