<?php

/**
 * The Template for displaying jobs archives
 */

defined('ABSPATH') || exit;

get_header('felan');

$jobs_map_postion = $map_event = '';
$content_jobs = felan_get_option('archive_jobs_layout', 'layout-list');
$content_jobs = !empty($_GET['layout']) ? Felan_Helper::felan_clean(wp_unslash($_GET['layout'])) : $content_jobs;
$enable_jobs_show_map = felan_get_option('enable_jobs_show_map', 1);
$enable_jobs_show_map = !empty($_GET['has_map']) ? Felan_Helper::felan_clean(wp_unslash($_GET['has_map'])) : $enable_jobs_show_map;

if ($enable_jobs_show_map == 1) {
    $archive_jobs_filter = 'filter-canvas';
    $jobs_map_postion = felan_get_option('jobs_map_postion');
    $jobs_map_postion = !empty($_GET['map']) ? Felan_Helper::felan_clean(wp_unslash($_GET['map'])) : $jobs_map_postion;
    if ($jobs_map_postion == 'map-right') {
        $map_event = 'map-event';
    }
} else if ($content_jobs == 'layout-full') {
    $archive_jobs_filter = 'filter-canvas';
} else {
    $archive_jobs_filter = felan_get_option('jobs_filter_sidebar_option', 'filter-left');
};
$archive_jobs_filter = !empty($_GET['filter']) ? Felan_Helper::felan_clean(wp_unslash($_GET['filter'])) : $archive_jobs_filter;
$archive_classes = array('archive-layout', 'archive-jobs', $archive_jobs_filter, $map_event, $jobs_map_postion);
?>

<div class="<?php echo join(' ', $archive_classes); ?>">
    <?php felan_get_template('jobs/archive/layout/layout-default.php'); ?>
</div>
<?php
get_footer('felan');
