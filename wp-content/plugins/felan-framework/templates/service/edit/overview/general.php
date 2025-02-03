<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $service_data, $service_meta_data, $hide_service_fields;
?>
<div class="row">
    <?php if (!in_array('fields_service_title', $hide_service_fields)) : ?>
        <div class="form-group col-md-12">
            <label for="service_title"><?php esc_html_e('Service title', 'felan-framework') ?> <sup>*</sup></label>
            <input type="text" id="service_title" name="service_title" placeholder="<?php esc_attr_e('Enter title', 'felan-framework') ?>" value="<?php print sanitize_text_field($service_data->post_title); ?>">
        </div>
    <?php endif; ?>
    <?php if (!in_array('fields_service_category', $hide_service_fields)) : ?>
        <div class="form-group col-md-6">
            <label><?php esc_html_e('Service Categories', 'felan-framework') ?> <sup>*</sup></label>
            <div class="select2-field select2-multiple">
                <select data-placeholder="<?php esc_attr_e('Select categories', 'felan-framework'); ?>" multiple="multiple" name="service_categories" class="felan-select2">
                    <?php felan_get_taxonomy_by_post_id($service_data->ID, 'service-categories', false); ?>
                </select>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!in_array('fields_service_language', $hide_service_fields)) : ?>
        <div class="form-group col-md-6">
            <label><?php esc_html_e('Languages', 'felan-framework') ?> <sup>*</sup></label>
            <div class="form-select">
                <div class="select2-field select2-multiple">
                    <select data-placeholder="<?php esc_attr_e('Select languages', 'felan-framework'); ?>" multiple="multiple" class="felan-select2" name="service_language">
                        <?php felan_get_taxonomy_by_post_id($service_data->ID, 'service-language', false); ?>
                    </select>
                </div>
                <i class="far fa-angle-down"></i>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!in_array('fields_service_description', $hide_service_fields)) : ?>
        <div class="form-group col-md-12">
            <label class="label-des-service"><?php esc_html_e('Description', 'felan-framework'); ?>
                <sup>*</sup></label>
            <?php
            $content = $service_data->post_content;
            $editor_id = 'service_des';
            $settings = array(
                'wpautop' => true,
                'media_buttons' => false,
                'textarea_name' => $editor_id,
                'textarea_rows' => get_option('default_post_edit_rows', 8),
                'tabindex' => '',
                'editor_css' => '',
                'editor_class' => '',
                'teeny' => false,
                'dfw' => false,
                'tinymce' => true,
                'quicktags' => true
            );
            wp_editor(html_entity_decode(stripcslashes($content)), $editor_id, $settings); ?>
        </div>
    <?php endif; ?>
</div>