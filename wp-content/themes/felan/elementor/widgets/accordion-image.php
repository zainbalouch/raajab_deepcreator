<?php

namespace Felan_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;

defined('ABSPATH') || exit;

class Widget_Accordion_Image extends Base
{

	public function get_name()
	{
		return 'felan-accordion-image';
	}

	public function get_title()
	{
		return esc_html__('Accordion/Toggle Image', 'felan');
	}

	public function get_icon_part()
	{
		return 'eicon-accordion';
	}

	public function get_keywords()
	{
		return ['modern', 'accordion', 'tabs', 'toggle'];
	}

	public function get_script_depends()
	{
		return ['felan-widget-accordion-image'];
	}

	public function get_style_depends()
	{
		return ['felan-el-widget-accordion-image'];
	}

	protected function register_controls()
	{
		$this->add_content_section();

		$this->add_styling_section();

		$this->add_title_style_section();

		$this->add_icon_style_section();

		$this->add_content_style_section();
	}

	private function add_content_section()
	{
		$this->start_controls_section('content_section', [
			'label' => esc_html__('Items', 'felan'),
		]);

		$this->add_control('heading', [
			'label'       => esc_html__('Heading', 'felan'),
			'type'        => Controls_Manager::TEXT,
			'label_block' => true,
			'dynamic'     => [
				'active' => true,
			],
		]);

		$this->add_control('style', [
			'label'   => esc_html__('Style', 'felan'),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'01' => esc_html__('01', 'felan'),
				'02'    => esc_html__('02', 'felan'),
			],
			'default' => '01',
		]);

