<?php

namespace Felan_Elementor;

use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

defined('ABSPATH') || exit;

abstract class Base extends Widget_Base
{

	protected function get_icon_part()
	{
		return 'eicon-elementor-square';
	}

	public function get_icon()
	{
		return 'felan-badge ' . $this->get_icon_part();
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since  2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['felan'];
	}

	protected function print_attributes_string($attr)
	{
		echo '' . $this->get_render_attribute_string($attr);
	}

	/**
	 * Get Render Icon
	 *
	 * Used to render Icon for \Elementor\Controls_Manager::ICONS
	 *
	 * @param array  $icon       Icon Type, Icon value
	 * @param array  $attributes Icon HTML Attributes
	 * @param string $tag        Icon HTML tag, defaults to <i>
	 *
	 * @return mixed|string
	 */
	protected function get_icons_html($icon, $attributes = [], $tag = 'i')
	{
		ob_start();

		Icons_Manager::render_icon($icon, $attributes, $tag);

		$template = ob_get_clean();

		return $template;
	}

	protected function render_icon($settings, $icon, $attributes = [], $svg = false, $color_prefix = 'icon')
	{
		$template = $this->get_render_icon($settings, $icon, $attributes, $svg, $color_prefix);

		echo '' . $template;
	}

	protected function get_render_icon($settings, $icon, $attributes = [], $svg = false, $color_prefix = 'icon')
	{
		$tag = 'i';

		ob_start();
		Icons_Manager::render_icon($icon, $attributes, $tag);
		$template = ob_get_clean();

		if ($svg === true) {
			$id = uniqid('svg-gradient');

			$stroke_attr = 'stroke="' . "url(#{$id})" . '"';
			$fill_attr   = 'fill="' . "url(#{$id})" . '"';

			$template = preg_replace('/stroke="#(.*?)"/', $stroke_attr, $template);
			$template = preg_replace('/fill="#(.*?)"/', $fill_attr, $template);

			$svg_defs = $this->get_svg_gradient_defs($settings, $color_prefix, $id);

			if (!empty($svg_defs)) {
				$template = $svg_defs . $template;
			}
		}

		return $template;
	}

	protected function get_svg_gradient_defs(array $settings, $name, $id)
	{
		if ('gradient' !== $settings["{$name}_color_type"]) {
			return false;
		}

		$color_a_stop = $settings["{$name}_color_a_stop"];
		$color_b_stop = $settings["{$name}_color_b_stop"];

		$color_a_stop_value = $color_a_stop['size'] . $color_a_stop['unit'];
		$color_b_stop_value = $color_b_stop['size'] . $color_a_stop['unit'];

		ob_start();
?>
		<svg aria-hidden="true" focusable="false" class="svg-defs-gradient">
			<defs>
				<linearGradient id="<?php echo esc_attr($id); ?>" x1="0%" y1="0%" x2="0%" y2="100%">
					<stop class="stop-a" offset="<?php echo esc_attr($color_a_stop_value); ?>" />
					<stop class="stop-b" offset="<?php echo esc_attr($color_b_stop_value); ?>" />
				</linearGradient>
			</defs>
		</svg>
	<?php
		return ob_get_clean();
	}

