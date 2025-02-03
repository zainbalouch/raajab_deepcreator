<?php

/**l
 * The template for displaying Dashboard pages
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php
    $enable_rtl_mode = felan_get_option("enable_rtl_mode");
    if (is_rtl() || $enable_rtl_mode) {
        wp_enqueue_style(FELAN_PLUGIN_PREFIX . '-dashboard-rtl', FELAN_PLUGIN_URL . 'assets/css/rtl/_dashboard-rtl.min.css', array(), FELAN_PLUGIN_VER, 'all');
    } else {
        wp_enqueue_style(FELAN_PLUGIN_PREFIX . 'dashboard');
    }
    wp_dequeue_style('elementor-frontend');
    ?>

    <?php wp_head(); ?>
</head>
<?php
$dir = '';
$enable_rtl_mode = felan_get_option('enable_rtl_mode', 0);
if (is_rtl() || $enable_rtl_mode) {
    $dir = 'dir=rtl';
}
?>

<body <?php body_class() ?> <?php echo esc_attr($dir); ?>>
    <?php wp_body_open(); ?>
    <?php
    $layout_content = Felan_Helper::get_setting('layout_content');
    $header_classes = array();
    ?>

    <div id="wrapper" class="page-dashboard <?php echo esc_attr($layout_content); ?>">
        <?php global $current_user;
        if (in_array('felan_user_freelancer', (array)$current_user->roles)) {
            felan_get_template('dashboard/freelancer/nav.php');
        } else {
            felan_get_template('dashboard/employer/nav.php');
        } ?>
        <div id="felan-content-dashboard">
            <?php get_header(); ?>
            <div id="main" class="site-main">
                <?php
                // Start the loop.
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </div>
        <?php wp_footer(); ?>
</body>

</html>