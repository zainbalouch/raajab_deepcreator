<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$freelancer_details_prints = felan_get_option('freelancer_details_prints');
foreach ($freelancer_details_prints as $print) {
    if (!in_array('enable_print_sp_experience', $freelancer_details_prints)) {
        return;
    }
}

$freelancer_experiences = get_post_meta($freelancer_id, FELAN_METABOX_PREFIX . 'freelancer_experience_list', false);
$freelancer_experiences = !empty($freelancer_experiences) ? $freelancer_experiences[0] : '';
if (empty($freelancer_experiences[0][FELAN_METABOX_PREFIX . 'freelancer_experience_job'])) {
    return;
}
?>
<div class="block-archive-inner freelancer-single-field">
    <h4 class="title-freelancer"><?php esc_html_e('Work Experience', 'felan-framework') ?></h4>
    <?php foreach ($freelancer_experiences as $experience) : ?>
        <?php if (!empty($experience[FELAN_METABOX_PREFIX . 'freelancer_experience_job'])) : ?>
            <div class="single freelancer-experience">
                <?php if (!empty($experience[FELAN_METABOX_PREFIX . 'freelancer_experience_job'])) : ?>
                    <div class="experience-title time-dot">
                        <?php echo $experience[FELAN_METABOX_PREFIX . 'freelancer_experience_job']; ?>
                    </div>
                <?php endif; ?>
                <div class="experience-details time-line">
                    <?php if (!empty($experience[FELAN_METABOX_PREFIX . 'freelancer_experience_company'])) : ?>
                        <span><?php echo $experience[FELAN_METABOX_PREFIX . 'freelancer_experience_company']; ?></span>
                    <?php endif; ?>
                    <?php if (!empty($experience[FELAN_METABOX_PREFIX . 'freelancer_experience_from'])) : ?>
                        <span><?php echo $experience[FELAN_METABOX_PREFIX . 'freelancer_experience_from']; ?></span>
                    <?php endif; ?>
                    <span>-</span>
                    <?php if (!empty($experience[FELAN_METABOX_PREFIX . 'freelancer_experience_to'])) : ?>
                        <span><?php echo $experience[FELAN_METABOX_PREFIX . 'freelancer_experience_to']; ?></span>
                    <?php endif; ?>
                    <?php if (!empty($experience[FELAN_METABOX_PREFIX . 'freelancer_experience_description'])) : ?>
                        <span><?php echo $experience[FELAN_METABOX_PREFIX . 'freelancer_experience_description']; ?></span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php
    $custom_field_freelancer = felan_render_custom_field('freelancer');
    $freelancer_meta_data = get_post_custom($freelancer_id);
    $freelancer_data = get_post($freelancer_id);
    $check_tabs = false;
    foreach ($custom_field_freelancer as $field) {
        if ($field['tabs'] == 'experience') {
            $check_tabs = true;
        }
    }

    if (count($custom_field_freelancer) > 0) {
        if ($check_tabs == true) : ?>
            <?php foreach ($custom_field_freelancer as $field) {
                if ($field['tabs'] == 'experience') { ?>
            <?php felan_get_template("freelancer/print/additional/field.php", array(
                        'field' => $field,
                        'freelancer_data' => $freelancer_data,
                        'freelancer_meta_data' => $freelancer_meta_data
                    ));
                }
            } ?>
    <?php endif;
    }
    ?>
</div>