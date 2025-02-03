<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$cover_id = get_post_meta($freelancer_id, FELAN_METABOX_PREFIX . 'freelancer_cover_image_id', true);

$image_src = wp_get_attachment_image_url($cover_id, 'full');

if (empty($image_src)) {
    return;
}

?>

<div class="cover-wrapper">
    <div class="cover">
        <img src="<?php echo esc_url($image_src) ?>" alt="">
    </div>
</div>