	protected function render_common_button()
	{
		$settings = $this->get_settings_for_display();

		if (empty($settings['button_text']) && empty($settings['button_icon']['value'])) {
			return;
		}

		$this->add_render_attribute('button', 'class', 'felan-button button-' . $settings['button_style']);

		if (!empty($settings['button_size'])) {
			$this->add_render_attribute('button', 'class', 'felan-button-' . $settings['button_size']);
		}

		$button_tag = 'a';

		if (!empty($settings['button_link'])) {
			$this->add_link_attributes('button', $settings['button_link']);
		} else {
			$button_tag = 'div';

			if (!empty($settings['link']) && !empty($settings['link_click']) && 'button' === $settings['link_click']) {
				$button_tag = 'a';
				$this->add_link_attributes('button', $settings['link']);
			}
		}

		$has_icon = false;

		if (!empty($settings['button_icon']['value'])) {
			$has_icon = true;
			$this->add_render_attribute('button', 'class', 'icon-' . $settings['button_icon_align']);

			$this->add_render_attribute('button-icon', 'class', 'button-icon');
		}
	?>
		<div class="felan-button-wrapper">
			<?php printf('<%1$s %2$s>', $button_tag, $this->get_render_attribute_string('button')); ?>
			<div class="button-content-wrapper">
				<?php if ($has_icon && 'left' === $settings['button_icon_align']) : ?>
					<span <?php $this->print_attributes_string('button-icon'); ?>>
						<?php Icons_Manager::render_icon($settings['button_icon']); ?>
					</span>
				<?php endif; ?>

				<?php if (!empty($settings['button_text'])) : ?>
					<span class="button-text"><?php echo esc_html($settings['button_text']); ?></span>
				<?php endif; ?>

				<?php if ($has_icon && 'right' === $settings['button_icon_align']) : ?>
					<span <?php $this->print_attributes_string('button-icon'); ?>>
						<?php Icons_Manager::render_icon($settings['button_icon']); ?>
					</span>
				<?php endif; ?>
			</div>
			<?php printf('</%1$s>', $button_tag); ?>
		</div>
<?php
	}

