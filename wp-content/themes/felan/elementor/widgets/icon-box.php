<?php

namespace Felan_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

defined('ABSPATH') || exit;

class Widget_Icon_Box extends Base
{

	public function get_name()
	{
		return 'felan-icon-box';
	}

	public function get_title()
	{
		return esc_html__('Modern Icon Box', 'felan');
	}

	public function get_icon_part()
	{
		return 'eicon-icon-box';
	}

	public function get_keywords()
	{
		return ['icon box', 'box icon', 'icon', 'box'];
	}

	public function get_script_depends()
	{
		return ['felan-widget-icon-box'];
	}

	public function get_style_depends()
	{
		return ['felan-el-widget-icon-box', 'felan-el-widget-icon'];
	}

	protected function register_controls()
	{
		$this->add_icon_box_section();

		$this->add_icon_svg_animate_section();

		$this->add_box_style_section();

		$this->add_icon_style_section();

		$this->add_title_style_section();

		$this->add_title_divider_style();

		$this->add_description_style_section();

		$this->register_common_button_style_section();
	}

	private function add_icon_box_section()
	{
		$this->start_controls_section('icon_box_section', [
			'label' => esc_html__('Icon Box', 'felan'),
		]);

		$this->add_control('style', [
			'label'        => esc_html__('Style', 'felan'),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				''   => esc_html__('None', 'felan'),
				'01' => esc_html__('01', 'felan'),
				'02' => esc_html__('02', 'felan'),
				'03' => esc_html__('03', 'felan'),
			],
			'default'      => '',
			'prefix_class' => 'felan-icon-box-style-',
		]);

		$this->add_control('link', [
			'label'       => esc_html__('Link', 'felan'),
			'type'        => Controls_Manager::URL,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => esc_html__('https://your-link.com', 'felan'),
			'separator'   => 'before',
		]);

