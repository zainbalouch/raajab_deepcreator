<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!is_user_logged_in()) {
    felan_get_template('global/access-denied.php', array('type' => 'not_login'));
    return;
}
global $current_user;
$user_id = $current_user->ID;
$id = get_the_ID();
$project_id = isset($_GET['project_id']) ? felan_clean(wp_unslash($_GET['project_id'])) : '';
$applicants_id = isset($_GET['applicants_id']) ? felan_clean(wp_unslash($_GET['applicants_id'])) : '';
$pages = isset($_GET['pages']) ? felan_clean(wp_unslash($_GET['pages'])) : '';
$current_date = date('Y-m-d');
$felan_package = new Felan_Package();
$package_id = get_the_author_meta(FELAN_METABOX_PREFIX . 'package_id', $user_id);
$expired_date = $felan_package->get_expired_date($package_id, $user_id);
$paid_submission_type = felan_get_option('paid_submission_type', 'no');


if (!empty($project_id) && $pages == 'edit') {
    felan_get_template('project/edit.php');
} else {
    $posts_per_page = 10;
    wp_enqueue_script(FELAN_PLUGIN_PREFIX . 'my-project');
    wp_localize_script(
        FELAN_PLUGIN_PREFIX . 'my-project',
        'felan_project_dashboard_vars',
        array(
            'ajax_url'    => FELAN_AJAX_URL,
            'not_project'   => esc_html__('No project found', 'felan-framework'),
        )
    );
    $project_classes = array('felan-project', 'grid', 'columns-4');
    $tax_query = $meta_query = array();
    global $current_user;
    wp_get_current_user();
    $user_id = $current_user->ID;
    $felan_profile = new Felan_Profile();

    $args = array(
        'post_type'           => 'project',
        'post_status'         => array('publish', 'expired', 'pending', 'pause'),
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => $posts_per_page,
        'offset'              => (max(1, get_query_var('paged')) - 1) * $posts_per_page,
        'author'              => $user_id,
        'orderby'               => 'date',
    );
    $data = new WP_Query($args);
?>
    <?php if ($current_date >= $expired_date && $paid_submission_type == 'per_package') : ?>
        <p class="notice"><i class="far fa-exclamation-circle"></i>
            <?php esc_html_e("Package expired. Please select a new one.", 'felan-framework'); ?>
            <a href="<?php echo felan_get_permalink('package'); ?>">
                <?php esc_html_e('Add Package', 'felan-framework'); ?>
            </a>
        </p>
    <?php endif; ?>
    <div class="entry-my-page project-dashboard <?php if ($current_date >= $expired_date && $paid_submission_type == 'per_package') {
                                                    echo 'expired';
                                                } ?>"">
        <div class=" search-dashboard-warpper">
        <div class="search-left">
            <div class="select2-field">
                <select class="search-control felan-select2" name="project_status">
                    <option value=""><?php esc_html_e('All projects', 'felan-framework') ?></option>
                    <option value="publish"><?php esc_html_e('Opening', 'felan-framework') ?></option>
                    <option value="pause"><?php esc_html_e('Paused', 'felan-framework') ?></option>
                    <option value="expired"><?php esc_html_e('Closed', 'felan-framework') ?></option>
                    <option value="pending"><?php esc_html_e('Pending', 'felan-framework') ?></option>
                </select>
            </div>
            <div class="action-search">
                <input class="project-search-control" type="text" name="project_search" placeholder="<?php esc_attr_e('Search project title', 'felan-framework') ?>">
                <button class="btn-search">
                    <i class="far fa-search"></i>
                </button>
            </div>
        </div>
        <div class="search-right">
            <label class="text-sorting"><?php esc_html_e('Sort by', 'felan-framework') ?></label>
            <div class="select2-field">
                <select class="search-control action-sorting felan-select2" name="project_sort_by">
                    <option value="newest"><?php esc_html_e('Newest', 'felan-framework') ?></option>
                    <option value="oldest"><?php esc_html_e('Oldest', 'felan-framework') ?></option>
                    <option value="featured"><?php esc_html_e('Featured', 'felan-framework') ?></option>
                </select>
            </div>
        </div>
    </div>
    <?php if ($data->have_posts()) { ?>
        <div class="table-dashboard-wapper">
            <table class="table-dashboard" id="my-project">
                <thead>
                    <tr>
                        <th><?php esc_html_e('TITLE', 'felan-framework') ?></th>
                        <th><?php esc_html_e('POSTED', 'felan-framework') ?></th>
                        <th><?php esc_html_e('PRICE', 'felan-framework') ?></th>
                        <th><?php esc_html_e('STATUS', 'felan-framework') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $ids = $project_expires = array(); ?>
                    <?php while ($data->have_posts()) : $data->the_post(); ?>
                        <?php
                        $id = get_the_ID();
                        $ids[] = $id;
                        global $current_user;
                        wp_get_current_user();
                        $user_id = $current_user->ID;
                        $status = get_post_status($id);
                        $project_categories =  get_the_terms($id, 'project-categories');
                        $public_date = get_the_date('Y-m-d');
                        $current_date = date('Y-m-d');
                        $project_featured    = get_post_meta($id, FELAN_METABOX_PREFIX . 'project_featured', true);
                        $val_public_date = get_the_date(get_option('date_format'));
                        $thumbnail_id = get_post_thumbnail_id();
                        $thumbnail_url = !empty($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'full') : false;
                        $projects_budget_show = get_post_meta($id, FELAN_METABOX_PREFIX . 'project_budget_show', true);
                        ?>
                        <tr>
                            <td>
                                <div class="project-thumbnail-inner">
                                    <?php if ($thumbnail_url) : ?>
                                        <div class="project-thumbnail">
                                            <img src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title(); ?>">
                                        </div>
                                    <?php endif; ?>
                                    <div class="content-project">
                                        <h3 class="title-project-dashboard">
                                            <a href="<?php echo get_the_permalink($id); ?>" target="_blank">
                                                <?php echo get_the_title($id); ?>
                                                <?php if ($project_featured == '1') : ?>
                                                    <img src="<?php echo esc_attr(FELAN_PLUGIN_URL . 'assets/images/icon-featured.svg'); ?>" alt="<?php echo esc_attr('featured', 'felan-framework') ?>">
                                                <?php endif; ?>
                                            </a>
                                        </h3>
                                        <p>
                                            <span><?php echo esc_html__('in', 'felan-framework'); ?></span>
                                            <?php if (is_array($project_categories)) {
                                                foreach ($project_categories as $categories) {
                                                    $categories_link = get_term_link($categories, 'project-categories'); ?>
                                                    <a href="<?php echo esc_url($categories_link); ?>" class="cate">
                                                        <?php esc_html_e($categories->name); ?>
                                                    </a>
                                                <?php }
                                            } ?>
                                        </p>
                                    </div>
                                </div>
                                 <?php if (felan_total_applications_project_id($id) > 0) { ?>
                                     <a href="<?php echo esc_attr('#list-applicant-' . $id); ?>" class="project-number-applicant">
                                        <span class="number"><?php echo felan_total_applications_project_id($id); ?></span>
                                        <?php if (felan_total_applications_project_id($id) > 1) { ?>
                                            <span><?php echo esc_html__('Proposals', 'felan-framework') ?></span>
                                        <?php } else { ?>
                                            <span><?php echo esc_html__('Proposal', 'felan-framework') ?></span>
                                        <?php } ?>
                                         <i class="far fa-chevron-down"></i>
                                    </a>
                                 <?php } else { ?>
                                     <span class="project-number-applicant">
                                         <span class="number"><?php echo felan_total_applications_project_id($id); ?></span>
                                         <?php if (felan_total_applications_project_id($id) > 1) { ?>
                                             <span><?php echo esc_html__('Proposals', 'felan-framework') ?></span>
                                         <?php } else { ?>
                                             <span><?php echo esc_html__('Proposal', 'felan-framework') ?></span>
                                         <?php } ?>
                                     </span>
                                 <?php } ?>
                            </td>
                            <td>
                                <span class="start-time"><?php echo $val_public_date ?></span>
                            </td>
                            <td class="price">
                                <?php echo felan_get_budget_project($id); ?>
                                <p class="budget-show">
                                    <?php if($projects_budget_show == 'hourly') : ?>
                                        <?php echo esc_html__('Hourly Rate', 'felan-framework'); ?>
                                    <?php else: ?>
                                        <?php echo esc_html__('Fixed Price', 'felan-framework'); ?>
                                    <?php endif; ?>
                                </p>
                            </td>
                            <td>
                                <?php if ($status == 'expired') : ?>
                                    <span class="label label-close"><?php esc_html_e('Closed', 'felan-framework') ?></span>
                                <?php endif; ?>
                                <?php if ($status == 'publish') : ?>
                                    <span class="label label-open"><?php esc_html_e('Opening', 'felan-framework') ?></span>
                                <?php endif; ?>
                                <?php if ($status == 'pending') : ?>
                                    <span class="label label-pending"><?php esc_html_e('Pending', 'felan-framework') ?></span>
                                <?php endif; ?>
                                <?php if ($status == 'pause') : ?>
                                    <span class="label label-pause"><?php esc_html_e('Pause', 'felan-framework') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="action-setting project-control">
                                <?php if ($status !== 'expired') : ?>
                                    <a href="#" class="icon-setting"><i class="far fa-ellipsis-h"></i></a>
                                    <ul class="action-dropdown">
                                        <?php
                                        $project_dashboard_link = felan_get_permalink('project_dashboard');
                                        $paid_submission_type = felan_get_option('paid_submission_type', 'no');
                                        $check_package = $felan_profile->user_package_available($user_id);
                                        $package_num_featured_project = get_the_author_meta(FELAN_METABOX_PREFIX . 'package_number_project_featured', $user_id);
                                        $package_unlimited_featured_project = get_post_meta($package_id, FELAN_METABOX_PREFIX . 'package_unlimited_project_featured', true);
                                        $user_demo = get_the_author_meta(FELAN_METABOX_PREFIX . 'user_demo', $user_id);
                                        switch ($status) {
                                            case 'publish':
                                            if ($paid_submission_type == 'per_package') { ?>
                                                    <li><a class="btn-edit" href="<?php echo esc_url($project_dashboard_link); ?><?php echo strpos(esc_url($project_dashboard_link), '?') ? '&' : '?' ?>pages=edit&project_id=<?php echo esc_attr($id); ?>"><?php esc_html_e('Edit', 'felan-framework'); ?></a></li>
                                                    <?php if ($user_demo == 'yes') { ?>

                                                        <li><a class="btn-add-to-message" href="#" data-text="<?php echo esc_attr('Oops! Sorry. This action is restricted on the demo site.', 'felan-framework'); ?>"><?php esc_html_e('Paused', 'felan-framework'); ?></a></li>
                                                        <?php if ($project_featured != 1) { ?>
                                                            <li><a class="btn-add-to-message" href="#" data-text="<?php echo esc_attr('Oops! Sorry. This action is restricted on the demo site.', 'felan-framework'); ?>"><?php esc_html_e('Mark featured', 'felan-framework'); ?></a></li>
                                                        <?php } ?>
                                                        <li><a class="btn-add-to-message" href="#" data-text="<?php echo esc_attr('Oops! Sorry. This action is restricted on the demo site.', 'felan-framework'); ?>"><?php esc_html_e('Mark Filled', 'felan-framework'); ?></a></li>

                                                        <?php } else {

                                                        if ($check_package != -1 && $check_package != 0) { ?>
                                                            <li><a class="btn-pause" project-id="<?php echo esc_attr($id); ?>" href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('Paused', 'felan-framework') ?></a></li>
                                                        <?php }

                                                        if (($package_unlimited_featured_project == '1' || $package_num_featured_project > 0) && $project_featured != 1 && $check_package != -1  && $check_package != 0) { ?>
                                                            <li><a class="btn-mark-featured" project-id="<?php echo esc_attr($id); ?>" href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('Mark featured', 'felan-framework') ?></a></li>
                                                        <?php }

                                                        if ($check_package != -1 && $check_package != 0) { ?>
                                                            <li><a class="btn-mark-filled" project-id="<?php echo esc_attr($id); ?>" href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('Mark Filled', 'felan-framework') ?></a></li>
                                                        <?php }
                                                    }

                                                    if ($check_package != -1 && $check_package != 0) { ?>
                                                        <li><a href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('View detail', 'felan-framework') ?></a></li>
                                                    <?php }
                                                } else { ?>
                                                    <li><a class="btn-edit" href="<?php echo esc_url($project_dashboard_link); ?>?pages=edit&project_id=<?php echo esc_attr($id); ?>"><?php esc_html_e('Edit', 'felan-framework'); ?></a></li>

                                                    <?php if ($user_demo == 'yes') { ?>
                                                        <li><a class="btn-add-to-message" href="#" data-text="<?php echo esc_attr('Oops! Sorry. This action is restricted on the demo site.', 'felan-framework'); ?>"><?php esc_html_e('Paused', 'felan-framework'); ?></a></li>
                                                        <?php if ($project_featured != 1) { ?>
                                                            <li><a class="btn-add-to-message" href="#" data-text="<?php echo esc_attr('Oops! Sorry. This action is restricted on the demo site.', 'felan-framework'); ?>"><?php esc_html_e('Mark featured', 'felan-framework'); ?></a></li>
                                                        <?php } ?>
                                                        <li><a class="btn-add-to-message" href="#" data-text="<?php echo esc_attr('Oops! Sorry. This action is restricted on the demo site.', 'felan-framework'); ?>"><?php esc_html_e('Mark Filled', 'felan-framework'); ?></a></li>
                                                    <?php } else { ?>
                                                        <li><a class="btn-pause" project-id="<?php echo esc_attr($id); ?>" href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('Paused', 'felan-framework') ?></a></li>
                                                        <?php if ($project_featured != 1) { ?>
                                                            <li><a class="btn-mark-featured" project-id="<?php echo esc_attr($id); ?>" href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('Mark featured', 'felan-framework') ?></a></li>
                                                        <?php } ?>
                                                        <li><a class="btn-mark-filled" project-id="<?php echo esc_attr($id); ?>" href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('Mark Filled', 'felan-framework') ?></a></li>
                                                    <?php } ?>

                                                    <li><a href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('View detail', 'felan-framework') ?></a></li>
                                                <?php }
                                                break;
                                            case 'pending': ?>
                                                <li><a class="btn-edit" href="<?php echo esc_url($project_dashboard_link); ?>?pages=edit&project_id=<?php echo esc_attr($id); ?>"><?php esc_html_e('Edit', 'felan-framework'); ?></a></li>
                                            <?php
                                                break;
                                            case 'pause':
                                            ?>
                                                <li><a class="btn-edit" href="<?php echo esc_url($project_dashboard_link); ?>?pages=edit&project_id=<?php echo esc_attr($id); ?>"><?php esc_html_e('Edit', 'felan-framework'); ?></a></li>
                                                <li><a class="btn-show" project-id="<?php echo esc_attr($id); ?>" href="<?php echo get_the_permalink($id); ?>"><?php esc_html_e('Continue', 'felan-framework'); ?></a>
                                            <?php
                                        } ?>
                                    </ul>
                                <?php else : ?>
                                    <a href="#" class="icon-setting btn-add-to-message" data-text="<?php echo esc_attr('Project has expired so you can not change it', 'felan-framework'); ?>"><i class="far fa-ellipsis-h"></i></a></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $args_applicants = array(
                            'post_type' => 'project-proposal',
                            'ignore_sticky_posts' => 1,
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => FELAN_METABOX_PREFIX . 'proposal_project_id',
                                    'value' => $id,
                                    'compare' => '='
                                )
                            ),
                        );
                        $data_applicants = new WP_Query($args_applicants);
                        if ($data_applicants->have_posts()) { ?>
                        <tr class="project-list-applicant" id="list-applicant-<?php echo esc_attr($id); ?>">
                            <td colspan="5" style="padding: 24px">
                                <div class="project-applicants custom-scrollbar">
                                     <?php while ($data_applicants->have_posts()) : $data_applicants->the_post();
                                     $applicants_id = get_the_ID();
                                     $author_id = get_post_field('post_author', $applicants_id);
                                     $project_dashboard_link = felan_get_permalink('project_dashboard');
                                     $freelancer_id = '';
                                     if (!empty($author_id)) {
                                         $args_freelancer = array(
                                             'post_type' => 'freelancer',
                                             'posts_per_page' => 1,
                                             'author' => $author_id,
                                         );
                                         $current_user_posts = get_posts($args_freelancer);
                                         $freelancer_id = !empty($current_user_posts) ? $current_user_posts[0]->ID : '';
                                         $freelancer_avatar = get_the_author_meta('author_avatar_image_url', $author_id);
                                     }
                                     $has_freelancer_review = get_post_meta($freelancer_id, FELAN_METABOX_PREFIX . 'has_freelancer_review', true);

                                     $proposal_status = get_post_meta($applicants_id, FELAN_METABOX_PREFIX . 'proposal_status', true);
                                     $proposal_price = get_post_meta($applicants_id, FELAN_METABOX_PREFIX . 'proposal_price', true);
                                     $proposal_time = get_post_meta($applicants_id, FELAN_METABOX_PREFIX . 'proposal_time', true);
                                     $proposal_fixed_time = get_post_meta($applicants_id, FELAN_METABOX_PREFIX . 'proposal_fixed_time', true);
                                     $proposal_rate = get_post_meta($applicants_id, FELAN_METABOX_PREFIX . 'proposal_rate', true);
                                     $proposal_maximum_time = get_post_meta($applicants_id, FELAN_METABOX_PREFIX . 'proposal_maximum_time', true);
                                     $currency_sign_default = felan_get_option('currency_sign_default');
                                     $currency_position = felan_get_option('currency_position');
                                     if ($currency_position == 'before') {
                                         $proposal_total_price = $currency_sign_default . $proposal_price;
                                     } else {
                                         $proposal_total_price = $proposal_price . $currency_sign_default;
                                     }
                                     ?>
                                        <div class="row">
                                        <div class="col">
                                            <div class="info-user">
                                                <?php if (!empty($freelancer_avatar)) : ?>
                                                    <div class="image-applicants"><img class="image-freelancers" src="<?php echo esc_url($freelancer_avatar) ?>" alt="" /></div>
                                                <?php else : ?>
                                                    <div class="image-applicants"><i class="far fa-camera"></i></div>
                                                <?php endif; ?>
                                                <div class="info-details">
                                                    <h3>
                                                        <?php echo get_the_title($freelancer_id); ?>
                                                    </h3>
                                                    <?php echo felan_get_total_rating('freelancer', $freelancer_id); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p class="label-project"><?php echo esc_html__('Budget/Time','felan-framework') ?></p>
                                            <p>
                                                <?php if($projects_budget_show == 'hourly') : ?>
                                                    <?php echo sprintf(esc_html__('%1s / in %2s hours', 'felan-framework'),$proposal_total_price, $proposal_time) ?>
                                                <?php else: ?>
                                                    <?php echo sprintf(esc_html__('%1s / in %2s %3s ', 'felan-framework'),$proposal_total_price, $proposal_fixed_time, $proposal_rate) ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="col">
                                            <p class="label-project"><?php echo esc_html__('Dated','felan-framework') ?></p>
                                            <p><?php echo sprintf(esc_html__('%1s', 'felan-framework'), get_the_date(get_option('date_format'))) ?></p>
                                        </div>
                                        <div class="col">
                                            <p class="label-project"><?php echo esc_html__('Status','felan-framework') ?></p>
                                            <?php felan_project_package_status($proposal_status); ?>
                                        </div>
                                        <div class="col">
                                            <div class="button-warpper d-flex justify-content-end">
                                                <?php if($proposal_status == 'completed') : ?>
                                                    <?php if($has_freelancer_review == '1') : ?>
                                                        <div class="action-review mr-2">
                                                            <a href="#" class="btn-action-view felan-button button-outline-gray" freelancer-id="<?php echo esc_attr($freelancer_id); ?>">
                                                                <?php echo esc_html__('Your Review', 'felan-framework'); ?>
                                                            </a>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="action-review mr-2">
                                                            <a href="#" class="btn-action-review btn-review-project felan-button button-outline-gray"
                                                               freelancer-id="<?php echo esc_attr($freelancer_id); ?>"
                                                               order-id="<?php echo esc_attr($applicants_id); ?>">
                                                                <?php echo esc_html__('Review', 'felan-framework'); ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <a href="<?php echo esc_url($project_dashboard_link); ?>?applicants_id=<?php echo esc_attr($applicants_id); ?>&project_id=<?php echo esc_attr($id); ?>" class="felan-button"><?php echo esc_html__('Detail','felan-framework') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                 </div>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="felan-loading-effect"><span class="felan-dual-ring"></span></div>
        </div>
    <?php } else { ?>
        <div class="item-not-found"><?php esc_html_e('No item found', 'felan-framework'); ?></div>
    <?php } ?>
    <?php $max_num_pages = $data->max_num_pages;
    $total_post = $data->found_posts;
    if ($total_post > $posts_per_page) { ?>
        <div class="pagination-dashboard">
            <?php felan_get_template('global/pagination.php', array('total_post' => $total_post, 'max_num_pages' => $max_num_pages, 'type' => 'dashboard', 'layout' => 'number'));
            wp_reset_postdata(); ?>
        </div>
    <?php } ?>
    </div>
<?php } ?>