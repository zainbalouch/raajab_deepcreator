<?php
defined('ABSPATH') || exit;

if (!class_exists('Felan_Mega_Menu')) {
    class Felan_Mega_Menu
    {

        protected static $instance = null;

        static function instance()
        {
            if (null === self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function initialize()
        {
            add_action('init', array($this, 'register_mega_menu'));
            add_post_type_support('felan_mega_menu', 'elementor');
        }

        /**
         * Register Mega_Menu Post Type
         */
        function register_mega_menu()
        {

            $labels = array(
                'name'               => _x('Mega Menus', 'Post Type General Name', 'felan'),
                'singular_name'      => _x('Mega Menus', 'Post Type Singular Name', 'felan'),
                'menu_name'          => esc_html__('Mega Menu', 'felan'),
                'name_admin_bar'     => esc_html__('Mega Menu', 'felan'),
                'parent_item_colon'  => esc_html__('Parent Menu:', 'felan'),
                'all_items'          => esc_html__('Mega Menus', 'felan'),
                'add_new_item'       => esc_html__('Add New Menu', 'felan'),
                'add_new'            => esc_html__('Add New', 'felan'),
                'new_item'           => esc_html__('New Menu', 'felan'),
                'edit_item'          => esc_html__('Edit Menu', 'felan'),
                'update_item'        => esc_html__('Update Menu', 'felan'),
                'view_item'          => esc_html__('View Menu', 'felan'),
                'search_items'       => esc_html__('Search Menu', 'felan'),
                'not_found'          => esc_html__('Not found', 'felan'),
                'not_found_in_trash' => esc_html__('Not found in Trash', 'felan'),
            );

            $args = array(
                'label'       => esc_html__('Mega Menus', 'felan'),
                'description' => esc_html__('Mega Menus', 'felan'),
                'labels'      => $labels,
                'supports'    => array(
                    'title',
                    'editor',
                    'revisions',
                ),
                'hierarchical'        => false,
                'public'              => true,
                'menu_position'       => 14,
                'menu_icon'           => 'dashicons-menu-alt',
                'show_in_admin_bar'   => true,
                'show_in_nav_menus'   => true,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'rewrite'             => false,
                'capability_type'     => 'page',
                'publicly_queryable'  => true, // Enable TRUE for Elementor Editing
            );

            register_post_type('felan_mega_menu', $args);
        }
    }

    Felan_Mega_Menu::instance()->initialize();
}