		$this->add_control('link_click', [
			'label'     => esc_html__('Apply Link On', 'felan'),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				'box'    => esc_html__('Whole Box', 'felan'),
				'button' => esc_html__('Button Only', 'felan'),
			],
			'default'   => 'box',
			'condition' => [
				'link[url]!' => '',
			],
		]);

		$this->add_content_icon_section();

		$this->add_content_title_section();

		$this->add_content_description_section();

		$this->add_group_control(Group_Control_Button::get_type(), [
			'name'           => 'button',
			// Use box link instead of.
			'exclude'        => [
				'link',
			],
			// Change button style text as default.
			'fields_options' => [
				'style' => [
					'default' => 'text',
				],
			],
		]);

		$this->end_controls_section();
	}

	private function add_content_icon_section()
	{
		$this->add_control('icon_heading', [
			'label'     => esc_html__('Icon', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_control('icon', [
			'label'      => esc_html__('Icon', 'felan'),
			'show_label' => false,
			'type'       => Controls_Manager::ICONS,
			'default'    => [
				'value'   => 'fas fa-star',
				'library' => 'fa-solid',
			],
		]);

		$this->add_control('view', [
			'label'        => esc_html__('View', 'felan'),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'default' => esc_html__('Default', 'felan'),
				'stacked' => esc_html__('Stacked', 'felan'),
				'bubble'  => esc_html__('Bubble', 'felan'),
			],
			'default'      => 'default',
			'prefix_class' => 'felan-view-',
			'condition'    => [
				'icon[value]!' => '',
			],
		]);

		$this->add_control('shape', [
			'label'        => esc_html__('Shape', 'felan'),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				'circle' => esc_html__('Circle', 'felan'),
				'square' => esc_html__('Square', 'felan'),
			],
			'default'      => 'circle',
			'condition'    => [
				'view!'        => 'default',
				'icon[value]!' => '',
			],
			'prefix_class' => 'felan-shape-',
		]);

		$this->add_control('position', [
			'label'        => esc_html__('Position', 'felan'),
			'type'         => Controls_Manager::CHOOSE,
			'default'      => 'top',
			'options'      => [
				'left'  => [
					'title' => esc_html__('Left', 'felan'),
					'icon'  => 'eicon-h-align-left',
				],
				'top'   => [
					'title' => esc_html__('Top', 'felan'),
					'icon'  => 'eicon-v-align-top',
				],
				'right' => [
					'title' => esc_html__('Right', 'felan'),
					'icon'  => 'eicon-h-align-right',
				],
			],
			'prefix_class' => 'elementor-position-',
			'toggle'       => false,
			'condition'    => [
				'icon[value]!' => '',
			],
		]);

		$this->add_control('content_vertical_alignment', [
			'label'        => esc_html__('Vertical Alignment', 'felan'),
			'type'         => Controls_Manager::CHOOSE,
			'options'      => Widget_Utils::get_control_options_vertical_alignment(),
			'default'      => 'top',
			'prefix_class' => 'elementor-vertical-align-',
			'condition'    => [
				'icon[value]!' => '',
				'position!'    => 'top',
			],
		]);
	}

	private function add_content_title_section()
	{
		$this->add_control('title_heading', [
			'label'     => esc_html__('Title', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_control('title_text', [
			'label'       => esc_html__('Text', 'felan'),
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

		// Divider.
		$this->add_control('title_divider_enable', [
			'label' => esc_html__('Display Divider', 'felan'),
			'type'  => Controls_Manager::SWITCHER,
		]);
	}

	private function add_content_description_section()
	{
		$this->add_control('description_heading', [
			'label'     => esc_html__('Description', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_control('description_text', [
			'label'       => esc_html__('Text', 'felan'),
			'type'        => Controls_Manager::TEXTAREA,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis.', 'felan'),
			'placeholder' => esc_html__('Enter your description', 'felan'),
			'rows'        => 10,
			'separator'   => 'none',
		]);
	}

	private function add_icon_svg_animate_section()
	{
		$this->start_controls_section('icon_svg_animate_section', [
			'label'     => esc_html__('Icon SVG Animate', 'felan'),
			'condition' => [
				'icon[library]' => 'svg',
			],
		]);

		$this->add_control('icon_svg_animate_alert', [
			'type'            => Controls_Manager::RAW_HTML,
			'content_classes' => 'elementor-control-field-description',
			'raw'             => esc_html__('Note: Animate works only with Stroke SVG Icon.', 'felan'),
			'separator'       => 'after',
		]);

		$this->add_control('icon_svg_animate', [
			'label' => esc_html__('SVG Animate', 'felan'),
			'type'  => Controls_Manager::SWITCHER,
		]);

		$this->add_control('icon_svg_animate_play_on_hover', [
			'label' => esc_html__('Play on hover', 'felan'),
			'type'  => Controls_Manager::SWITCHER,
		]);

		$this->add_control('icon_svg_animate_type', [
			'label'   => esc_html__('Type', 'felan'),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'delayed'  => esc_html__('Delayed', 'felan'),
				'sync'     => esc_html__('Sync', 'felan'),
				'oneByOne' => esc_html__('One By One', 'felan'),
			],
			'default' => 'delayed',
		]);

		$this->add_control('icon_svg_animate_duration', [
			'label'   => esc_html__('Transition Duration', 'felan'),
			'type'    => Controls_Manager::NUMBER,
			'default' => 120,
		]);

		$this->end_controls_section();
	}

	private function add_box_style_section()
	{
		$this->start_controls_section('box_style_section', [
			'label' => esc_html__('Box', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control('text_align', [
			'label'     => esc_html__('Alignment', 'felan'),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => Widget_Utils::get_control_options_text_align_full(),
			'selectors' => [
				'{{WRAPPER}} .icon-box-wrapper' => 'text-align: {{VALUE}};',
			],
		]);

		$this->add_responsive_control('box_padding', [
			'label'      => esc_html__('Padding', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%', 'em'],
			'selectors'  => [
				'{{WRAPPER}} .felan-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('box_max_width', [
			'label'      => esc_html__('Max Width', 'felan'),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => ['px', '%'],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .felan-icon-box' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('box_horizontal_alignment', [
			'label'                => esc_html__('Horizontal Alignment', 'felan'),
			'label_block'          => true,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_horizontal_alignment(),
			'default'              => 'center',
			'toggle'               => false,
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: flex; justify-content: {{VALUE}}',
			],
		]);

		$this->start_controls_tabs('box_colors');

		$this->start_controls_tab('box_colors_normal', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .felan-icon-box',
		]);

		$this->add_group_control(Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .felan-icon-box',
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .felan-icon-box',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('box_colors_hover', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .felan-icon-box:before',
		]);

		$this->add_group_control(Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_hover_border',
			'selector' => '{{WRAPPER}} .felan-icon-box:hover',
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .felan-icon-box:hover',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control('box_line_heading', [
			'label'     => esc_html__('Special Line', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => ['02'],
			],
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'      => 'box_line',
			'selector'  => '{{WRAPPER}}.felan-icon-box-style-02 .felan-icon-box:after',
			'condition' => [
				'style' => ['02'],
			],
		]);

		$this->end_controls_section();
	}

	private function add_icon_style_section()
	{
		$this->start_controls_section('icon_style_section', [
			'label'     => esc_html__('Icon', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'icon[value]!' => '',
			],
		]);

		$this->add_responsive_control('icon_wrap_height', [
			'label'     => esc_html__('Wrap Height', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 6,
					'max' => 300,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .felan-icon-wrap' => 'height: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->start_controls_tabs('icon_colors');

		$this->start_controls_tab('icon_colors_normal', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'icon',
			'selector' => '{{WRAPPER}} .icon',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('icon_colors_hover', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'hover_icon',
			'selector' => '{{WRAPPER}} .felan-icon-box:hover .icon',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control('icon_space', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}}.elementor-position-right .felan-icon-wrap' => 'margin-left: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}}.elementor-position-left .felan-icon-wrap'  => 'margin-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}}.elementor-position-top .felan-icon-wrap'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
				'(mobile){{WRAPPER}} .felan-icon-wrap'                  => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'before',
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
			'selectors' => [
				'{{WRAPPER}} .felan-icon-view, {{WRAPPER}} .felan-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('icon_rotate', [
			'label'     => esc_html__('Rotate', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'default'   => [
				'unit' => 'deg',
			],
			'selectors' => [
				'{{WRAPPER}} .felan-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
			],
		]);

		// Icon View Settings.
		$this->add_control('icon_view_heading', [
			'label'     => esc_html__('Icon View', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'view' => ['stacked', 'bubble'],
			],
		]);

		$this->add_control('icon_padding', [
			'label'     => esc_html__('Padding', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'selectors' => [
				'{{WRAPPER}} .felan-icon-view' => 'padding: {{SIZE}}{{UNIT}};',
			],
			'range'     => [
				'em' => [
					'min' => 0,
					'max' => 5,
				],
			],
			'condition' => [
				'view' => ['stacked'],
			],
		]);

		$this->add_control('icon_border_radius', [
			'label'      => esc_html__('Border Radius', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'selectors'  => [
				'{{WRAPPER}} .felan-icon-view' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition'  => [
				'view' => ['stacked'],
			],
		]);

		$this->start_controls_tabs('icon_view_colors', [
			'condition' => [
				'view' => ['stacked', 'bubble'],
			],
		]);

		$this->start_controls_tab('icon_view_colors_normal', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'icon_view',
			'selector' => '{{WRAPPER}} .felan-icon-view',
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'icon_view',
			'selector' => '{{WRAPPER}} .felan-icon-view',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('icon_view_colors_hover', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'hover_icon_view',
			'selector' => '{{WRAPPER}} .felan-icon-box:hover .felan-icon-view',
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'hover_icon_view',
			'selector' => '{{WRAPPER}} .felan-icon-box:hover .felan-icon-view',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_title_style_section()
	{
		$this->start_controls_section('title_style_section', [
			'label' => esc_html__('Title', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'title',
			'selector' => '{{WRAPPER}} .heading',
			'global' => ['default' =>  Global_Typography::TYPOGRAPHY_PRIMARY],
		]);

		$this->start_controls_tabs('title_colors');

		$this->start_controls_tab('title_color_normal', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'title',
			'selector' => '{{WRAPPER}} .heading',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('title_color_hover', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'title_hover',
			'selector' => '{{WRAPPER}} .felan-icon-box:hover .heading',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_title_divider_style()
	{
		$this->start_controls_section('title_divider_style_section', [
			'label'     => esc_html__('Title Divider', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'title_divider_enable' => 'yes',
			],
		]);

		$this->start_controls_tabs('title_divider_colors');

		$this->start_controls_tab('title_divider_colors_normal', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'title_divider',
			'selector' => '{{WRAPPER}} .heading-divider:before',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('title_divider_colors_hover', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'hover_title_divider',
			'selector' => '{{WRAPPER}} .heading-divider:after',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_description_style_section()
	{
		$this->start_controls_section('description_style_section', [
			'label'     => esc_html__('Description', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'description_text!' => '',
			],
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'description',
			'selector' => '{{WRAPPER}} .description',
			'global' => ['default' =>  Global_Typography::TYPOGRAPHY_TEXT],
		]);

		$this->start_controls_tabs('description_colors');

		$this->start_controls_tab('description_color_normal', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'description',
			'selector' => '{{WRAPPER}} .description',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('description_color_hover', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'description_hover',
			'selector' => '{{WRAPPER}} .felan-icon-box:hover .description',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control('description_spacing', [
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
				'{{WRAPPER}} .description-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
			'separator'  => 'before',
		]);

		$this->add_responsive_control('description_max_width', [
			'label'      => esc_html__('Max Width', 'felan'),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => ['px', '%'],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .description' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('box', 'class', 'felan-icon-box felan-box');

		if (!empty($settings['icon_svg_animate']) && 'yes' === $settings['icon_svg_animate']) {
			$vivus_settings = [
				'enable'        => $settings['icon_svg_animate'],
				'type'          => $settings['icon_svg_animate_type'],
				'duration'      => $settings['icon_svg_animate_duration'],
				'play_on_hover' => $settings['icon_svg_animate_play_on_hover'],
			];
			$this->add_render_attribute('box', 'data-vivus', wp_json_encode($vivus_settings));
		}

		$box_tag = 'div';

		if (!empty($settings['link']['url']) && 'box' === $settings['link_click']) {
			$box_tag = 'a';

			$this->add_render_attribute('box', 'class', 'link-secret');
			$this->add_link_attributes('box', $settings['link']);
		}
?>
		<?php printf('<%1$s %2$s>', $box_tag, $this->get_render_attribute_string('box')); ?>

		<div class="icon-box-wrapper">
			<?php $this->print_icon($settings); ?>

			<div class="icon-box-content">
				<?php $this->print_title($settings); ?>

				<?php $this->print_description($settings); ?>

				<?php $this->render_common_button(); ?>
			</div>
		</div>

		<?php printf('</%1$s>', $box_tag); ?>
	<?php
	}

	protected function content_template()
	{
		$id = uniqid('svg-gradient');
		// @formatter:off
	?>
		<# var svg_id='<?php echo esc_html($id); ?>' ; #>

			<# view.addRenderAttribute( 'box' , 'class' , 'felan-icon-box felan-box' ); var box_tag='div' ; if ( '' !==settings.link.url && 'box'===settings.link_click ) { box_tag='a' ; view.addRenderAttribute( 'box' , 'class' , 'link-secret' ); view.addRenderAttribute( 'box' , 'href' , '#' ); } view.addRenderAttribute( 'icon' , 'class' , 'felan-icon icon' ); if ( 'svg'===settings.icon.library ) { view.addRenderAttribute( 'icon' , 'class' , 'felan-svg-icon' ); } if ( 'gradient'===settings.icon_color_type ) { view.addRenderAttribute( 'icon' , 'class' , 'felan-gradient-icon' ); } else { view.addRenderAttribute( 'icon' , 'class' , 'felan-solid-icon' ); } var iconHTML=elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden' : true }, 'i' , 'object' ); #>
				<{{{ box_tag }}} {{{ view.getRenderAttributeString( 'box' ) }}}>
					<div class="icon-box-wrapper">

						<div class="felan-icon-wrap">
							<div class="felan-icon-view">
								<div {{{ view.getRenderAttributeString( 'icon' ) }}}>
									<# if ( iconHTML.rendered ) { #>
										<# var stop_a=settings.icon_color_a_stop.size + settings.icon_color_a_stop.unit; var stop_b=settings.icon_color_b_stop.size + settings.icon_color_b_stop.unit; var iconValue=iconHTML.value; if ( typeof iconValue==='string' ) { var strokeAttr='stroke="' + 'url(#' + svg_id + ')"' ; var fillAttr='fill="' + 'url(#' + svg_id + ')"' ; iconValue=iconValue.replace(new RegExp(/stroke="#(.*?)" /, 'g' ), strokeAttr); iconValue=iconValue.replace(new RegExp(/fill="#(.*?)" /, 'g' ), fillAttr); } #>
											<svg aria-hidden="true" focusable="false" class="svg-defs-gradient">
												<defs>
													<linearGradient id="{{{ svg_id }}}" x1="0%" y1="0%" x2="0%" y2="100%">
														<stop class="stop-a" offset="{{{ stop_a }}}" />
														<stop class="stop-b" offset="{{{ stop_b }}}" />
													</linearGradient>
												</defs>
											</svg>

											{{{ iconValue }}}
											<# } #>
								</div>
							</div>
						</div>
						<div class="icon-box-content">
							<# if ( settings.title_text ) { #>
								<# view.addRenderAttribute( 'title' , 'class' , 'heading' ); #>
									<div class="heading-wrap">
										<{{{ settings.title_size }}} {{{ view.getRenderAttributeString( 'title' ) }}}>
											{{{ settings.title_text }}}
										</{{{ settings.title_size }}}>

										<# if ( 'yes'===settings.title_divider_enable ) { #>
											<div class="heading-divider-wrap">
												<div class="heading-divider"></div>
											</div>
											<# } #>
									</div>
									<# } #>

										<# if ( settings.description_text ) { #>
											<# view.addRenderAttribute( 'description' , 'class' , 'description' ); #>
												<div class="description-wrap">
													<div {{{ view.getRenderAttributeString( 'description' ) }}}>
														{{{ settings.description_text }}}
													</div>
												</div>
												<# } #>

													<# if ( settings.button_text || settings.button_icon.value ) { #>
														<# var buttonIconHTML=elementor.helpers.renderIcon( view, settings.button_icon, { 'aria-hidden' : true }, 'i' , 'object' ); var buttonTag='div' ; view.addRenderAttribute( 'button' , 'class' , 'felan-button style-' + settings.button_style ); view.addRenderAttribute( 'button' , 'class' , 'felan-button-' + settings.button_size ); if ( '' !==settings.link.url && 'button'===settings.link_click ) { buttonTag='a' ; view.addRenderAttribute( 'button' , 'href' , '#' ); } if ( settings.button_icon.value ) { view.addRenderAttribute( 'button' , 'class' , 'icon-' + settings.button_icon_align ); } view.addRenderAttribute( 'button-icon' , 'class' , 'button-icon' ); #>
															<div class="felan-button-wrapper">
																<{{{ buttonTag }}} {{{ view.getRenderAttributeString( 'button' ) }}}>
																	<div class="button-content-wrapper">
																		<# if ( buttonIconHTML.rendered && 'left'===settings.button_icon_align ) { #>
																			<span {{{ view.getRenderAttributeString( 'button-icon' ) }}}>
																				{{{ buttonIconHTML.value }}}
																			</span>
																			<# } #>

																				<# if ( settings.button_text ) { #>
																					<span class="button-text">{{{ settings.button_text }}}</span>
																					<# } #>

																						<# if ( buttonIconHTML.rendered && 'right'===settings.button_icon_align ) { #>
																							<span {{{ view.getRenderAttributeString( 'button-icon' ) }}}>
																								{{{ buttonIconHTML.value }}}
																							</span>
																							<# } #>
																	</div>
																</{{{ buttonTag }}}>
															</div>
															<# } #>
						</div>

					</div>
				</{{{ box_tag }}}>
			<?php
			// @formatter:off
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
				<div class="felan-icon-wrap">
					<div class="felan-icon-view">
						<div <?php $this->print_attributes_string('icon'); ?>>
							<?php $this->render_icon($settings, $settings['icon'], ['aria-hidden' => 'true'], $is_svg, 'icon'); ?>
						</div>
					</div>
				</div>
			<?php
		}

		private function print_title(array $settings)
		{
			if (empty($settings['title_text'])) {
				return;
			}

			$this->add_render_attribute('title', 'class', 'heading');
			?>
				<div class="heading-wrap">
					<?php printf('<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string('title'), $settings['title_text']); ?>

					<?php $this->print_title_divider($settings); ?>
				</div>
			<?php
		}

		private function print_title_divider(array $settings)
		{
			if (empty($settings['title_divider_enable']) || 'yes' !== $settings['title_divider_enable']) {
				return;
			}
			?>
				<div class="heading-divider-wrap">
					<div class="heading-divider"></div>
				</div>
			<?php
		}

		private function print_description(array $settings)
		{
			if (empty($settings['description_text'])) {
				return;
			}

			$this->add_render_attribute('description', 'class', 'description');
			?>
				<div class="description-wrap">
					<div <?php $this->print_attributes_string('description'); ?>>
						<?php echo wp_kses_post($settings['description_text']); ?>
					</div>
				</div>
		<?php
		}
	}
