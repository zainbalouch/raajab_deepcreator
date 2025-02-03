<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
wp_enqueue_style('lity');
wp_enqueue_script('lity');
$service_id = get_the_ID();
if (!empty($service_single_id)) {
    $service_id = $service_single_id;
}
$service_meta_data = get_post_custom($service_id);

$service_video_url   = isset($service_meta_data[FELAN_METABOX_PREFIX . 'service_video_url']) ? $service_meta_data[FELAN_METABOX_PREFIX . 'service_video_url'][0] : '';
$service_video_image = isset($service_meta_data[FELAN_METABOX_PREFIX . 'service_video_image']) ? $service_meta_data[FELAN_METABOX_PREFIX . 'service_video_image'][0] : '';
?>
<?php if (!empty($service_video_url)) : ?>
    <div class="felan-block-inner block-archive-inner service-video-details">
        <h4 class="title-service"><?php esc_html_e('Video', 'felan-framework') ?></h4>
        <div class="entry-service-element">
            <div class="entry-thumb-wrap">
                <?php if (wp_oembed_get($service_video_url)) : ?>
                    <?php
                    $image_src = felan_image_resize_id($service_video_image, 870, 420, true);
                    $width = '870';
                    $height = '420';
                    if (!empty($image_src)) : ?>
                        <div class="entry-thumbnail">
                            <img class="img-responsive" src="<?php echo esc_url($image_src); ?>" width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" alt="<?php the_title_attribute(); ?>" />
                            <a class="view-video" href="<?php echo esc_url($service_video_url); ?>" data-lity><i class="far fa-play-circle icon-large"></i></a>
                        </div>
                    <?php else : ?>
                        <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                            <?php echo wp_oembed_get($service_video_url, array('wmode' => 'transparent')); ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                        <?php echo wp_kses_post($service_video_url); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>