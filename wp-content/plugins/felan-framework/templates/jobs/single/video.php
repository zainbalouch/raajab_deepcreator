<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
wp_enqueue_style('lity');
wp_enqueue_script('lity');
$jobs_id = get_the_ID();
if (!empty($job_id)) {
    $jobs_id = $job_id;
}
$jobs_meta_data = get_post_custom($jobs_id);
$jobs_video_url   = isset($jobs_meta_data[FELAN_METABOX_PREFIX . 'jobs_video_url']) ? $jobs_meta_data[FELAN_METABOX_PREFIX . 'jobs_video_url'][0] : '';
$jobs_video_image = isset($jobs_meta_data[FELAN_METABOX_PREFIX . 'jobs_video_image']) ? $jobs_meta_data[FELAN_METABOX_PREFIX . 'jobs_video_image'][0] : '';
?>
<?php if (!empty($jobs_video_url)) : ?>
    <div class="block-archive-inner jobs-video-details">
        <h4 class="title-jobs"><?php esc_html_e('Video', 'felan-framework') ?></h4>
        <div class="entry-jobs-element">
            <div class="entry-thumb-wrap">
                <?php if (wp_oembed_get($jobs_video_url)) : ?>
                    <?php
                    $image_src = felan_image_resize_id($jobs_video_image, 870, 420, true);
                    $width = '870';
                    $height = '420';
                    if (!empty($image_src)) : ?>
                        <div class="entry-thumbnail">
                            <img class="img-responsive" src="<?php echo esc_url($image_src); ?>" width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" alt="<?php the_title_attribute(); ?>" />
                            <a class="view-video" href="<?php echo esc_url($jobs_video_url); ?>" data-lity><i class="lar la-play-circle icon-large"></i></a>
                        </div>
                    <?php else : ?>
                        <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                            <?php echo wp_oembed_get($jobs_video_url, array('wmode' => 'transparent')); ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                        <?php echo wp_kses_post($jobs_video_url); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>