<?php

namespace Felan_Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Utils;

defined('ABSPATH') || exit;

class Widget_Flip_Box extends Base
{

	public function get_name()
	{
		return 'felan-flip-box';
	}

	public function get_title()
	{
		return esc_html__('Advanced Flip Box', 'felan');
	}

	public function get_icon_part()
	{
		return 'eicon-flip-box';
	}

	public function get_script_depends()
	{
		return ['felan-widget-flip-box'];
	}

	public function get_style_depends()
	{
		return ['felan-el-widget-flip-box'];
	}

	protected function register_controls()
	{
		// Content Tab.
		$this->add_front_side_content_section();

		$this->add_back_side_content_section();

		$this->add_box_settings_section();

		// Style Tab - Front Side.
		$this->add_front_side_box_style_section();

		$this->add_front_side_image_style_section();

		$this->add_front_side_icon_style_section();

		$this->add_front_side_heading_style_section();

		$this->add_front_side_description_style_section();

		// Style Tab - Back Side.
		$this->add_back_side_box_style_section();

		$this->add_back_side_image_style_section();

		$this->add_back_side_icon_style_section();

		$this->add_back_side_heading_style_section();

		$this->add_back_side_description_style_section();

		$this->register_common_button_style_section();
	}

	private function add_front_side_content_section()
	{
		$this->start_controls_section('content_front_side_section', [
			'label' => esc_html__('Front', 'felan'),
		]);

		$this->start_controls_tabs('side_a_content_tabs');

		$this->start_controls_tab('side_a_content_tab', ['label' => esc_html__('Content', 'felan')]);

		$this->add_control('graphic_element_a', [
			'label'       => esc_html__('Graphic Element', 'felan'),
			'type'        => Controls_Manager::CHOOSE,
			'label_block' => false,
			'options'     => [
				'none'  => [
					'title' => esc_html__('None', 'felan'),
					'icon'  => 'eicon-ban',
				],
				'image' => [
					'title' => esc_html__('Image', 'felan'),
					'icon'  => 'fa fa-picture-o',
				],
				'icon'  => [
					'title' => esc_html__('Icon', 'felan'),
					'icon'  => 'eicon-star',
				],
			],
			'default'     => 'icon',
		]);

		$this->add_control('image_a', [
			'label'     => esc_html__('Choose Image', 'felan'),
			'type'      => Controls_Manager::MEDIA,
			'default'   => [
				'url' => Utils::get_placeholder_image_src(),
			],
			'dynamic'   => [
				'active' => true,
			],
			'condition' => [
				'graphic_element_a' => 'image',
			],
		]);

		$this->add_group_control(Group_Control_Image_Size::get_type(), [
			'name'      => 'image_a', // Actually its `image_a_size`
			'default'   => 'thumbnail',
			'condition' => [
				'graphic_element_a' => 'image',
			],
		]);

		$this->add_control('icon_a', [
			'label'     => esc_html__('Icon', 'felan'),
			'type'      => Controls_Manager::ICONS,
			'default'   => [
				'value'   => 'fas fa-star',
				'library' => 'fa-solid',
			],
			'condition' => [
				'graphic_element_a' => 'icon',
			],
		]);

		$this->add_control('title_text_a', [
			'label'       => esc_html__('Title & Description', 'felan'),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__('This is the heading', 'felan'),
			'placeholder' => esc_html__('Enter your title', 'felan'),
			'dynamic'     => [
				'active' => true,
			],
			'label_block' => true,
			'separator'   => 'before',
		]);

		$this->add_control('description_text_a', [
			'label'       => esc_html__('Description', 'felan'),
			'type'        => Controls_Manager::TEXTAREA,
			'default'     => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'felan'),
			'placeholder' => esc_html__('Enter your description', 'felan'),
			'separator'   => 'none',
			'dynamic'     => [
				'active' => true,
			],
			'rows'        => 10,
			'show_label'  => false,
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('side_a_background_tab', ['label' => esc_html__('Background', 'felan')]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'background_a',
			'types'    => ['classic', 'gradient'],
			'selector' => '{{WRAPPER}} .front-side',
		]);

		$this->add_control('background_overlay_a', [
			'label'     => esc_html__('Background Overlay', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .front-side .overlay' => 'background-color: {{VALUE}};',
			],
			'separator' => 'before',
			'condition' => [
				'background_a_image[id]!' => '',
			],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_back_side_content_section()
	{
		$this->start_controls_section('content_back_side_section', [
			'label' => esc_html__('Back', 'felan'),
		]);

		$this->start_controls_tabs('side_b_content_tabs');

		$this->start_controls_tab('side_b_content_tab', ['label' => esc_html__('Content', 'felan')]);

		$this->add_control('graphic_element_b', [
			'label'       => esc_html__('Graphic Element', 'felan'),
			'type'        => Controls_Manager::CHOOSE,
			'label_block' => false,
			'options'     => [
				'none'  => [
					'title' => esc_html__('None', 'felan'),
					'icon'  => 'eicon-ban',
				],
				'image' => [
					'title' => esc_html__('Image', 'felan'),
					'icon'  => 'fa fa-picture-o',
				],
				'icon'  => [
					'title' => esc_html__('Icon', 'felan'),
					'icon'  => 'eicon-star',
				],
			],
			'default'     => 'icon',
		]);

		$this->add_control('image_b', [
			'label'     => esc_html__('Choose Image', 'felan'),
			'type'      => Controls_Manager::MEDIA,
			'default'   => [
				'url' => Utils::get_placeholder_image_src(),
			],
			'dynamic'   => [
				'active' => true,
			],
			'condition' => [
				'graphic_element_b' => 'image',
			],
		]);

		$this->add_group_control(Group_Control_Image_Size::get_type(), [
			'name'      => 'image_b', // Actually its `image_b_size`
			'default'   => 'thumbnail',
			'condition' => [
				'graphic_element_b' => 'image',
			],
		]);

		$this->add_control('icon_b', [
			'label'     => esc_html__('Icon', 'felan'),
			'type'      => Controls_Manager::ICONS,
			'default'   => [
				'value'   => 'fas fa-star',
				'library' => 'fa-solid',
			],
			'condition' => [
				'graphic_element_b' => 'icon',
			],
		]);

		$this->add_control('title_text_b', [
			'label'       => esc_html__('Title & Description', 'felan'),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__('This is the heading', 'felan'),
			'placeholder' => esc_html__('Enter your title', 'felan'),
			'dynamic'     => [
				'active' => true,
			],
			'label_block' => true,
		]);

		$this->add_control('description_text_b', [
			'label'       => esc_html__('Description', 'felan'),
			'type'        => Controls_Manager::TEXTAREA,
			'default'     => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'felan'),
			'placeholder' => esc_html__('Enter your description', 'felan'),
			'separator'   => 'none',
			'dynamic'     => [
				'active' => true,
			],
			'rows'        => 10,
			'show_label'  => false,
		]);

		$this->add_group_control(Group_Control_Button::get_type(), [
			'name'           => 'button',
			// Use box link instead of.
			'exclude'        => [
				'link',
			],
			// Change button style text as default.
			'fields_options' => [
				'style' => [
					'default' => 'bottom-line',
				],
			],
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
			'default'   => 'button',
			'condition' => [
				'link[url]!' => '',
			],
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('side_b_background_tab', ['label' => esc_html__('Background', 'felan')]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'background_b',
			'types'    => ['classic', 'gradient'],
			'selector' => '{{WRAPPER}} .back-side',
		]);

		$this->add_control('background_overlay_b', [
			'label'     => esc_html__('Background Overlay', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .back-side .overlay' => 'background-color: {{VALUE}};',
			],
			'separator' => 'before',
			'condition' => [
				'background_b_image[id]!' => '',
			],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_box_settings_section()
	{
		$this->start_controls_section('section_box_settings', [
			'label' => esc_html__('Settings', 'felan'),
		]);

		$this->add_responsive_control('min_height', [
			'label'      => esc_html__('Min Height', 'felan'),
			'type'       => Controls_Manager::SLIDER,
			'range'      => [
				'px' => [
					'min' => 100,
					'max' => 1000,
				],
			],
			'size_units' => ['px'],
			'selectors'  => [
				'{{WRAPPER}} .felan-flip-box' => 'min-height: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('border_radius', [
			'label'      => esc_html__('Border Radius', 'felan'),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => ['px', '%'],
			'range'      => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'separator'  => 'after',
			'selectors'  => [
				'{{WRAPPER}} .layer, {{WRAPPER}} .overlay' => 'border-radius: {{SIZE}}{{UNIT}}',
			],
		]);

		$this->add_control('flip_effect', [
			'label'        => esc_html__('Flip Effect', 'felan'),
			'type'         => Controls_Manager::SELECT,
			'default'      => 'flip',
			'options'      => [
				'flip'     => 'Flip',
				'slide'    => 'Slide',
				'push'     => 'Push',
				'zoom-in'  => 'Zoom In',
				'zoom-out' => 'Zoom Out',
				'fade'     => 'Fade',
			],
			'prefix_class' => 'felan-flip-box--effect-',
		]);

		$this->add_control('flip_direction', [
			'label'        => esc_html__('Flip Direction', 'felan'),
			'type'         => Controls_Manager::SELECT,
			'default'      => 'up',
			'options'      => [
				'left'  => esc_html__('Left', 'felan'),
				'right' => esc_html__('Right', 'felan'),
				'up'    => esc_html__('Up', 'felan'),
				'down'  => esc_html__('Down', 'felan'),
			],
			'condition'    => [
				'flip_effect!' => [
					'fade',
					'zoom-in',
					'zoom-out',
				],
			],
			'prefix_class' => 'felan-flip-box--direction-',
		]);

		$this->add_control('flip_3d', [
			'label'        => esc_html__('3D Depth', 'felan'),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__('On', 'felan'),
			'label_off'    => esc_html__('Off', 'felan'),
			'return_value' => 'felan-flip-box--3d',
			'default'      => '',
			'prefix_class' => '',
			'condition'    => [
				'flip_effect' => 'flip',
			],
		]);

		$this->end_controls_section();
	}

	private function add_front_side_box_style_section()
	{
		$this->start_controls_section('box_style_front_side_section', [
			'label' => esc_html__('Front - Box', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control('padding_a', [
			'label'      => esc_html__('Padding', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', 'em', '%'],
			'selectors'  => [
				'{{WRAPPER}} .front-side .layer-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->add_control('alignment_a', [
			'label'       => esc_html__('Alignment', 'felan'),
			'type'        => Controls_Manager::CHOOSE,
			'label_block' => false,
			'options'     => [
				'left'   => [
					'title' => esc_html__('Left', 'felan'),
					'icon'  => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__('Center', 'felan'),
					'icon'  => 'eicon-text-align-center',
				],
				'right'  => [
					'title' => esc_html__('Right', 'felan'),
					'icon'  => 'eicon-text-align-right',
				],
			],
			'selectors'   => [
				'{{WRAPPER}} .front-side' => 'text-align: {{VALUE}}',
			],
		]);

		$this->add_control('vertical_position_a', [
			'label'                => esc_html__('Vertical Position', 'felan'),
			'type'                 => Controls_Manager::CHOOSE,
			'label_block'          => false,
			'options'              => [
				'top'    => [
					'title' => esc_html__('Top', 'felan'),
					'icon'  => 'eicon-v-align-top',
				],
				'middle' => [
					'title' => esc_html__('Middle', 'felan'),
					'icon'  => 'eicon-v-align-middle',
				],
				'bottom' => [
					'title' => esc_html__('Bottom', 'felan'),
					'icon'  => 'eicon-v-align-bottom',
				],
			],
			'selectors_dictionary' => [
				'top'    => 'flex-start',
				'middle' => 'center',
				'bottom' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .front-side .layer-inner' => 'align-items: {{VALUE}}',
			],
		]);

		$this->add_group_control(Group_Control_Border::get_type(), [
			'name'      => 'border_a',
			'selector'  => '{{WRAPPER}} .front-side',
			'separator' => 'before',
		]);

		$this->end_controls_section();
	}

	private function add_front_side_image_style_section()
	{
		$this->start_controls_section('image_style_front_side_section', [
			'label'     => esc_html__('Front - Image', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'graphic_element_a' => 'image',
			],
		]);

		$this->add_control('image_spacing_a', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .front-side .image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('image_width_a', [
			'label'      => esc_html__('Size', 'felan') . ' (%)',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => ['%'],
			'default'    => [
				'unit' => '%',
			],
			'range'      => [
				'%' => [
					'min' => 5,
					'max' => 100,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .front-side .image img' => 'width: {{SIZE}}{{UNIT}}',
			],
		]);

		$this->add_control('image_opacity_a', [
			'label'     => esc_html__('Opacity', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .front-side .image' => 'opacity: {{SIZE}};',
			],
		]);

		$this->add_group_control(Group_Control_Border::get_type(), [
			'name'      => 'image_border_a',
			'selector'  => '{{WRAPPER}} .front-side .image img',
			'separator' => 'before',
		]);

		$this->add_control('image_border_radius_a', [
			'label'     => esc_html__('Border Radius', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .front-side .image img' => 'border-radius: {{SIZE}}{{UNIT}}',
			],
		]);

		$this->end_controls_section();
	}

	private function add_front_side_icon_style_section()
	{
		$this->start_controls_section('icon_style_front_side_section', [
			'label'     => esc_html__('Front - Icon', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'graphic_element_a' => 'icon',
			],
		]);

		$this->add_control('icon_spacing_a', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .front-side .felan-icon-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'icon_a',
			'selector' => '{{WRAPPER}} .front-side .icon',
		]);

		$this->add_responsive_control('icon_size_a', [
			'label'     => esc_html__('Size', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 6,
					'max' => 300,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .front-side .felan-icon-view, {{WRAPPER}} .front-side .felan-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('icon_rotate_a', [
			'label'     => esc_html__('Rotate', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'default'   => [
				'unit' => 'deg',
			],
			'selectors' => [
				'{{WRAPPER}} .front-side .felan-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
			],
		]);

		$this->end_controls_section();
	}

	private function add_front_side_heading_style_section()
	{
		$this->start_controls_section('heading_style_front_side_section', [
			'label'     => esc_html__('Front - Heading', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'title_text_a!' => '',
			],
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'title_a',
			'default'   => Global_Typography::TYPOGRAPHY_PRIMARY,
			'selector' => '{{WRAPPER}} .front-side .heading',
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'title_a',
			'selector' => '{{WRAPPER}} .front-side .heading',
		]);

		$this->end_controls_section();
	}

	private function add_front_side_description_style_section()
	{
		$this->start_controls_section('description_style_front_side_section', [
			'label'     => esc_html__('Front - Description', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'description_text_a!' => '',
			],
		]);

		$this->add_control('description_spacing_a', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .front-side .description-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'description_a',
			'global' => ['default' =>  Global_Typography::TYPOGRAPHY_TEXT],
			'selector' => '{{WRAPPER}} .front-side .description',
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'description_a',
			'selector' => '{{WRAPPER}} .front-side .description',
		]);

		$this->end_controls_section();
	}

	private function add_back_side_box_style_section()
	{
		$this->start_controls_section('box_style_back_side_section', [
			'label' => esc_html__('Back - Box', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control('padding_b', [
			'label'      => esc_html__('Padding', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', 'em', '%'],
			'selectors'  => [
				'{{WRAPPER}} .back-side .layer-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->add_control('alignment_b', [
			'label'       => esc_html__('Alignment', 'felan'),
			'type'        => Controls_Manager::CHOOSE,
			'label_block' => false,
			'options'     => [
				'left'   => [
					'title' => esc_html__('Left', 'felan'),
					'icon'  => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__('Center', 'felan'),
					'icon'  => 'eicon-text-align-center',
				],
				'right'  => [
					'title' => esc_html__('Right', 'felan'),
					'icon'  => 'eicon-text-align-right',
				],
			],
			'selectors'   => [
				'{{WRAPPER}} .back-side' => 'text-align: {{VALUE}}',
			],
		]);

		$this->add_control('vertical_position_b', [
			'label'                => esc_html__('Vertical Position', 'felan'),
			'type'                 => Controls_Manager::CHOOSE,
			'label_block'          => false,
			'options'              => [
				'top'    => [
					'title' => esc_html__('Top', 'felan'),
					'icon'  => 'eicon-v-align-top',
				],
				'middle' => [
					'title' => esc_html__('Middle', 'felan'),
					'icon'  => 'eicon-v-align-middle',
				],
				'bottom' => [
					'title' => esc_html__('Bottom', 'felan'),
					'icon'  => 'eicon-v-align-bottom',
				],
			],
			'selectors_dictionary' => [
				'top'    => 'flex-start',
				'middle' => 'center',
				'bottom' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .back-side .layer-inner' => 'align-items: {{VALUE}}',
			],
		]);

		$this->add_group_control(Group_Control_Border::get_type(), [
			'name'      => 'border_b',
			'selector'  => '{{WRAPPER}} .back-side',
			'separator' => 'before',
		]);

		$this->end_controls_section();
	}

	private function add_back_side_image_style_section()
	{
		$this->start_controls_section('image_style_back_side_section', [
			'label'     => esc_html__('Back - Image', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'graphic_element_b' => 'image',
			],
		]);

		$this->add_control('image_spacing_b', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .back-side .image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('image_width_b', [
			'label'      => esc_html__('Size', 'felan') . ' (%)',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => ['%'],
			'default'    => [
				'unit' => '%',
			],
			'range'      => [
				'%' => [
					'min' => 5,
					'max' => 100,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .back-side .image img' => 'width: {{SIZE}}{{UNIT}}',
			],
		]);

		$this->add_control('image_opacity_b', [
			'label'     => esc_html__('Opacity', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .back-side .image' => 'opacity: {{SIZE}};',
			],
		]);

		$this->add_group_control(Group_Control_Border::get_type(), [
			'name'      => 'image_border_b',
			'selector'  => '{{WRAPPER}} .back-side .image img',
			'separator' => 'before',
		]);

		$this->add_control('image_border_radius_b', [
			'label'     => esc_html__('Border Radius', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .back-side .image img' => 'border-radius: {{SIZE}}{{UNIT}}',
			],
		]);

		$this->end_controls_section();
	}

	private function add_back_side_icon_style_section()
	{
		$this->start_controls_section('icon_style_back_side_section', [
			'label'     => esc_html__('Back - Icon', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'graphic_element_b' => 'icon',
			],
		]);

		$this->add_control('icon_spacing_b', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .back-side .felan-icon-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'icon_b',
			'selector' => '{{WRAPPER}} .back-side .icon',
		]);

		$this->add_responsive_control('icon_size_b', [
			'label'     => esc_html__('Size', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 6,
					'max' => 300,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .back-side .felan-icon-view, {{WRAPPER}} .back-side .felan-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('icon_rotate_b', [
			'label'     => esc_html__('Rotate', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'default'   => [
				'unit' => 'deg',
			],
			'selectors' => [
				'{{WRAPPER}} .back-side .felan-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
			],
		]);

		$this->end_controls_section();
	}

	private function add_back_side_heading_style_section()
	{
		$this->start_controls_section('heading_style_back_side_section', [
			'label'     => esc_html__('Back - Heading', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'title_text_b!' => '',
			],
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'title_b',
            'global' => ['default' =>  Global_Typography::TYPOGRAPHY_PRIMARY],
			'selector' => '{{WRAPPER}} .back-side .heading',
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'title_b',
			'selector' => '{{WRAPPER}} .back-side .heading',
		]);

		$this->end_controls_section();
	}

	private function add_back_side_description_style_section()
	{
		$this->start_controls_section('description_style_back_side_section', [
			'label'     => esc_html__('Back - Description', 'felan'),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'description_text_b!' => '',
			],
		]);

		$this->add_control('description_spacing_b', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .back-side .description-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'description_b',
			'global' => ['default' =>  Global_Typography::TYPOGRAPHY_TEXT],
			'selector' => '{{WRAPPER}} .back-side .description',
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'description_b',
			'selector' => '{{WRAPPER}} .back-side .description',
		]);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
?>
		<div class="felan-flip-box">
			<?php $this->print_front_side_html($settings); ?>

			<?php $this->print_back_side_html($settings); ?>
		</div>
	<?php
	}

	private function print_front_side_html(array $settings)
	{
	?>
		<div class="layer front-side">
			<div class="overlay"></div>
			<div class="layer-inner">
				<div class="layer-content">
					<?php
					switch ($settings['graphic_element_a']) {
						case 'image':
							$this->print_graphic_image($settings);
							break;
						case 'icon':
							$this->print_graphic_icon($settings);
							break;
					}
					?>

					<?php $this->print_heading($settings); ?>

					<?php $this->print_description($settings); ?>
				</div>
			</div>
		</div>
	<?php
	}

	private function print_back_side_html(array $settings)
	{
		$wrapper_tag = 'div';

		$this->add_render_attribute('wrapper', 'class', 'layer back-side');

		if (!empty($settings['link']['url']) && 'box' === $settings['link_click']) {
			$wrapper_tag = 'a';

			$this->add_link_attributes('wrapper', $settings['link']);
		}

		printf('<%1$s %2$s>', $wrapper_tag, $this->get_render_attribute_string('wrapper'));
	?>
		<div class="overlay"></div>
		<div class="layer-inner">
			<div class="layer-content">
				<?php
				switch ($settings['graphic_element_b']) {
					case 'image':
						$this->print_graphic_image($settings, 'b');
						break;
					case 'icon':
						$this->print_graphic_icon($settings, 'b');
						break;
				}
				?>

				<?php $this->print_heading($settings, 'b'); ?>

				<?php $this->print_description($settings, 'b'); ?>

				<?php $this->render_common_button(); ?>
			</div>
		</div>
	<?php
		printf('</%1$s>', $wrapper_tag);
	}

	private function print_graphic_image(array $settings, $side = 'a')
	{
		$image_key = "image_{$side}";

		if (empty($settings[$image_key]['url'])) {
			return;
		}
	?>
		<div class="image">
			<?php echo \Felan_Image::get_elementor_attachment([
				'settings'  => $settings,
				'image_key' => $image_key,
			]); ?>
		</div>
	<?php
	}

	private function print_graphic_icon(array $settings, $side = 'a')
	{
		if (empty($settings["icon_{$side}"]['value'])) {
			return;
		}

		$icon_key = "icon-wrapper-{$side}";

		$this->add_render_attribute($icon_key, 'class', [
			'felan-icon',
			'icon',
		]);

		$is_svg = isset($settings["icon_{$side}"]['library']) && 'svg' === $settings["icon_{$side}"]['library'] ? true : false;

		if ($is_svg) {
			$this->add_render_attribute($icon_key, 'class', [
				'felan-svg-icon',
			]);
		}

		if ('gradient' === $settings["icon_{$side}_color_type"]) {
			$this->add_render_attribute($icon_key, 'class', [
				'felan-gradient-icon',
			]);
		} else {
			$this->add_render_attribute($icon_key, 'class', [
				'felan-solid-icon',
			]);
		}
	?>
		<div class="felan-icon-wrap">
			<div class="felan-icon-view">
				<div <?php $this->print_attributes_string($icon_key); ?>>
					<?php $this->render_icon($settings, $settings["icon_{$side}"], ['aria-hidden' => 'true'], $is_svg, "icon_{$side}"); ?>
				</div>
			</div>
		</div>
	<?php
	}

	private function print_heading(array $settings, $side = 'a')
	{
		if (empty($settings["title_text_{$side}"])) {
			return;
		}
	?>
		<div class="heading-wrap">
			<h3 class="heading">
				<?php echo wp_kses($settings["title_text_{$side}"], 'felan-default'); ?>
			</h3>
		</div>
	<?php
	}

	private function print_description(array $settings, $side = 'a')
	{
		if (empty($settings["description_text_{$side}"])) {
			return;
		}
	?>
		<div class="description-wrap">
			<div class="description">
				<?php echo wp_kses($settings["description_text_{$side}"], 'felan-default'); ?>
			</div>
		</div>
<?php
	}
}
