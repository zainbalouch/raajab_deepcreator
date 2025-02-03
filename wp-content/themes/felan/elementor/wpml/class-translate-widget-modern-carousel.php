<?php

namespace Felan_Elementor;

use WPML_Elementor_Module_With_Items;

defined('ABSPATH') || exit;

class Translate_Widget_Modern_Carousel extends WPML_Elementor_Module_With_Items
{

	/**
	 * Repeater field id
	 *
	 * @return string
	 */
	public function get_items_field()
	{
		return 'slides';
	}

	/**
	 * Repeater items field id
	 *
	 * @return array List inner fields translatable.
	 */
	public function get_fields()
	{
		return [
			'title',
			'tags',
			'description',
			'button_text',
			'link' => ['url'],
		];
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title($field)
	{
		switch ($field) {
			case 'title':
				return esc_html__('Modern Carousel: Slide Title', 'felan');

			case 'tags':
				return esc_html__('Modern Carousel: Slide Tags', 'felan');

			case 'description':
				return esc_html__('Modern Carousel: Slide Description', 'felan');

			case 'button_text':
				return esc_html__('Modern Carousel: Slide Button', 'felan');

			case 'url':
				return esc_html__('Modern Carousel: Slide Link', 'felan');

			default:
				return '';
		}
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_editor_type($field)
	{
		switch ($field) {
			case 'title':
			case 'button_text':
				return 'LINE';

			case 'tags':
			case 'description':
				return 'AREA';

			case 'url':
				return 'LINK';

			default:
				return '';
		}
	}
}
