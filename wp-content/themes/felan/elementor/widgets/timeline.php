<?php

namespace Felan_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

defined('ABSPATH') || exit;

//@todo Not compatible with WPML.

class Widget_Timeline extends Base
{

	public function get_name()
	{
		return 'felan-timeline';
	}

	public function get_title()
	{
		return esc_html__('Timeline', 'felan');
	}

	public function get_icon_part()
	{
		return 'eicon-time-line';
	}

	public function get_keywords()
	{
		return ['timeline'];
	}

	public function get_style_depends()
	{
		return ['felan-el-widget-timeline'];
	}

	protected function register_controls()
	{
		$this->start_controls_section('layout_section', [
			'label' => esc_html__('Layout', 'felan'),
		]);

		$repeater = new Repeater();

		$repeater->add_control('image', [
			'label'   => esc_html__('Image', 'felan'),
			'type'    => Controls_Manager::MEDIA,
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		]);

		$repeater->add_control('date', [
			'label' => esc_html__('Date', 'felan'),
			'type'  => Controls_Manager::DATE_TIME,
		]);

		$repeater->add_control('title', [
			'label'       => esc_html__('Title', 'felan'),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__('Title', 'felan'),
			'label_block' => true,
		]);

		$repeater->add_control('description', [
			'label' => esc_html__('Description', 'felan'),
			'type'  => Controls_Manager::WYSIWYG,
		]);

		$this->add_control('items', [
			'label'       => esc_html__('Items', 'felan'),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'title'       => esc_html__('Step #1', 'felan'),
					'description' => esc_html__('Suspe ndisse suscipit sagittis leo sit met condimentum estibulum issim Lorem ipsum dolor sit amet, consectetur cium', 'felan'),
				],
				[
					'title'       => esc_html__('Step #2', 'felan'),
					'description' => esc_html__('Suspe ndisse suscipit sagittis leo sit met condimentum estibulum issim Lorem ipsum dolor sit amet, consectetur cium', 'felan'),
				],
				[
					'title'       => esc_html__('Step #3', 'felan'),
					'description' => esc_html__('Suspe ndisse suscipit sagittis leo sit met condimentum estibulum issim Lorem ipsum dolor sit amet, consectetur cium', 'felan'),
				],
				[
					'title'       => esc_html__('Step #4', 'felan'),
					'description' => esc_html__('Suspe ndisse suscipit sagittis leo sit met condimentum estibulum issim Lorem ipsum dolor sit amet, consectetur cium', 'felan'),
				],
			],
			'title_field' => '{{{ title }}}',
		]);

		$this->add_group_control(Group_Control_Image_Size::get_type(), [
			'name'      => 'image',
			'default'   => 'full',
			'separator' => 'none',
		]);

		$this->end_controls_section();

		$this->add_styling_section();
	}

	private function add_styling_section()
	{
		$this->start_controls_section('styling_section', [
			'label' => esc_html__('Styling', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control('title_heading', [
			'label'     => esc_html__('Title', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__('Typography', 'felan'),
			'selector' => '{{WRAPPER}} .title',
		]);

		$this->add_control('title_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .title' => 'color: {{VALUE}};',
			],
		]);

		$this->add_control('description_heading', [
			'label'     => esc_html__('Description', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'description_typography',
			'label'    => esc_html__('Typography', 'felan'),
			'selector' => '{{WRAPPER}} .description',
		]);

		$this->add_control('description_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .description' => 'color: {{VALUE}};',
			],
		]);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('wrapper', 'class', 'felan-timeline style-01');
?>
		<div <?php $this->print_attributes_string('wrapper'); ?>>
			<div class="timeline-line"></div>
			<?php if ($settings['items'] && count($settings['items']) > 0) { ?>
				<div class="timeline-list felan-entrance-animation-queue">
					<?php foreach ($settings['items'] as $key => $item) { ?>
						<div class="timeline-item item">
							<div class="timeline-dot"></div>

							<div class="content-wrap">
								<div class="content-header">
									<div class="content-inner">
										<?php if (!empty($item['title'])) : ?>
											<h5 class="title"><?php echo esc_html($item['title']); ?></h5>
										<?php endif; ?>

										<div class="felan-image image">
											<?php echo \Felan_Image::get_elementor_attachment([
												'settings'      => $item,
												'size_settings' => $settings,
											]); ?>
										</div>
									</div>
								</div>

								<div class="content-main">
									<div class="content-inner">
										<?php if (!empty($item['date'])) : ?>
											<?php
											$month = mysql2date('M', $item['date']);
											$year  = mysql2date('Y', $item['date']);
											?>
											<div class="timeline-date">
												<div class="timeline-date--month"><?php echo esc_html($month); ?></div>
												<div class="timeline-date--year"><?php echo esc_html($year); ?></div>
											</div>
										<?php endif; ?>

										<?php if (isset($item['description'])) : ?>
											<div class="description">
												<?php echo '' . $this->parse_text_editor($item['description']); ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
<?php
	}
}
