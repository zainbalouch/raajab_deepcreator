<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $current_user;
$user_id = $current_user->ID;
?>
<div class="jobs-fields-wrap">
    <div class="jobs-fields jobs-additional row">
        <?php
        $custom_field_jobs = felan_render_custom_field('jobs');
        if (count($custom_field_jobs) > 0) {
            foreach ($custom_field_jobs as $key => $field) {
                $field_additional_id = get_user_meta($user_id, $field['id']);
                switch ($field['type']) {
                    case 'text':
        ?>
                        <div class="form-group col-lg-6">
                            <label><?php esc_html_e($field['title']); ?></label>
                            <input type="text" id="<?php echo esc_attr($field['id']); ?>" class="form-control" name="<?php echo esc_attr($field['id']); ?>" value="<?php if (isset($field_additional_id[0])) {
                                                                                                                                                                        echo $field_additional_id[0];
                                                                                                                                                                    } ?>" placeholder="<?php esc_attr_e('Your Value', 'felan-framework'); ?>">
                        </div>
                    <?php
                        break;
                    case 'url':
                    ?>
                        <div class="form-group col-lg-6">
                            <label><?php esc_html_e($field['title']); ?></label>
                            <input type="url" id="<?php echo esc_attr($field['id']); ?>" class="form-control" name="<?php echo esc_attr($field['id']); ?>" value="<?php if (isset($field_additional_id[0])) {
                                                                                                                                                                        echo $field_additional_id[0];
                                                                                                                                                                    } ?>" placeholder="<?php esc_attr_e('Your Url', 'felan-framework'); ?>">
                        </div>
                    <?php
                        break;
                    case 'textarea':
                    ?>
                        <div class="form-group col-12">
                            <label><?php esc_html_e($field['title']); ?></label>
                            <textarea name="<?php echo esc_attr($field['id']); ?>" rows="6" id="<?php echo esc_attr($field['id']); ?>" class="form-control"><?php if (isset($field_additional_id[0])) {
                                                                                                                                                                echo $field_additional_id[0];
                                                                                                                                                            } ?></textarea>
                        </div>
                    <?php
                        break;
                    case 'select':
                    ?>
                        <div class="form-group col-lg-6">
                            <label class="d-block"><?php esc_html_e($field['title']); ?></label>
                            <div class="select2-field">
                                <select name="<?php echo esc_attr($field['id']); ?>" id="<?php echo esc_attr($field['id']); ?>" class="form-control felan-select2">
                                    <?php
                                    foreach ($field['options'] as $opt_value) : ?>
                                        <option value="<?php echo esc_attr($opt_value); ?>" <?php if (isset($field_additional_id[0]) && $field_additional_id[0] == $opt_value) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php esc_html_e($opt_value); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php
                        break;
                    case 'checkbox_list':
                    ?>
                        <div class="form-group col-lg-6">
                            <label><?php esc_html_e($field['title']); ?></label>
                            <div class="felan-field-<?php echo esc_attr($field['id']); ?>">
                                <?php
                                if (!empty($field_additional_id)) {
                                    $jobs_field = isset($field_additional_id) ? $field_additional_id[0] : '';
                                }
                                if (empty($jobs_field)) {
                                    $jobs_field = array();
                                }
                                foreach ($field['options'] as $opt_value) :
                                    if (in_array($opt_value, $jobs_field)) : ?>
                                        <div class="checkbox-inline inline"><input class="custom-checkbox" type="checkbox" name="<?php echo esc_attr($field['id']); ?>[]" value="<?php echo esc_attr($opt_value); ?>" checked><?php esc_html_e($opt_value); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="checkbox-inline inline"><input class="custom-checkbox" type="checkbox" name="<?php echo esc_attr($field['id']); ?>[]" value="<?php echo esc_attr($opt_value); ?>"><?php esc_html_e($opt_value); ?>
                                        </div>
                                <?php endif;
                                endforeach; ?>
                            </div>
                        </div>
                    <?php
                        break;
                    case 'image':
                        felan_get_custom_image_enqueue(); ?>
                        <div class="form-group col-12 felan-fields-custom_image">
                            <label><?php esc_html_e($field['title']); ?></label>
                            <div class="felan-field-<?php echo esc_attr($field['id']); ?>">
                                <div id="felan_custom_image_errors_<?php echo esc_attr($field['id']); ?>" class="errors-log"></div>
                                <div id="felan_custom_image_container_<?php echo esc_attr($field['id']); ?>" class="file-upload-block preview">
                                    <div id="felan_custom_image_view_<?php echo esc_attr($field['id']); ?>" class="custom-image-view"></div>
                                    <div id="felan_add_custom_image_<?php echo esc_attr($field['id']); ?>" class="custom-image-add">
                                        <i class="far fa-arrow-from-bottom large"></i>
                                        <p id="felan_drop_custom_image_<?php echo esc_attr($field['id']); ?>">
                                            <button type="button" id="felan_select_custom_image_<?php echo esc_attr($field['id']); ?>" class="select-custom-image"><?php esc_html_e('Click here', 'felan-framework') ?></button>
                                            <?php esc_html_e(' or drop files to upload', 'felan-framework') ?>
                                        </p>
                                    </div>
                                    <input type="hidden" class="custom_image_url" value="" id="custom_image_url_<?php echo esc_attr($field['id']); ?>">
                                    <input type="hidden" class="custom_image_id" value="" id="custom_image_id_<?php echo esc_attr($field['id']); ?>" />
                                </div>
                            </div>
                            <p class="felan-custom_image-size"><?php esc_html_e('The cover image size should be max 1920 x 400px', 'felan-framework') ?></p>
                            <input type="hidden" class="image-id" value="<?php echo esc_attr($field['id']); ?>">
                        </div>
        <?php
                        break;
//                    case 'upload':
//                        felan_get_custom_upload_enqueue();
//                        $cv_file = felan_get_option('felan-cv-type');
//                        ?>
<!--                        <div class="form-group col-12 felan-fields-custom_upload">-->
<!--                            <label>--><?php //esc_html_e($field['title']); ?><!--</label>-->
<!--                            <div class="felan-field---><?php //echo esc_attr($field['id']); ?><!--">-->
<!--                                <div id="cv_errors_log" class="errors-log"></div>-->
<!--                                <div id="felan_cv_plupload_container" class="file-upload-block preview" style="display: inline-block;">-->
<!--                                    <div class="felan_cv_file felan_add-cv">-->
<!--                                        <p id="felan_drop_cv" data-attachment-id="">-->
<!--                                            <button class="felan-button" type="button" id="felan_select_cv">-->
<!--                                                <i class="far fa-arrow-from-bottom large"></i>-->
<!--                                                <span>--><?php //esc_html_e('Browse', 'felan-framework'); ?><!--</span>-->
<!--                                            </button>-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="file-type">--><?php //echo esc_attr(sprintf(esc_html__('Upload file: %s', 'felan-framework'), $cv_file)); ?><!--</div>-->
<!--                            <input type="hidden" class="upload-id" value="--><?php //echo esc_attr($field['id']); ?><!--">-->
<!--                        </div>-->
<!--                        --><?php
//                        break;
                }
            }
        }
        ?>
    </div>
</div>