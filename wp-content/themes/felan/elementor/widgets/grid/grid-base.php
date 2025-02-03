<?php

namespace Felan_Elementor;

use Elementor\Controls_Manager;

defined('ABSPATH') || exit;

abstract class Grid_Base extends Base
{

	abstract protected function print_grid_items(array $settings);

	public function get_icon_part()
	{
		return 'eicon-posts-grid';
	}

	protected function register_controls()
	{
		$this->add_grid_options_section();
	}

	protected function add_grid_options_section()
	{
		$this->start_controls_section('grid_options_section', [
			'label' => esc_html__('Grid Options', 'felan'),
		]);

		$this->add_responsive_control('grid_columns', [
			'label'          => esc_html__('Columns', 'felan'),
			'type'           => Controls_Manager::NUMBER,
			'min'            => 1,
			'max'            => 12,
			'step'           => 1,
			'default'        => 3,
			'tablet_default' => 2,
			'mobile_default' => 1,
			'selectors'      => [
				'{{WRAPPER}} .modern-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
			],
		]);

		$this->add_responsive_control('grid_column_gutter', [
			'label'     => esc_html__('Column Gutter', 'felan'),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'max'       => 200,
			'step'      => 1,
			'default'   => 30,
			'selectors' => [
				'{{WRAPPER}} .modern-grid' => 'grid-column-gap: {{VALUE}}px;',
			],
		]);

		$this->add_responsive_control('grid_row_gutter', [
			'label'     => esc_html__('Row Gutter', 'felan'),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'max'       => 200,
			'step'      => 1,
			'default'   => 30,
			'selectors' => [
				'{{WRAPPER}} .modern-grid' => 'grid-row-gap: {{VALUE}}px;',
			],
		]);

		$this->add_responsive_control('grid_content_position', [
			'label'                => esc_html__('Content Position', 'felan'),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''       => esc_html__('Default', 'felan'),
				'top'    => esc_html__('Top', 'felan'),
				'middle' => esc_html__('Middle', 'felan'),
				'bottom' => esc_html__('Bottom', 'felan'),
			],
			'selectors_dictionary' => [
				'top'    => 'flex-start',
				'middle' => 'center',
				'bottom' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .modern-grid .grid-item' => 'align-items: {{VALUE}}',
			],
			'render_type'          => 'template',
		]);

		$this->add_responsive_control('grid_content_alignment', [
			'label'                => esc_html__('Content Alignment', 'felan'),
			'type'                 => Controls_Manager::SELECT,
			'default'              => '',
			'options'              => [
				''       => esc_html__('Default', 'felan'),
				'left'   => esc_html__('Left', 'felan'),
				'center' => esc_html__('Center', 'felan'),
				'right'  => esc_html__('Right', 'felan'),
			],
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .modern-grid .grid-item' => 'justify-content: {{VALUE}}',
			],
			'render_type'          => 'template',
		]);

		$this->add_responsive_control('grid_content_padding', [
			'label'      => esc_html__('Item Padding', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%', 'em'],
			'selectors'  => [
				'{{WRAPPER}} .grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'separator'  => 'after',
		]);

		$this->end_controls_section();
	}

	protected function before_grid()
	{
	}

	protected function after_grid()
	{
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('grid', 'class', 'modern-grid');

		if (!empty($settings['grid_content_position']) || !empty($settings['grid_content_alignment'])) {
			$this->add_render_attribute('grid', 'class', 'flex-item');
		}

		$this->before_grid();
?>
		<div <?php $this->print_attributes_string('wrapper'); ?>>
			<div <?php $this->print_attributes_string('grid'); ?>>
				<?php $this->print_grid_items($settings); ?>
			</div>
		</div>
<?php
		$this->after_grid();
	}
}
