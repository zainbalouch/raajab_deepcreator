<?php

$section = 'footer';

$default = felan_get_default_theme_options();

// Footer
Felan_Kirki::add_section($section, array(
	'title'    => esc_html__('Footer', 'felan'),
	'priority' => 50,
));

Felan_Kirki::add_field('theme', [
	'type'            => 'notice',
	'settings'        => 'footer_customize',
	'label'           => esc_html__('Footer Customize', 'felan'),
	'section'         => $section,
	'partial_refresh' => [
		'header_type' => [
			'selector'        => 'footer.site-footer',
			'render_callback' => 'wp_get_document_title',
		],
	],
]);

Felan_Kirki::add_field('theme', [
	'type'     => 'select',
	'settings' => 'footer_type',
	'label'    => esc_html__('Footer Default', 'felan'),
	'section'  => $section,
	'default'  => $default['footer_type'],
	'choices'  => felan_get_footer_elementor(),
]);

Felan_Kirki::add_field('theme', [
	'type'     => 'text',
	'settings' => 'footer_copyright_text',
	'label'    => esc_html__('Copyright', 'felan'),
	'section'  => $section,
	'default'  => $default['footer_copyright_text'],
]);
