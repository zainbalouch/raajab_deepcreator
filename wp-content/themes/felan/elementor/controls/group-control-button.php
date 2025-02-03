<?php

namespace Felan_Elementor;

use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;

defined('ABSPATH') || exit;

/**
 * Elementor advanced border control.
 *
 * A base control for creating border control. Displays input fields to define
 * border type, border width and border color.
 *
 * @since 1.0.0
 */
class Group_Control_Button extends Group_Control_Base
{

	protected static $fields;

	public static function get_type()
	{
		return 'button';
	}

	protected function init_fields()
	{
		$fields = [];

		$fields['heading'] = [
			'label'     => esc_html__('Button', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		];

		$fields['style'] = [
			'label'   => esc_html__('Button Style', 'felan'),
			'type'    => Controls_Manager::SELECT,
			'default' => 'classic',
			'options' => Widget_Utils::get_button_style(),
		];

		$fields['text'] = [
			'label'   => esc_html__('Button Text', 'felan'),
			'type'    => Controls_Manager::TEXT,
			'dynamic' => [
				'active' => true,
			],
		];

		$fields['link'] = [
			'label'       => esc_html__('Link', 'felan'),
			'type'        => Controls_Manager::URL,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => esc_attr__('https://your-link.com', 'felan'),
			'default'     => [
				'url' => '#',
			],
		];

		$fields['icon'] = [
			'label'       => esc_html__('Button Icon', 'felan'),
			'type'        => Controls_Manager::ICONS,
			'label_block' => true,
		];

		$fields['icon_align'] = [
			'label'       => esc_html__('Icon Position', 'felan'),
			'type'        => Controls_Manager::CHOOSE,
			'options'     => [
				'left'  => [
					'title' => esc_html__('Left', 'felan'),
					'icon'  => 'eicon-h-align-left',
				],
				'right' => [
					'title' => esc_html__('Right', 'felan'),
					'icon'  => 'eicon-h-align-right',
				],
			],
			'default'     => 'left',
			'toggle'      => false,
			'label_block' => false,
			'condition'   => [
				'icon[value]!' => '',
			],
		];

		$fields['size'] = [
			'label'   => esc_html__('Button Size', 'felan'),
			'type'    => Controls_Manager::SELECT,
			'default' => 'nm',
			'options' => [
				'xs' => esc_html__('Extra Small', 'felan'),
				'sm' => esc_html__('Small', 'felan'),
				'nm' => esc_html__('Normal', 'felan'),
				'lg' => esc_html__('Large', 'felan'),
			],
		];

		return $fields;
	}

	protected function get_default_options()
	{
		return [
			'popover' => false,
		];
	}
}
