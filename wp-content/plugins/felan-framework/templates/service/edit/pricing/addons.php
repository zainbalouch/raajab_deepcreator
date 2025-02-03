<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $service_data, $hide_service_fields;
$service_addons = get_post_meta($service_data->ID, FELAN_METABOX_PREFIX . 'service_tab_addon', false);
$service_addons = !empty($service_addons) ? $service_addons[0] : '';
?>
<?php if (!in_array('fields_service_addons', $hide_service_fields)) : ?>
    <h6><?php esc_html_e('Service Add-ons', 'felan-framework') ?></h6>
    <div class="felan-addons-warpper">
        <div class="felan-addons-inner">
            <?php if (!empty($service_addons)) :
                foreach ($service_addons as $index => $addons) : ?>
                    <div class="felan-addons-item">
                        <div class="row">
                            <div class="group-title col-md-12">
                                <i class="delete-group fas fa-times"></i>
                                <h6 class="education">
                                    <?php echo esc_html_e('Service', 'felan-framework') ?>
                                    <span><?php echo $index + 1 ?></span>
                                </h6>
                                <i class="far fa-angle-up"></i>
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php esc_html_e('Title', 'felan-framework') ?></label>
                                <input type="text" name="service_addons_title[]" placeholder="<?php esc_attr_e('Write title here...', 'felan-framework'); ?>" value="<?php echo $addons['felan-service_addons_title'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php esc_html_e('Price', 'felan-framework') ?></label>
                                <input type="text" name="service_addons_price[]" placeholder="<?php esc_attr_e('0.00', 'felan-framework'); ?>" value="<?php echo $addons['felan-service_addons_price'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?php esc_html_e('Delivery Time', 'felan-framework') ?></label>
                                <input type="text" name="service_addons_time[]" placeholder="<?php esc_attr_e('0', 'felan-framework'); ?>" value="<?php echo $addons['felan-service_addons_time'] ?>">
                            </div>
                        </div>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
        <button type="button" class="btn-more service-fields"><i class="far fa-angle-down"></i><?php esc_html_e('Add more', 'felan-framework') ?></button>
        <template id="template-service-addons">
            <div class="felan-addons-item">
                <div class="row">
                    <div class="group-title col-md-12">
                        <i class="delete-group fas fa-times"></i>
                        <h6 class="education">
                            <?php echo esc_html_e('Service', 'felan-framework') ?>
                            <span>1</span>
                        </h6>
                        <i class="far fa-angle-up"></i>
                    </div>
                    <div class="form-group col-md-12">
                        <label><?php esc_html_e('Title', 'felan-framework') ?></label>
                        <input type="text" name="service_addons_title[]" placeholder="<?php esc_attr_e('Write title here...', 'felan-framework'); ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label><?php esc_html_e('Price', 'felan-framework') ?></label>
                        <input type="text" name="service_addons_price[]" placeholder="<?php esc_attr_e('0.00', 'felan-framework'); ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label><?php esc_html_e('Delivery Time', 'felan-framework') ?></label>
                        <input type="text" name="service_addons_time[]" placeholder="<?php esc_attr_e('0', 'felan-framework'); ?>">
                    </div>
                </div>
            </div>
        </template>
    </div>
<?php endif; ?>