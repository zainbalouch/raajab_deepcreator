<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
wp_enqueue_style('lity');
wp_enqueue_script('lity');
$custom_field_freelancer = felan_render_custom_field('freelancer');
$image_src = FELAN_PLUGIN_URL . 'assets/images/bg-video.webp';
if (count($custom_field_freelancer) <= 0) {
    return;
}
?>
<?php switch ($field['type']) {
    case 'text':
        if (!empty($freelancer_meta_data[$field['id']])) { ?>
            <div class="additional-warpper">
                <h4 class="title-freelancer"><?php echo $field['title']; ?></h4>
                <div class="content">
                    <?php echo sanitize_text_field($freelancer_meta_data[$field['id']][0]); ?>
                </div>
            </div>
        <?php }
        break;
    case 'url':
        if (!empty($freelancer_meta_data[$field['id']])) { ?>
            <div class="additional-warpper">
                <h4 class="title-freelancer"><?php echo $field['title']; ?></h4>
                <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                    <?php echo wp_oembed_get($freelancer_meta_data[$field['id']][0], array('wmode' => 'transparent')); ?>
                </div>
            </div>
        <?php }
        break;
    case 'textarea':
        if (!empty($freelancer_meta_data[$field['id']])) { ?>
            <div class="additional-warpper">
                <h4 class="title-freelancer"><?php echo $field['title']; ?></h4>
                <div class="content">
                    <?php echo sanitize_text_field($freelancer_meta_data[$field['id']][0]); ?>
                </div>
            </div>
        <?php }
        break;
    case 'select':
        if (!empty($freelancer_meta_data[$field['id']])) { ?>
            <div class="additional-warpper">
                <h4 class="title-freelancer"><?php echo $field['title']; ?></h4>
                <div class="content">
                    <?php echo sanitize_text_field($freelancer_meta_data[$field['id']][0]); ?>
                </div>
            </div>
        <?php }
        break;
    case 'checkbox_list':
        if (!empty($freelancer_meta_data[$field['id']])) {
        ?>
            <div class="additional-warpper">
                <h4 class="title-freelancer"><?php echo $field['title']; ?></h4>
                <div class="content">
                    <?php $freelancer_field = get_post_meta($freelancer_data->ID, $field['id'], true);
                    if (empty($freelancer_field)) {
                        $freelancer_field = array();
                    }
                    foreach ($field['options'] as $opt_value) :
                        if (in_array($opt_value, $freelancer_field)) : ?>
                            <div class="label label-skills"><?php esc_html_e($opt_value); ?></div>
                    <?php endif;
                    endforeach;
                    ?>
                </div>
            </div>
        <?php }
        break;
    case 'image':
        if (!empty($freelancer_meta_data[$field['id']])) { ?>
            <div class="additional-warpper">
                <h4 class="title-freelancer"><?php echo $field['title']; ?></h4>
                <img src="<?php echo $field['image'][$field['id']]; ?>" alt="<?php echo $field['title']; ?>" />
            </div>
<?php }
        break;
}
