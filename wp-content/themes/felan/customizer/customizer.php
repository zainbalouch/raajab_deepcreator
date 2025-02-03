<?php

/**
 * Theme Customizer
 */

Felan_Kirki::add_config('theme', array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
));

/**
 * Load Functions
 */
require_once FELAN_CUSTOMIZER_DIR . '/settings/defaults.php';

require_once FELAN_CUSTOMIZER_DIR . '/settings/functions.php';

require_once FELAN_CUSTOMIZER_DIR . '/settings/stylesheets.php';

/**
 * Load panel & section files
 */
// Panel General
require_once FELAN_CUSTOMIZER_DIR . '/options/general.php';

// Section Typography
require_once FELAN_CUSTOMIZER_DIR . '/options/typography.php';

// Section Color
require_once FELAN_CUSTOMIZER_DIR . '/options/color.php';

// Section Layout
require_once FELAN_CUSTOMIZER_DIR . '/options/layout.php';

// Section Top Bar
require_once FELAN_CUSTOMIZER_DIR . '/options/top-bar.php';

// Section Header
require_once FELAN_CUSTOMIZER_DIR . '/options/header.php';

// Section Footer
require_once FELAN_CUSTOMIZER_DIR . '/options/footer.php';

// Panel Blog
require_once FELAN_CUSTOMIZER_DIR . '/options/blog.php';

// Page 404
require_once FELAN_CUSTOMIZER_DIR . '/options/404.php';
