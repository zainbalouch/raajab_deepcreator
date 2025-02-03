<?php

namespace Felan_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

defined('ABSPATH') || exit;

class Widget_Number_Box extends Base
{

	public function get_name()
	{
		return 'felan-number-box';
	}

	public function get_title()
	{
		return esc_html__('Modern Number Box', 'felan');
	}

	public function get_icon_part()
	{
		return 'eicon-number-field';
	}

	public function get_keywords()
	{
		return ['number', 'box'];
	}

	public function get_style_depends()
	{
		return ['felan-el-widget-number-box'];
	}

	protected function register_controls()
	{
		$this->add_number_box_section();
		$this->add_number_style_section();
		$this->add_heading_style_section();
		$this->add_desc_style_section();
		$this->add_icon_style_section();
	}

	private function add_number_box_section()
	{
		$this->start_controls_section('icon_box_section', [
			'label' => esc_html__('Number Box', 'felan'),
		]);

		$this->add_control('style', [
			'label'        => esc_html__('Style', 'felan'),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'01' => esc_html__('01', 'felan'),
			],
			'default'      => '01',
			'prefix_class' => 'felan-number-box-style-',
		]);

		$this->add_control('number', [
			'label'       => esc_html__('Number', 'felan'),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__('1', 'felan'),
		]);

		$this->add_control('title_text', [
			'label'       => esc_html__('Title', 'felan'),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => esc_html__('This is the heading', 'felan'),
			'placeholder' => esc_html__('Enter your title', 'felan'),
			'label_block' => true,
		]);

		$this->add_control('title_size', [
			'label'   => esc_html__('HTML Tag', 'felan'),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'h1'   => 'H1',
				'h2'   => 'H2',
				'h3'   => 'H3',
				'h4'   => 'H4',
				'h5'   => 'H5',
				'h6'   => 'H6',
				'div'  => 'div',
				'span' => 'span',
				'p'    => 'p',
			],
			'default' => 'h3',
		]);

		$this->add_control('description', [
			'label'       => esc_html__('Description', 'felan'),
			'type'        => Controls_Manager::TEXTAREA,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis.', 'felan'),
			'placeholder' => esc_html__('Enter your description', 'felan'),
			'rows'        => 10,
			'separator'   => 'none',
		]);

		$this->add_control('enable_icon', [
			'label' => esc_html__('Enable Icon', 'felan'),
			'type'  => Controls_Manager::SWITCHER,
		]);

		$this->add_control('icon', [
			'label'      => esc_html__('Icon', 'felan'),
			'show_label' => false,
			'type'       => Controls_Manager::ICONS,
			'default'    => [
				'value'   => 'fal fa-arrow-right',
				'library' => 'fa-solid',
			],
			'condition'    => [
				'enable_icon' => 'yes',
			],
		]);

		$this->end_controls_section();
	}

	private function add_number_style_section()
	{
		$this->start_controls_section('number_style_section', [
			'label'     => esc_html__('Number', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'number_typo',
			'selector' => '{{WRAPPER}} .number',
            'global' => ['default' =>  Global_Typography::TYPOGRAPHY_PRIMARY],
		]);

		$this->add_control('number_background_color', [
			'label'     => esc_html__('Background Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .number' => 'background-color: {{VALUE}};',
			],
		]);
		$this->add_control('number_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .number' => 'color: {{VALUE}};',
			],
		]);

		$this->add_responsive_control('number_width', [
			'label'     => esc_html__('Width', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 20,
					'max' => 200,
				],
			],
			'default' => [
				'size' => 80,
			],
			'selectors' => [
				'{{WRAPPER}} .number' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();
	}

	private function add_heading_style_section()
	{
		$this->start_controls_section('heading_style_section', [
			'label'     => esc_html__('Heading', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'title',
			'selector' => '{{WRAPPER}} .title',
            'global' => ['default' =>  Global_Typography::TYPOGRAPHY_PRIMARY],
		]);

		$this->add_responsive_control('title_spacing', [
			'label'      => esc_html__('Spacing', 'felan'),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => ['px', '%', 'em'],
			'range'      => [
				'%'  => [
					'min' => 0,
					'max' => 100,
				],
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
			'separator'  => 'before',
		]);

		$this->end_controls_section();
	}

	private function add_desc_style_section()
	{
		$this->start_controls_section('desc_style_section', [
			'label'     => esc_html__('Desc', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'description_typo',
			'selector' => '{{WRAPPER}} .description',
            'global' => ['default' =>  Global_Typography::TYPOGRAPHY_PRIMARY],
		]);

		$this->end_controls_section();
	}

	private function add_icon_style_section()
	{
		$this->start_controls_section('icon_style_section', [
			'label'     => esc_html__('Icon', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'enable_icon' => 'yes',
			],
		]);

		$this->add_control('icon_background_color', [
			'label'     => esc_html__('Background Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .icon' => 'background-color: {{VALUE}};',
			],
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'icon',
			'selector' => '{{WRAPPER}} .icon',
		]);

		$this->add_responsive_control('icon_size', [
			'label'     => esc_html__('Size', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 6,
					'max' => 300,
				],
			],
			'default' => [
				'size' => 20,
			],
			'selectors' => [
				'{{WRAPPER}} .felan-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('icon_padding', [
			'label'     => esc_html__('Padding', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .felan-icon' => 'padding: {{SIZE}}{{UNIT}};',
			],
			'range'     => [
				'em' => [
					'min' => 0,
					'max' => 5,
				],
			],
		]);

		$this->add_control('icon_border_radius', [
			'label'      => esc_html__('Border Radius', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'selectors'  => [
				'{{WRAPPER}} .felan-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$style = $settings['style'];
		$number = $settings['number'];
		$title_text = $settings['title_text'];
		$title_size = $settings['title_size'];
		$description = $settings['description'];
		$enable_icon = $settings['enable_icon'];
?>
		<div class="number-box">
			<div class="inner">
				<?php if ($number) : ?>
					<div class="number"><?php echo esc_html($number); ?></div>
				<?php endif; ?>
				<?php if ($title_text && $title_size) : ?>
					<<?php echo esc_html($title_size); ?> class="title"><?php echo esc_html($title_text); ?></<?php echo esc_html($title_size); ?>>
				<?php endif; ?>
				<?php if ($description) : ?>
					<div class="description"><?php echo wp_kses_post($description); ?></div>
				<?php endif; ?>
				<?php if ($enable_icon) : ?>
					<?php $this->print_icon($settings); ?>
				<?php endif; ?>
			</div>
		</div>
	<?php
	}

	private function print_icon(array $settings)
	{
		$this->add_render_attribute('icon', 'class', [
			'felan-icon',
			'icon',
		]);

		$is_svg = isset($settings['icon']['library']) && 'svg' === $settings['icon']['library'] ? true : false;

		if ($is_svg) {
			$this->add_render_attribute('icon', 'class', [
				'felan-svg-icon',
			]);
		}

		if ('gradient' === $settings['icon_color_type']) {
			$this->add_render_attribute('icon', 'class', [
				'felan-gradient-icon',
			]);
		} else {
			$this->add_render_attribute('icon', 'class', [
				'felan-solid-icon',
			]);
		}
	?>
		<div <?php $this->print_attributes_string('icon'); ?>>
			<?php $this->render_icon($settings, $settings['icon'], ['aria-hidden' => 'true'], $is_svg, 'icon'); ?>
		</div>
<?php
	}
}