		$this->add_control('type', [
			'label'   => esc_html__('Type', 'felan'),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'accordion' => esc_html__('Accordion', 'felan'),
				'toggle'    => esc_html__('Toggle', 'felan'),
			],
			'default' => 'accordion',
		]);

		$this->add_control('button', [
			'label'              => esc_html__('Button', 'felan'),
			'type'               => Controls_Manager::SWITCHER,
			'return_value'       => '1',
			'frontend_available' => true,
		]);

		$this->add_control('button_title', [
			'label'       => esc_html__('Button Title', 'felan'),
			'type'        => Controls_Manager::TEXT,
			'label_block' => true,
			'dynamic'     => [
				'active' => true,
			],
			'condition'   => [
				'button' => '1',
			],
		]);

		$this->add_control(
			'button_link',
			[
				'label' => esc_html__('Button Link', 'felan'),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('https://your-link.com', 'felan'),
				'default' => [
					'url' => '#',
				],
				'condition'   => [
					'button' => '1',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control('title', [
			'label'       => esc_html__('Title', 'felan'),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__('Accordion Title', 'felan'),
			'label_block' => true,
			'dynamic'     => [
				'active' => true,
			],
		]);

		$repeater->add_control('content', [
			'label'   => esc_html__('Content', 'felan'),
			'type'    => Controls_Manager::WYSIWYG,
			'default' => esc_html__('Accordion Content', 'felan'),
		]);

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__('Choose Image', 'felan'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control('items', [
			'label'       => esc_html__('Items', 'felan'),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'title'   => esc_html__('Accordion #1', 'felan'),
					'content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'felan'),
				],
				[
					'title'   => esc_html__('Accordion #2', 'felan'),
					'content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'felan'),
				],
				[
					'title'   => esc_html__('Accordion #3', 'felan'),
					'content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'felan'),
				],
			],
			'title_field' => '{{{ title }}}',
		]);

		$this->add_control('view', [
			'label'   => esc_html__('View', 'felan'),
			'type'    => Controls_Manager::HIDDEN,
			'default' => 'traditional',
		]);

		$this->add_control('icon', [
			'label'       => esc_html__('Icon', 'felan'),
			'type'        => Controls_Manager::ICONS,
			'separator'   => 'before',
			'default'     => [
				'value'   => 'fas fa-plus-circle',
				'library' => 'fa-solid',
			],
			'recommended' => [
				'fa-solid'   => [
					'plus',
					'plus-square',
					'folder-plus',
					'cart-plus',
					'calendar-plus',
					'search-plus',
				],
				'fa-regular' => [
					'plus-square',
					'plus-circle',
					'calendar-plus',
				],
			],
			'skin'        => 'inline',
			'label_block' => false,
		]);

		$this->add_control('active_icon', [
			'label'       => esc_html__('Active Icon', 'felan'),
			'type'        => Controls_Manager::ICONS,
			'default'     => [
				'value'   => 'fas fa-minus-circle',
				'library' => 'fa-solid',
			],
			'recommended' => [
				'fa-solid'   => [
					'minus',
					'minus-circle',
					'minus-square',
					'folder-minus',
					'calendar-minus',
					'search-minus',
				],
				'fa-regular' => [
					'minus-square',
					'calendar-minus',
				],
			],
			'skin'        => 'inline',
			'label_block' => false,
			'condition'   => [
				'icon[value]!' => '',
			],
		]);

		$this->add_control('title_html_tag', [
			'label'     => esc_html__('Title HTML Tag', 'felan'),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				'h1'  => 'H1',
				'h2'  => 'H2',
				'h3'  => 'H3',
				'h4'  => 'H4',
				'h5'  => 'H5',
				'h6'  => 'H6',
				'div' => 'div',
			],
			'default'   => 'h6',
			'separator' => 'before',
		]);

		$this->end_controls_section();
	}

	private function add_styling_section()
	{
		$this->start_controls_section('style_section', [
			'label' => esc_html__('Style', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'heading_typography',
			'label'    => esc_html__('Heading Typography', 'felan'),
			'selector' => '{{WRAPPER}} .accordion-heading',
		]);

		$this->add_control('border_color', [
			'label'     => esc_html__('Border Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .accordion-section, {{WRAPPER}} .accordion-header, {{WRAPPER}} .accordion-content' => 'border-color: {{VALUE}};',
			],
		]);

		$this->add_control(
			'thumbnail_size',
			[
				'label' => esc_html__('Image Size', 'felan'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('Example: 300x300', 'felan'),
				'default' => '570x570',
			]
		);

		$this->add_control('thumbnail_border_radius', [
			'label' => esc_html__('Image Border Radius', 'felan'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'selectors' => [
				'{{WRAPPER}} .right img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();
	}

	private function add_title_style_section()
	{
		$this->start_controls_section('title_style_section', [
			'label' => esc_html__('Title', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'label'    => esc_html__('Typography', 'felan'),
			'selector' => '{{WRAPPER}} .accordion-title',
		]);

		$this->start_controls_tabs('title_style_tabs');

		$this->start_controls_tab('title_style_normal_tab', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'text',
			'selector' => '{{WRAPPER}} .accordion-title',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('title_style_hover_tab', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Text_Gradient::get_type(), [
			'name'     => 'hover_text',
			'selector' => '{{WRAPPER}} .accordion-section.active .accordion-title, {{WRAPPER}} .accordion-header:hover .accordion-title',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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

		$this->add_control('icon_align', [
			'label'   => esc_html__('Alignment', 'felan'),
			'type'    => Controls_Manager::CHOOSE,
			'options' => [
				'left'  => [
					'title' => esc_html__('Start', 'felan'),
					'icon'  => 'eicon-h-align-left',
				],
				'right' => [
					'title' => esc_html__('End', 'felan'),
					'icon'  => 'eicon-h-align-right',
				],
			],
			'default' => 'right',
			'toggle'  => false,
		]);

		$this->start_controls_tabs('icon_color_tabs');

		$this->start_controls_tab('icon_color_tab', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_control('icon_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .opened-icon' => 'color: {{VALUE}};',
			],
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('icon_active_color_tab', [
			'label' => esc_html__('Active', 'felan'),
		]);

		$this->add_control('icon_active_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .accordion-header:hover .opened-icon, {{WRAPPER}} .closed-icon' => 'color: {{VALUE}};',
			],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control('icon_size', [
			'label'     => esc_html__('Size', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 3,
					'max' => 20,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .felan-accordion .accordion-icons' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]);

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
				'body:not(.rtl) {{WRAPPER}} .felan-accordion.felan-accordion-icon-right .accordion-icons' => 'margin: 0 0 0 {{SIZE}}{{UNIT}};',
				'body:not(.rtl) {{WRAPPER}} .felan-accordion.felan-accordion-icon-left .accordion-icons'  => 'margin: 0 {{SIZE}}{{UNIT}} 0 0;',
				'body.rtl {{WRAPPER}} .felan-accordion.felan-accordion-icon-right .accordion-icons'       => 'margin: 0 {{SIZE}}{{UNIT}} 0 0;',
				'body.rtl {{WRAPPER}} .felan-accordion.felan-accordion-icon-left .accordion-icons'        => 'margin: 0 0 0 {{SIZE}}{{UNIT}};',
			],
		]);

		$this->end_controls_section();
	}

	private function add_content_style_section()
	{
		$this->start_controls_section('content_style_section', [
			'label' => esc_html__('Content', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control('content_padding', [
			'label'      => esc_html__('Padding', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%', 'em'],
			'selectors'  => [
				'{{WRAPPER}} .accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'content_typography',
			'label'    => esc_html__('Typography', 'felan'),
			'selector' => '{{WRAPPER}} .accordion-content',
		]);

		$this->add_control('content_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .accordion-content' => 'color: {{VALUE}};',
			],
		]);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		// Do nothing if there is not any items.
		if (empty($settings['items']) || count($settings['items']) <= 0) {
			return;
		}

		$this->add_render_attribute('wrapper', 'class', 'felan-accordion-image');

		if ('toggle' === $settings['type']) {
			$this->add_render_attribute('wrapper', 'data-multi-open', '1');
		}

		$has_icon = !empty($settings['icon']['value']) ? true : false;

		if ($has_icon) {
			$this->add_render_attribute('wrapper', 'class', 'felan-accordion-icon-' . $settings['icon_align']);
		}

		$thumbnail_size = $settings['thumbnail_size'];
		$width = $height = '';
		if (!empty($thumbnail_size)) {
			if (preg_match('/\d+x\d+/', $thumbnail_size)) {
				$thumbnail_size = explode('x', $thumbnail_size);
				$width = $thumbnail_size[0];
				$height = $thumbnail_size[1];
			}
		}
?>
		<div class="flex <?php echo 'layout-' . $settings['style']; ?>">
			<div class="left">
				<?php
				if ($settings['heading']) {
				?>
					<h2 class="accordion-heading"><?php echo esc_html($settings['heading']); ?></h2>
				<?php
				}
				?>
				<div <?php $this->print_attributes_string('wrapper'); ?>>
					<?php
					$loop_count = 0;
					foreach ($settings['items'] as $key => $item) {
						if (empty($item['title']) || empty($item['content'])) {
							continue;
						}

						$loop_count++;
						$item_key = 'item_' . $item['_id'];
						$this->add_render_attribute($item_key, 'class', 'accordion-section');
					?>
						<div <?php $this->print_attributes_string($item_key); ?>>
							<div class="accordion-header">
								<div class="accordion-title-wrapper">
									<?php printf('<%1$s class="accordion-title">%2$s</%1$s>', $settings['title_html_tag'], esc_html($item['title'])); ?>
								</div>
								<?php if ($has_icon) : ?>
									<div class="accordion-icons">
										<span class="accordion-icon opened-icon"><?php Icons_Manager::render_icon($settings['icon']); ?></span>
										<span class="accordion-icon closed-icon"><?php Icons_Manager::render_icon($settings['active_icon']); ?></span>
									</div>
								<?php endif; ?>
							</div>
							<div class="accordion-content">
								<?php echo '' . $this->parse_text_editor($item['content']); ?>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php
				if ($settings['button'] && $settings['button_link']['url'] && $settings['button_title']) {
				?>
					<a class="felan-button" href="<?php echo esc_attr($settings['button_link']['url']); ?>"><?php echo esc_html($settings['button_title']); ?></a>
				<?php
				}
				?>
			</div>
			<div class="right">
				<?php
				if ($settings['items']) {
					foreach ($settings['items'] as $key => $item) {
						if ($item['image']) {
							$image_src = $item['image']['url'];
							echo '<img src="' . $image_src . '" alt="">';
						}
					}
				}
				?>
			</div>
		</div>
<?php
	}
}
