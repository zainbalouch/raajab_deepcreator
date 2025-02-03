<?php

namespace Felan_Elementor;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

defined('ABSPATH') || exit;

class Widget_Image_Box extends Base
{

	public function get_name()
	{
		return 'felan-image-box';
	}

	public function get_title()
	{
		return esc_html__('Image Box', 'felan');
	}

	public function get_icon_part()
	{
		return 'eicon-image-box';
	}

	public function get_keywords()
	{
		return ['image', 'photo', 'visual', 'box'];
	}

	public function get_style_depends()
	{
		return ['felan-el-widget-image-box'];
	}

	protected function register_controls()
	{
		$this->add_image_box_section();

		$this->add_box_style_section();

		$this->add_image_style_section();

		$this->add_content_style_section();

		$this->register_common_button_style_section();
	}

	private function add_image_box_section()
	{
		$this->start_controls_section('image_section', [
			'label' => esc_html__('Image Box', 'felan'),
		]);

		$this->add_control('style', [
			'label'   => esc_html__('Style', 'felan'),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				''   => esc_html__('None', 'felan'),
				'01' => '01',
				'02' => '02',
			],
			'default' => '01',
		]);

		$this->add_control('hover_effect', [
			'label'        => esc_html__('Hover Effect', 'felan'),
			'type'         => Controls_Manager::SELECT,
			'options'      => [
				''         => esc_html__('None', 'felan'),
				'zoom-in'  => esc_html__('Zoom In', 'felan'),
				'zoom-out' => esc_html__('Zoom Out', 'felan'),
				'move-up'  => esc_html__('Move Up', 'felan'),
			],
			'default'      => '',
			'prefix_class' => 'felan-animation-',
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

		$this->add_control('image_heading', [
			'label'     => esc_html__('Image', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_control('image', [
			'label'   => esc_html__('Choose Image', 'felan'),
			'type'    => Controls_Manager::MEDIA,
			'dynamic' => [
				'active' => true,
			],
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		]);

		$this->add_group_control(Group_Control_Image_Size::get_type(), [
			'name'      => 'image',
			// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
			'default'   => 'full',
			'separator' => 'none',
			'condition' => [
				'image[url]!' => '',
			],
		]);

		$this->add_control('image_position', [
			'label'     => esc_html__('Image Position', 'felan'),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'top',
			'options'   => [
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
			'toggle'    => false,
			'condition' => [
				'image[url]!' => '',
			],
		]);

		$this->add_control('content_vertical_alignment', [
			'label'     => esc_html__('Vertical Alignment', 'felan'),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => Widget_Utils::get_control_options_vertical_alignment(),
			'default'   => 'top',
			'condition' => [
				'image[url]!'     => '',
				'image_position!' => 'top',
			],
		]);

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

		$this->add_control('description_heading', [
			'label'     => esc_html__('Description', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_control('description_text', [
			'label'       => esc_html__('Text', 'felan'),
			'type'        => Controls_Manager::WYSIWYG,
			'dynamic'     => [
				'active' => true,
			],
			'default'     => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'felan'),
			'placeholder' => esc_html__('Enter your description', 'felan'),
			'separator'   => 'none',
			'rows'        => 10,
			'label_block' => true,
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
					'default' => 'text',
				],
			],
		]);

		$this->add_control('view', [
			'label'   => esc_html__('View', 'felan'),
			'type'    => Controls_Manager::HIDDEN,
			'default' => 'traditional',
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
				'{{WRAPPER}} .felan-box' => 'text-align: {{VALUE}};',
			],
		]);

		$this->add_responsive_control('box_padding', [
			'label'      => esc_html__('Padding', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%', 'em'],
			'selectors'  => [
				'{{WRAPPER}} .felan-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'{{WRAPPER}} .felan-box' => 'max-width: {{SIZE}}{{UNIT}};',
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
			'selector' => '{{WRAPPER}} .felan-box',
		]);

		$this->add_group_control(Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .felan-box',
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .felan-box',
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('box_colors_hover', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .felan-box:before',
		]);

		$this->add_group_control(Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_hover_border',
			'selector' => '{{WRAPPER}} .felan-box:hover',
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .felan-box:hover',
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_image_style_section()
	{
		$this->start_controls_section('image_style_section', [
			'label' => esc_html__('Image', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control('image_wrap_height', [
			'label'     => esc_html__('Wrap Height', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .felan-image' => 'height: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('image_space_top', [
			'label'     => esc_html__('Offset Top', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .image' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('image_space', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .image-position-right .image' => 'margin-left: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .image-position-left .image'  => 'margin-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .image-position-top .image'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
				'(mobile){{WRAPPER}} .image'               => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('image_width', [
			'label'          => esc_html__('Width', 'felan'),
			'type'           => Controls_Manager::SLIDER,
			'default'        => [
				'unit' => '%',
			],
			'tablet_default' => [
				'unit' => '%',
			],
			'mobile_default' => [
				'unit' => '%',
			],
			'size_units'     => ['%', 'px'],
			'range'          => [
				'%'  => [
					'min' => 5,
					'max' => 50,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'      => [
				'{{WRAPPER}} .image' => 'width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('image_border_radius', [
			'label'      => esc_html__('Border Radius', 'felan'),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', '%'],
			'selectors'  => [
				'{{WRAPPER}} .image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->start_controls_tabs('image_effects');

		$this->start_controls_tab('normal', [
			'label' => esc_html__('Normal', 'felan'),
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'image_shadow',
			'selector' => '{{WRAPPER}} .image img',
		]);

		$this->add_group_control(Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters',
			'selector' => '{{WRAPPER}} .image img',
		]);

		$this->add_control('image_opacity', [
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
				'{{WRAPPER}} .image img' => 'opacity: {{SIZE}};',
			],
		]);

		$this->end_controls_tab();

		$this->start_controls_tab('hover', [
			'label' => esc_html__('Hover', 'felan'),
		]);

		$this->add_group_control(Group_Control_Box_Shadow::get_type(), [
			'name'     => 'image_shadow_hover',
			'selector' => '{{WRAPPER}}:hover .image img',
		]);

		$this->add_group_control(Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters_hover',
			'selector' => '{{WRAPPER}}:hover .image img',
		]);

		$this->add_control('image_opacity_hover', [
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
				'{{WRAPPER}}:hover .image img' => 'opacity: {{SIZE}};',
			],
		]);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_content_style_section()
	{
		$this->start_controls_section('content_style_section', [
			'label' => esc_html__('Content', 'felan'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control('heading_title', [
			'label'     => esc_html__('Title', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_control('title_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .title' => 'color: {{VALUE}};',
			],
            'global' => ['default' =>  Global_Colors::COLOR_PRIMARY],
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .title',
            'global' => ['default' =>  Global_Typography::TYPOGRAPHY_ACCENT],
		]);

		$this->add_control('heading_description', [
			'label'     => esc_html__('Description', 'felan'),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		]);

		$this->add_responsive_control('description_top_space', [
			'label'     => esc_html__('Spacing', 'felan'),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .description' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('description_color', [
			'label'     => esc_html__('Color', 'felan'),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .description' => 'color: {{VALUE}};',
			],
            'global' => ['default' =>  Global_Colors::COLOR_TEXT],
        ]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name'     => 'description_typography',
			'selector' => '{{WRAPPER}} .description',
			'global' => ['default' =>  Global_Typography::TYPOGRAPHY_TEXT],
		]);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('wrapper', 'class', 'felan-image-box felan-box');
		$this->add_render_attribute('wrapper', 'class', 'style-' . $settings['style']);
		$this->add_render_attribute('wrapper', 'class', 'image-position-' . $settings['image_position']);
		$this->add_render_attribute('wrapper', 'class', 'content-alignment-' . $settings['content_vertical_alignment']);

		$box_tag = 'div';
		if (!empty($settings['link']['url']) && 'box' === $settings['link_click']) {
			$box_tag = 'a';
			$this->add_render_attribute('wrapper', 'class', 'link-secret');
			$this->add_link_attributes('wrapper', $settings['link']);
		}
?>
		<?php printf('<%1$s %2$s>', $box_tag, $this->get_render_attribute_string('wrapper')); ?>
		<div class="content-wrap">

			<?php if (!empty($settings['image']['url'])) : ?>
				<div class="felan-image image">
					<?php echo \Felan_Image::get_elementor_attachment([
						'settings' => $settings,
					]); ?>
				</div>
			<?php endif; ?>

			<div class="content">
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
		// @formatter:off
	?>
		<# view.addRenderAttribute( 'wrapper' , 'class' , 'felan-image-box felan-box' ); view.addRenderAttribute( 'wrapper' , 'class' , 'style-' + settings.style ); view.addRenderAttribute( 'wrapper' , 'class' , 'image-position-' + settings.image_position ); view.addRenderAttribute( 'wrapper' , 'class' , 'content-alignment-' + settings.content_vertical_alignment ); var boxTag='div' ; if( '' !==settings.link.url && 'box'===settings.link_click ) { boxTag='a' ; view.addRenderAttribute( 'wrapper' , 'href' , '#' ); view.addRenderAttribute( 'wrapper' , 'class' , 'link-secret' ); } var imageHTML='' ; if ( settings.image.url ) { var image={ id: settings.image.id, url: settings.image.url, size: settings.image_size, dimension: settings.image_custom_dimension, model: view.getEditModel() }; var image_url=elementor.imagesManager.getImageUrl( image ); view.addRenderAttribute( 'image' , 'src' , image_url ); imageHTML='<div class="felan-image image"><img ' + view.getRenderAttributeString( 'image' ) + ' /></div>' ; } #>
			<{{{ boxTag }}} {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
				<div class="content-wrap">
					{{{ imageHTML }}}

					<div class="content">

						<# if ( settings.title_text ) { #>
							<# view.addRenderAttribute( 'title_text' , 'class' , 'title' ); view.addInlineEditingAttributes( 'title_text' , 'none' ); #>
								<{{{ settings.title_size }}} {{{ view.getRenderAttributeString( 'title_text' ) }}}>{{{ settings.title_text }}}</{{{ settings.title_size }}}>
								<# } #>

									<# if ( settings.description_text ) { #>
										<# view.addRenderAttribute( 'description_text' , 'class' , 'description' ); view.addInlineEditingAttributes( 'description_text' ); #>
											<div {{{ view.getRenderAttributeString( 'description_text' ) }}}>{{{ settings.description_text }}}</div>
											<# } #>

												<# if ( settings.button_text || settings.button_icon.value ) { #>
													<# var buttonIconHTML=elementor.helpers.renderIcon( view, settings.button_icon, { 'aria-hidden' : true }, 'i' , 'object' ); var buttonTag='div' ; view.addRenderAttribute( 'button' , 'class' , 'felan-button button-' + settings.button_style ); view.addRenderAttribute( 'button' , 'class' , 'felan-button-' + settings.button_size ); if ( '' !==settings.link.url && 'button'===settings.link_click ) { buttonTag='a' ; view.addRenderAttribute( 'button' , 'href' , '#' ); } if ( settings.button_icon.value ) { view.addRenderAttribute( 'button' , 'class' , 'icon-' + settings.button_icon_align ); } view.addRenderAttribute( 'button-icon' , 'class' , 'button-icon' ); #>
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
			</{{{ boxTag }}}>
		<?php
		// @formatter:off
	}

	private function print_title(array $settings)
	{
		if (empty($settings['title_text'])) {
			return;
		}

		$this->add_render_attribute('title_text', 'class', 'title');

		$this->add_inline_editing_attributes('title_text', 'none');

		$title_html = $settings['title_text'];

		printf('<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string('title_text'), $title_html);
	}

	private function print_description(array $settings)
	{
		if (empty($settings['description_text'])) {
			return;
		}

		$this->add_render_attribute('description_text', 'class', 'description');
		$this->add_inline_editing_attributes('description_text');
		?>
			<div <?php $this->print_render_attribute_string('description_text'); ?>>
				<?php echo wp_kses_post($settings['description_text']); ?>
			</div>
	<?php
	}
}
