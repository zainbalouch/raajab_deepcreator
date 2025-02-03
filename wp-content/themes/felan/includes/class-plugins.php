<?php

// Exit if accessed directly.
if (!defined("ABSPATH")) {
	exit();
}

/**
 * Plugin installation and activation for WordPress themes
 *
 * @package Felan
 */
if (!class_exists("Felan_Register_Plugins")) {
	class Felan_Register_Plugins
	{
		public static $plugins;

		/**
		 * Felan_Register_Plugins constructor.
		 */
		public function __construct()
		{
			add_filter("felan_tgm_plugins", [$this, "plugin_list"]);
			add_action("tgmpa_register", [$this, "register_plugins"], 11, 1);
		}

		/**
		 * Register required plugins
		 *
		 * @return array
		 */
		public function plugin_list()
		{
			$plugins = [
				[
					"name" => "Felan Framework",
					"slug" => "felan-framework",
					"thumb" => FELAN_THEME_URI . '/assets/images/thumb-felan.png',
					"source" => "https://felan.ricetheme.com/wp-content/plugins/felan-framework.zip",
					"version" => "1.0.7",
					"required" => true,
					"force_activation" => false,
					"force_deactivation" => false,
					"external_url" => "",
				],

				[
					"name" => "Elementor",
					"slug" => "elementor",
					"thumb" => FELAN_THEME_URI . '/assets/images/thumb-elementor.png',
					"required" => true,
				],

				[
					"name" => "Contact Form 7",
					"slug" => "contact-form-7",
					"thumb" => FELAN_THEME_URI . '/assets/images/thumb-cf7.png',
					"required" => false,
				],

				[
					"name" => "Mailchimp For WP",
					"slug" => "mailchimp-for-wp",
					"thumb" => FELAN_THEME_URI . '/assets/images/thumb-mailchimp.png',
					"required" => false,
				],
			];

			return $plugins;
		}

		function register_plugins()
		{
			$plugins = [];
			$plugins = apply_filters("felan_tgm_plugins", $plugins);
			$config = [
				"id" => "tgmpa",
				// Unique ID for hashing notices for multiple instances of TGMPA.
				"default_path" => "",
				// Default absolute path to pre-packaged plugins.
				"menu" => "tgmpa-install-plugins",
				// Menu slug.
				"parent_slug" => "themes.php",
				// Parent menu slug.
				"capability" => "edit_theme_options",
				// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				"has_notices" => true,
				// Show admin notices or not.
				"dismissable" => true,
				// If false, a user cannot dismiss the nag message.
				"dismiss_msg" => "",
				// If 'dismissable' is false, this message will be output at top of nag.
				"is_automatic" => true,
				// Automatically activate plugins after installation or not.
				"message" => "",
				// Message to output right before the plugins table.
				"strings" => [
					"page_title" => esc_html__(
						"Install Required Plugins",
						"felan"
					),
					"menu_title" => esc_html__("Install Plugins", "felan"),
					"installing" => esc_html__("Installing Plugin: %s", "felan"),
					// %s = plugin name.
					"oops" => esc_html__(
						"Something went wrong with the plugin API.",
						"felan"
					),
					"notice_can_install_required" => _n_noop(
						'This theme requires the following plugin: %1$s.',
						'This theme requires the following plugins: %1$s.',
						"felan"
					),
					// %1$s = plugin name(s).
					"notice_can_install_recommended" => _n_noop(
						'This theme recommends the following plugin: %1$s.',
						'This theme recommends the following plugins: %1$s.',
						"felan"
					),
					// %1$s = plugin name(s).
					"notice_cannot_install" => _n_noop(
						'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
						'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
						"felan"
					),
					// %1$s = plugin name(s).
					"notice_ask_to_update" => _n_noop(
						'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
						'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
						"felan"
					),
					// %1$s = plugin name(s).
					"notice_ask_to_update_maybe" => _n_noop(
						'There is an update available for: %1$s.',
						'There are updates available for the following plugins: %1$s.',
						"felan"
					),
					// %1$s = plugin name(s).
					"notice_cannot_update" => _n_noop(
						'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
						'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
						"felan"
					),
					// %1$s = plugin name(s).
					"notice_can_activate_required" => _n_noop(
						'The following required plugin is currently inactive: %1$s.',
						'The following required plugins are currently inactive: %1$s.',
						"felan"
					),
					// %1$s = plugin name(s).
					"notice_can_activate_recommended" => _n_noop(
						'The following recommended plugin is currently inactive: %1$s.',
						'The following recommended plugins are currently inactive: %1$s.',
						"felan"
					),
					// %1$s = plugin name(s).
					"notice_cannot_activate" => _n_noop(
						'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
						'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
						"felan"
					),
					// %1$s = plugin name(s).
					"install_link" => _n_noop(
						"Begin installing plugin",
						"Begin installing plugins",
						"felan"
					),
					"update_link" => _n_noop(
						"Begin updating plugin",
						"Begin updating plugins",
						"felan"
					),
					"activate_link" => _n_noop(
						"Begin activating plugin",
						"Begin activating plugins",
						"felan"
					),
					"return" => esc_html__(
						"Return to Required Plugins Installer",
						"felan"
					),
					"plugin_activated" => esc_html__(
						"Plugin activated successfully.",
						"felan"
					),
					"activated_successfully" => esc_html__(
						"The following plugin was activated successfully:",
						"felan"
					),
					"plugin_already_active" => esc_html__(
						'No action taken. Plugin %1$s was already active.',
						"felan"
					),
					// %1$s = plugin name(s).
					"plugin_needs_higher_version" => esc_html__(
						"Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.",
						"felan"
					),
					// %1$s = plugin name(s).
					"complete" => esc_html__(
						'All plugins installed and activated successfully. %1$s',
						"felan"
					),
					// %s = dashboard link.
					"contact_admin" => esc_html__(
						"Please contact the administrator of this site for help.",
						"felan"
					),
					"nag_type" => "updated",
					// Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
				],
			];

			tgmpa($plugins, $config);
		}
	}

	new Felan_Register_Plugins();
}
