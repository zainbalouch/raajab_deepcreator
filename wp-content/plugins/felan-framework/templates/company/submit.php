<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
global $current_user, $hide_company_fields, $hide_company_group_fields;
$custom_field_company = felan_render_custom_field('company');
$felan_company_page_id = felan_get_option('felan_company_page_id', 0);
wp_enqueue_script(FELAN_PLUGIN_PREFIX . 'company-submit');
wp_enqueue_script('jquery-validate');
wp_localize_script(
	FELAN_PLUGIN_PREFIX . 'company-submit',
	'felan_submit_vars',
	array(
		'ajax_url' => FELAN_AJAX_URL,
		'not_found' => esc_html__("We didn't find any results, you can retry with other keyword.", 'felan-framework'),
		'not_company' => esc_html__('No company found', 'felan-framework'),
		'company_dashboard' => get_page_link($felan_company_page_id),
		'custom_field_company' => $custom_field_company,
	)
);
$form = 'submit-company';
$action = 'add_company';
$company_id = get_the_ID();

$hide_company_fields = felan_get_option('hide_company_fields', array());
if (!is_array($hide_company_fields)) {
	$hide_company_fields = array();
}
$hide_company_group_fields = felan_get_option('hide_company_group_fields', array());
if (!is_array($hide_company_group_fields)) {
	$hide_company_group_fields = array();
}
$layout = array('general', 'media', 'social', 'location', 'gallery', 'video');
?>

<div class="entry-my-page submit-company-dashboard">
	<form action="#" method="post" id="submit_company_form" class="form-dashboard" enctype="multipart/form-data" data-titleerror="<?php echo esc_html__('Please enter company name', 'felan-framework'); ?>" data-deserror="<?php echo esc_html__('Please enter company description', 'felan-framework'); ?>" data-caterror="<?php echo esc_html__('Please choose category', 'felan-framework'); ?>" data-sizeerror="<?php echo esc_html__('Please choose size', 'felan-framework'); ?>" data-emailerror="<?php echo esc_html__('Please choose email', 'felan-framework'); ?>">
		<div class="content-company">
			<div class="row">
				<div class="col-lg-8 col-md-7">
					<div class="submit-company-header felan-submit-header">
						<div class="entry-title">
							<h4><?php esc_html_e('Submit company', 'felan-framework') ?></h4>
						</div>
						<div class="button-warpper">
							<a href="<?php echo felan_get_permalink('company'); ?>" class="felan-button button-outline">
								<?php esc_html_e('Cancel', 'felan-framework') ?>
							</a>
							<button type="submit" class="btn-submit-company felan-button" name="submit_company">
								<span><?php esc_html_e('Publish', 'felan-framework'); ?></span>
								<span class="btn-loading"><i class="far fa-spinner fa-spin large"></i></span>
							</button>
						</div>
					</div>
					<?php foreach ($layout as $value) {
						switch ($value) {
							case 'general':
								$name = esc_html__('Basic info', 'felan-framework');
								break;
							case 'media':
								$name = esc_html__('Media', 'felan-framework');
								break;
							case 'social':
								$name = esc_html__('Social network', 'felan-framework');
								break;
							case 'location':
								$name = esc_html__('Location', 'felan-framework');
								break;
							case 'gallery':
								$name = esc_html__('Gallery', 'felan-framework');
								break;
							case 'video':
								$name = esc_html__('Video', 'felan-framework');
								break;
						}
						if (!in_array($value, $hide_company_group_fields)) : ?>
							<div class="block-from" id="<?php echo 'company-submit-' . esc_attr($value); ?>">
								<h6><?php echo $name ?></h6>
								<?php felan_get_template('company/submit/' . $value . '.php'); ?>
							</div>
					<?php endif;
					} ?>

					<?php $custom_field_company = felan_render_custom_field('company');
					if (count($custom_field_company) > 0) : ?>
						<div class="block-from" id="company-submit-additional">
							<h6><?php echo esc_html__('Additional', 'felan-framework'); ?></h6>
							<?php felan_get_template('company/submit/additional.php'); ?>
						</div>
					<?php endif; ?>

					<?php wp_nonce_field('felan_submit_company_action', 'felan_submit_company_nonce_field'); ?>

					<input type="hidden" name="company_form" value="<?php echo esc_attr($form); ?>" />
					<input type="hidden" name="company_action" value="<?php echo esc_attr($action) ?>" />
					<input type="hidden" name="company_id" value="<?php echo esc_attr($company_id); ?>" />
				</div>
				<div class="col-lg-4 col-md-5">
					<div class="widget-area-init has-sticky">
						<div class="about-company-dashboard block-archive-sidebar">
							<h3 class="title-company-about">
								<?php esc_html_e('Preview', 'felan-framework') ?></h3>
							<div class="info-company">
								<div class="img-company"><i class="far fa-camera"></i></div>
								<div class="company-right">
									<div class="title-wapper">
										<h4 class="title-about" data-title="<?php esc_attr_e('Company name', 'felan-framework') ?>"><?php esc_html_e('Company name', 'felan-framework') ?></h4>
										<?php if ((!in_array('general', $hide_company_group_fields) && !in_array('fields_company_website', $hide_company_fields))
											|| (!in_array('general', $hide_company_group_fields) && !in_array('fields_company_phone', $hide_company_fields))
											|| (!in_array('location', $hide_company_group_fields) && !in_array('fields_company_location', $hide_company_fields))
										) : ?>
											<div class="felan-check-company tip">
												<div class="tip-content">
													<h4><?php esc_html_e('Conditions for a green tick:', 'felan-framework') ?></h4>
													<ul class="list-check">
														<?php if (!in_array('general', $hide_company_group_fields) && !in_array('fields_company_website', $hide_company_fields)) : ?>
															<li class="check-webs" data-verified="<?php esc_attr_e('Website has been verified', 'felan-framework') ?>" data-not-verified="<?php esc_attr_e('Website not been verified', 'felan-framework') ?>">
																<i class="far fa-check"></i>
																<?php esc_html_e('Website not been verified', 'felan-framework') ?>
															</li>
														<?php endif; ?>
														<?php if (!in_array('general', $hide_company_group_fields) && !in_array('fields_company_phone', $hide_company_fields)) : ?>
															<li class="check-phone" data-verified="<?php esc_attr_e('Phone has been verified', 'felan-framework') ?>" data-not-verified="<?php esc_attr_e('Phone not been verified', 'felan-framework') ?>">
																<i class="far fa-check"></i>
																<?php esc_html_e('Phone not been verified', 'felan-framework') ?>
															</li>
														<?php endif; ?>
														<?php if (!in_array('location', $hide_company_group_fields) && !in_array('fields_company_location', $hide_company_fields)) : ?>
															<li class="check-location" data-verified="<?php esc_attr_e('Location has been verified', 'felan-framework') ?>" data-not-verified="<?php esc_attr_e('Location not been verified', 'felan-framework') ?>">
																<i class="far fa-check"></i>
																<?php esc_html_e('Location not been verified', 'felan-framework') ?>
															</li>
														<?php endif; ?>
													</ul>
												</div>
											</div>
										<?php endif; ?>
									</div>
									<i class="far fa-map-marker-alt"></i><span class="location-about" data-location="<?php esc_attr_e('Location', 'felan-framework') ?>"><?php esc_html_e('Location', 'felan-framework') ?></span>
								</div>
							</div>
							<div class="des-about"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>