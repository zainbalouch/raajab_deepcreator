<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $service_data, $service_meta_data, $hide_service_fields;
$image_max_file_size = felan_get_option('felan_image_max_file_size', '1000kb');
felan_get_gallery_enqueue();
?>
<?php if (!in_array('fields_closing_gallery', $hide_service_fields)) : ?>
    <div class="service-fields-media felan-fields-gallery">
        <label><?php esc_html_e('Image', 'felan-framework'); ?></label>
        <div class="service-fields service-fields-file service-gallery-image">
            <div class="field-media-warpper">
                <div class="media-gallery">
                    <div id="felan_gallery_thumbs">
                        <?php
                        $service_img_arg = get_post_meta($service_data->ID, FELAN_METABOX_PREFIX . 'service_images', false);
                        $service_images  = (isset($service_img_arg) && is_array($service_img_arg) && count($service_img_arg) > 0) ? $service_img_arg[0] : '';
                        $service_images  = explode('|', $service_images);
                        $service_images  = array_unique($service_images);
                        if (!empty($service_images[0])) {
                            foreach ($service_images as $attach_id) {
                                echo '<div class="media-thumb-wrap">';
                                echo '<figure class="media-thumb">';
                                echo wp_get_attachment_image($attach_id, 'thumbnail');
                                echo '<div class="media-item-actions">';
                                echo '<a class="icon icon-gallery-delete" data-attachment-id="' . intval($attach_id) . '" href="javascript:void(0)">';
                                echo '<i class="far fa-trash-alt large"></i>';
                                echo '</a>';
                                echo '</a>';
                                echo '<input type="hidden" class="felan_gallery_ids" name="felan_gallery_ids[]" value="' . intval($attach_id) . '">';
                                echo '<span style="display: none;" class="icon icon-loader">';
                                echo '<i class="far fa-spinner fa-spin large"></i>';
                                echo '</span>';
                                echo '</div>';
                                echo '</figure>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div id="felan_gallery_errors" class="errors-log"></div>
                <div class="felan-gallery-warpper">
                    <div class="felan-gallery-inner">
                        <div id="felan_gallery_container">
                            <button type="button" id="felan_select_gallery" class="btn btn-primary">
                                <i class="far fa-arrow-from-bottom large"></i>
                                <?php esc_html_e('Upload ', 'felan-framework'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="field-note"><?php echo sprintf(__('Maximum file size: %s.', 'felan-framework'), $image_max_file_size); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>