	/**
	 * Register common button style controls.
	 */
	protected function register_common_button_style_section()
	{
		$this->start_controls_section('button_style_section', [
			'label' => esc_html__('Button', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$icon_condition = [
			'button_icon[value]!' => '',
		];

		$line_condition = [
			'button_style' => ['bottom-line', 'left-line'],
		];

		$this->add_control('button_width', [
			'label'      => esc_html__('Width', 'felan'),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => ['%', 'px'],
			'range'      => [
				'%'  => [
					'max'  => 100,
					'step' => 1,
				],
				'px' => [
					'max'  => 1000,
					'step' => 1,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .felan-button' => 'width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('button_margin', [
			'label'      => esc_html__('Margin', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'selectors'  => [
				'{{WRAPPER}} .felan-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->add_control('button_skin_heading', [
			'label' => esc_html__('Skin', 'felan'),
			'type'  => Controls_Manager::HEADING,
		]);

		$this->start_controls_tabs('button_skin_tabs');

		$this->start_controls_tab('button_skin_normal_tab', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		/**
		 * Button wrapper style.
		 * Background working only with style: flat, border, thick-border.
		 */

		$this->add_control('button_wrapper_color_normal_heading', [
			'label'   => esc_html__('Wrapper', 'felan'),
			'type'    => Controls_Manager::HEADING,
			'classes' => 'control-heading-in-tabs',
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'      => 'button_background',
			'types'     => ['classic', 'gradient'],
			'selector'  => '{{WRAPPER}} .felan-button:before',
			'condition' => [
				'button_style' => ['flat', 'border', 'thick-border'],
			],
		]);

		$this->add_control('button_border_color', [
			'label'     => esc_html__('Border', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .felan-button' => 'border-color: {{VALUE}};',
				'{{WRAPPER}} .felan-button.button-border-bottom:before' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .felan-button.button-border-bottom:after' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .felan-button.button-link:after' => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'button_style!' => ['flat', 'bottom-line', 'left-line'],
			],
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'button_box_shadow',
			'selector' => '{{WRAPPER}} .felan-button',
		]);

		/**
		 * Text Color
		 */
		$this->add_control('button_text_color_normal_heading', [
			'label'     => esc_html__('Text', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'classes'   => 'control-heading-in-tabs',
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'button_text',
			'selector' => '{{WRAPPER}} .felan-button .button-text',
		]);

		/**
		 * Icon Color
		 */
		$this->add_control('button_icon_color_normal_heading', [
			'label'     => esc_html__('Icon', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'classes'   => 'control-heading-in-tabs',
			'condition' => $icon_condition,
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'      => 'button_icon',
			'selector'  => '{{WRAPPER}} .felan-button .button-icon',
			'condition' => $icon_condition,
		]);

		/**
		 * Line Color
		 */
		$this->add_control('button_line_color_normal_heading', [
			'label'     => esc_html__('Line', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'classes'   => 'control-heading-in-tabs',
			'condition' => $line_condition,
		]);

		$this->add_control('button_line_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .felan-button.style-bottom-line .button-content-wrapper:before' => 'background: {{VALUE}};',
				'{{WRAPPER}} .felan-button.style-left-line .button-content-wrapper:before'   => 'background: {{VALUE}};',
			],
			'condition' => $line_condition,
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('button_skin_hover_tab', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		/**
		 * Button wrapper style.
		 * Background working only with style: flat, border, thick-border.
		 */

		$this->add_control('button_wrapper_color_hover_heading', [
			'label'   => esc_html__('Wrapper', 'felan'),
			'type'    => Controls_Manager::HEADING,
			'classes' => 'control-heading-in-tabs',
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'      => 'hover_button_background',
			'types'     => ['classic', 'gradient'],
			'selector'  => '{{WRAPPER}} .felan-button:after',
			'condition' => [
				'button_style' => ['flat', 'border', 'thick-border'],
			],
		]);

		$this->add_control('hover_button_border_color', [
			'label'     => esc_html__('Border', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .felan-button:hover' => 'border-color: {{VALUE}};',
			],
			'condition' => [
				'button_style!' => ['flat', 'bottom-line', 'left-line'],
			],
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'hover_button_box_shadow',
			'selector' => '{{WRAPPER}} .felan-box:hover div.felan-button, {{WRAPPER}} a.felan-button:hover',
		]);

		/**
		 * Text Color
		 */
		$this->add_control('button_text_color_hover_heading', [
			'label'     => esc_html__('Text', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'classes'   => 'control-heading-in-tabs',
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'label'    => 'test',
			'name'     => 'hover_button_text',
			'selector' => '{{WRAPPER}} .felan-box:hover div.felan-button .button-text, {{WRAPPER}} a.felan-button:hover .button-text',
		]);

		/**
		 * Icon Color
		 */
		$this->add_control('button_icon_color_hover_heading', [
			'label'     => esc_html__('Icon', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'classes'   => 'control-heading-in-tabs',
			'condition' => $icon_condition,
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'      => 'hover_button_icon',
			'selector'  => '{{WRAPPER}} .felan-box:hover div.felan-button .button-icon, {{WRAPPER}} a.felan-button:hover .button-icon',
			'condition' => $icon_condition,
		]);

		/**
		 * Line Color
		 */
		$this->add_control('button_line_color_hover_heading', [
			'label'     => esc_html__('Line', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'classes'   => 'control-heading-in-tabs',
			'condition' => $line_condition,
		]);

		$this->add_control('hover_button_line_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .felan-button.style-bottom-line .button-content-wrapper:after' => 'background: {{VALUE}};',
				'{{WRAPPER}} .felan-button.style-left-line .button-content-wrapper:after'   => 'background: {{VALUE}};',
			],
			'condition' => $line_condition,
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		/**
		 * Button text style
		 */
		$this->add_control('button_text_style_heading', [
			'label'     => esc_html__('Text', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'button_text',
			'global' => ['default' =>  Global_Typography::TYPOGRAPHY_ACCENT],
			'selector' => '{{WRAPPER}} .felan-button',
		]);

		/**
		 * Button icon style
		 */
		$this->add_control('button_icon_style_heading', [
			'label'     => esc_html__('Icon', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => $icon_condition,
		]);

		$this->add_control('button_icon_indent', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max' => 50,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .felan-button.icon-left .button-icon'  => 'margin-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .felan-button.icon-right .button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
			],
			'condition' => $icon_condition,
		]);

		$this->add_responsive_control('button_icon_font_size', [
			'label'     => esc_html__('Font Size', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 8,
					'max' => 30,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .felan-button .button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			],
			'condition' => $icon_condition,
		]);

		$this->end_controls_section();
	}
}
