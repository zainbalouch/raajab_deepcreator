<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Felan_Jobs')) {
    /**
     * Class Felan_Jobs
     */
    class Felan_Jobs
    {
        /**
         * view date
         */
        public function felan_set_jobs_view_date()
        {
            $jobs_id = get_the_ID();
            $today = date('Y-m-d', time());
            $views_date = get_post_meta($jobs_id, 'felan_view_by_date', true);
            if ($views_date != '' || is_array($views_date)) {
                if (!isset($views_date[$today])) {
                    if (count($views_date) > 60) {
                        array_shift($views_date);
                    }
                    $views_date[$today] = 1;
                } else {
                    $views_date[$today] = intval($views_date[$today]) + 1;
                }
            } else {
                $views_date = array();
                $views_date[$today] = 1;
            }
            update_post_meta($jobs_id, 'felan_view_by_date', $views_date);
        }

        /**
         * Jobs breadcrumb
         */
        public function felan_jobs_breadcrumb()
        { ?>
            <div class="container container-breadcrumb">
                <?php get_template_part('templates/global/breadcrumb'); ?>
            </div>
<?php }

        /**
         * Jobs submit
         */
        public function jobs_submit_ajax()
        {
            $jobs_form   = isset($_REQUEST['jobs_form']) ? felan_clean(wp_unslash($_REQUEST['jobs_form'])) : '';
            $jobs_action = isset($_REQUEST['jobs_action']) ? felan_clean(wp_unslash($_REQUEST['jobs_action'])) : '';
            $jobs_id                 = isset($_REQUEST['jobs_id']) ? felan_clean(wp_unslash($_REQUEST['jobs_id'])) : '';
            $jobs_title              = isset($_REQUEST['jobs_title']) ? felan_clean(wp_unslash($_REQUEST['jobs_title'])) : '';
            $jobs_type       = isset($_REQUEST['jobs_type']) ? felan_clean(wp_unslash($_REQUEST['jobs_type'])) : '';
            $jobs_skills        = isset($_REQUEST['jobs_skills']) ? felan_clean(wp_unslash($_REQUEST['jobs_skills'])) : '';
            $jobs_categories         = isset($_REQUEST['jobs_categories']) ? felan_clean(wp_unslash($_REQUEST['jobs_categories'])) : '';
            $jobs_new_categories         = isset($_REQUEST['jobs_new_categories']) ? felan_clean(wp_unslash($_REQUEST['jobs_new_categories'])) : '';
            $jobs_des       = isset($_REQUEST['jobs_des']) ?  wp_kses_post(wp_unslash($_REQUEST['jobs_des'])) : '';
            $jobs_location      = isset($_REQUEST['jobs_location']) ? felan_clean(wp_unslash($_REQUEST['jobs_location'])) : '';
            $jobs_new_location      = isset($_REQUEST['jobs_new_location']) ? felan_clean(wp_unslash($_REQUEST['jobs_new_location'])) : '';
            $jobs_career        = isset($_REQUEST['jobs_career']) ? felan_clean(wp_unslash($_REQUEST['jobs_career'])) : '';
            $jobs_experience        = isset($_REQUEST['jobs_experience']) ? felan_clean(wp_unslash($_REQUEST['jobs_experience'])) : '';
            $jobs_qualification      = isset($_REQUEST['jobs_qualification']) ? felan_clean(wp_unslash($_REQUEST['jobs_qualification'])) : '';
            $jobs_gender      = isset($_REQUEST['jobs_gender']) ? felan_clean(wp_unslash($_REQUEST['jobs_gender'])) : '';
            $jobs_quantity = isset($_REQUEST['jobs_quantity']) ? felan_clean(wp_unslash($_REQUEST['jobs_quantity'])) : '';
            $jobs_days_closing = isset($_REQUEST['jobs_days_closing']) ? felan_clean(wp_unslash($_REQUEST['jobs_days_closing'])) : '';

            $jobs_salary_show        = isset($_REQUEST['jobs_salary_show']) ? felan_clean(wp_unslash($_REQUEST['jobs_salary_show'])) : '';
            $jobs_currency_type       = isset($_REQUEST['jobs_currency_type']) ? felan_clean(wp_unslash($_REQUEST['jobs_currency_type'])) : '';
            $jobs_salary_minimum      = isset($_REQUEST['jobs_salary_minimum']) ? felan_clean(wp_unslash($_REQUEST['jobs_salary_minimum'])) : '';
            $jobs_salary_maximum       = isset($_REQUEST['jobs_salary_maximum']) ? felan_clean(wp_unslash($_REQUEST['jobs_salary_maximum'])) : '';
            $jobs_salary_rate       = isset($_REQUEST['jobs_salary_rate']) ? felan_clean(wp_unslash($_REQUEST['jobs_salary_rate'])) : '';
            $jobs_maximum_price      = isset($_REQUEST['jobs_maximum_price']) ? felan_clean(wp_unslash($_REQUEST['jobs_maximum_price'])) : '';
            $jobs_minimum_price        = isset($_REQUEST['jobs_minimum_price']) ? felan_clean(wp_unslash($_REQUEST['jobs_minimum_price'])) : '';

            $jobs_select_apply       = isset($_REQUEST['jobs_select_apply']) ? felan_clean(wp_unslash($_REQUEST['jobs_select_apply'])) : '';
            $jobs_apply_email       = isset($_REQUEST['jobs_apply_email']) ? felan_clean(wp_unslash($_REQUEST['jobs_apply_email'])) : '';
            $jobs_apply_external      = isset($_REQUEST['jobs_apply_external']) ? felan_clean(wp_unslash($_REQUEST['jobs_apply_external'])) : '';
            $jobs_apply_call_to       = isset($_REQUEST['jobs_apply_call_to']) ? felan_clean(wp_unslash($_REQUEST['jobs_apply_call_to'])) : '';

            $jobs_select_company       = isset($_REQUEST['jobs_select_company']) ? felan_clean(wp_unslash($_REQUEST['jobs_select_company'])) : '';
            $jobs_thumbnail_url = isset($_REQUEST['jobs_thumbnail_url']) ? felan_clean(wp_unslash($_REQUEST['jobs_thumbnail_url'])) : '';
            $jobs_thumbnail_id  = isset($_REQUEST['jobs_thumbnail_id']) ? felan_clean(wp_unslash($_REQUEST['jobs_thumbnail_id'])) : '';
            $felan_gallery_ids          = isset($_REQUEST['felan_gallery_ids']) ? felan_clean(wp_unslash($_REQUEST['felan_gallery_ids'])) : '';
            $jobs_video_url      = isset($_REQUEST['jobs_video_url']) ? felan_clean(wp_unslash($_REQUEST['jobs_video_url'])) : '';
            $custom_field_jobs        = isset($_REQUEST['custom_field_jobs']) ? felan_clean(wp_unslash($_REQUEST['custom_field_jobs'])) : '';

            $jobs_map_location       = isset($_REQUEST['jobs_map_location']) ? felan_clean(wp_unslash($_REQUEST['jobs_map_location'])) : '';
            $jobs_map_address        = isset($_REQUEST['jobs_map_address']) ? felan_clean(wp_unslash($_REQUEST['jobs_map_address'])) : '';
            $jobs_latitude        = isset($_REQUEST['jobs_latitude']) ? felan_clean(wp_unslash($_REQUEST['jobs_latitude'])) : '';
            $jobs_longtitude        = isset($_REQUEST['jobs_longtitude']) ? felan_clean(wp_unslash($_REQUEST['jobs_longtitude'])) : '';

            $submit_button        = isset($_REQUEST['submit_button']) ? felan_clean(wp_unslash($_REQUEST['submit_button'])) : '';

            $company_title = isset($_REQUEST['company_title']) ? felan_clean(wp_unslash($_REQUEST['company_title'])) : '';
            $company_email = isset($_REQUEST['company_email']) ? felan_clean(wp_unslash($_REQUEST['company_email'])) : '';
            $company_avatar_url = isset($_REQUEST['company_avatar_url']) ? felan_clean(wp_unslash($_REQUEST['company_avatar_url'])) : '';
            $company_avatar_id = isset($_REQUEST['company_avatar_id']) ? felan_clean(wp_unslash($_REQUEST['company_avatar_id'])) : '';

            global $current_user;
            wp_get_current_user();
            $user_id = $current_user->ID;

            if ($jobs_new_location) {
                $custom_place_city = trim($jobs_new_location);
                $custom_place_city_slug = strtolower($custom_place_city);
                $custom_place_city_slug = str_replace(' ', '-', $custom_place_city_slug);
                $result = '';
                if (!term_exists($custom_place_city, 'jobs-location')) {
                    $result = wp_insert_term(
                        $custom_place_city,
                        'jobs-location',
                        array(
                            'slug' => $custom_place_city,
                        )
                    );
                }
                if ($result && array_key_exists('term_id', $result)) {
                    $jobs_location = $result['term_id'];
                }
            }

            if ($jobs_new_categories) {
                $new_categories = trim($jobs_new_categories);
                $result = '';
                if (!term_exists($new_categories, 'jobs-categories')) {
                    $result = wp_insert_term(
                        $new_categories,
                        'jobs-categories',
                        array(
                            'slug' => $new_categories,
                        )
                    );
                }
                if ($result && array_key_exists('term_id', $result)) {
                    $jobs_categories = $result['term_id'];
                }
            }

            $new_jobs = array();
            if ($submit_button == 'submit_jobs') {
                if ($jobs_action) {
                    $new_jobs['post_type'] = 'jobs';
                    $new_jobs['post_author'] = $user_id;
                    $auto_publish         = felan_get_option('auto_publish', 1);
                    $auto_publish_edited  = felan_get_option('auto_publish_edited', 1);
                    $paid_submission_type = felan_get_option('paid_submission_type', 'no');

                    if (isset($jobs_title)) {
                        $new_jobs['post_title'] = $jobs_title;
                    }

                    if (isset($jobs_des)) {
                        $new_jobs['post_content'] = $jobs_des;
                    }

                    $submit_action = $jobs_form;
                    if ($submit_action == 'submit-jobs') {
                        $jobs_id = 0;
                        if ($auto_publish == 1) {
                            $new_jobs['post_status'] = 'publish';
                        } else {
                            $new_jobs['post_status'] = 'pending';
                        }
                        if (!empty($new_jobs['post_title'])) {
                            $jobs_id = wp_insert_post($new_jobs, true);
                        }
                        if ($jobs_id > 0) {
                            if ($paid_submission_type == 'per_package') {
                                $package_key = get_the_author_meta(FELAN_METABOX_PREFIX . 'package_key', $user_id);
                                update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'package_key', $package_key);
                                $package_num_jobs = intval(get_the_author_meta(FELAN_METABOX_PREFIX . 'package_number_job', $user_id));
                                if ($package_num_jobs - 1 >= 0) {
                                    update_user_meta($user_id, FELAN_METABOX_PREFIX . 'package_number_job', $package_num_jobs - 1);
                                }
                            }
                            update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'enable_jobs_package_expires', 0);
                        }
                        echo json_encode(array('success' => true));
                    } elseif ($submit_action == 'edit-jobs') {
                        $jobs_id        = absint(wp_unslash($jobs_id));
                        $jobs = get_post($jobs_id);
                        $new_jobs['ID'] = intval($jobs_id);

                        if ($auto_publish_edited == 1) {
                            $new_jobs['post_status'] = 'publish';
                        } else {
                            $new_jobs['post_status'] = 'pending';
                        }

                        if ($paid_submission_type == 'per_package') {
                            $current_package_key = get_the_author_meta(FELAN_METABOX_PREFIX . 'package_key', $user_id);
                            $jobs_package_key = get_post_meta($new_jobs['ID'], FELAN_METABOX_PREFIX . 'package_key', true);
                            $felan_profile = new Felan_Profile();
                            $check_package = $felan_profile->user_package_available($user_id);
                            if (($check_package == -1) || ($check_package == 0)) {
                                return -1;
                            }
                        }

                        $jobs_id = wp_update_post($new_jobs);
                        echo json_encode(array('success' => true));
                    }
                }
            } else {
                echo json_encode(array('success' => true));
            }

            if ($jobs_id > 0) {

                update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_featured', 0);

                update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'verified_listing', 0);

                if ($submit_button == 'submit_jobs') {
                    //cate
                    if (!empty($jobs_type)) {
                        $jobs_type = array_map('intval', $jobs_type);
                        wp_set_object_terms($jobs_id, $jobs_type, 'jobs-type');
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-type_user', $jobs_type);
                    }

                    if (!empty($jobs_categories)) {
                        $jobs_categories = array_map('intval', $jobs_categories);
                        wp_set_object_terms($jobs_id, $jobs_categories, 'jobs-categories');
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-categories_user', $jobs_categories);
                    }

                    if (!empty($jobs_skills)) {
                        $jobs_skills = array_map('intval', $jobs_skills);
                        wp_set_object_terms($jobs_id, $jobs_skills, 'jobs-skills');
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-skills_user', $jobs_skills);
                    }

                    if (!empty($jobs_location)) {
                        $jobs_location = intval($jobs_location);
                        wp_set_object_terms($jobs_id, $jobs_location, 'jobs-location');
                        delete_user_meta($user_id,  FELAN_METABOX_PREFIX . 'jobs-location_user', $jobs_location);
                    }

                    if (!empty($jobs_career)) {
                        $jobs_career = intval($jobs_career);
                        wp_set_object_terms($jobs_id, $jobs_career, 'jobs-career');
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-career_user', $jobs_career);
                    }

                    if (!empty($jobs_experience)) {
                        $jobs_experience = intval($jobs_experience);
                        wp_set_object_terms($jobs_id, $jobs_experience, 'jobs-experience');
                        delete_user_meta($user_id,  FELAN_METABOX_PREFIX . 'jobs-experience_user', $jobs_experience);
                    }

                    if (!empty($jobs_qualification)) {
                        $jobs_qualification = array_map('intval', $jobs_qualification);
                        wp_set_object_terms($jobs_id, $jobs_qualification, 'jobs-qualification');
                        delete_user_meta($user_id,  FELAN_METABOX_PREFIX . 'jobs-qualification_user', $jobs_qualification);
                    }

                    if (!empty($jobs_gender)) {
                        $jobs_gender = intval($jobs_gender);
                        wp_set_object_terms($jobs_id, $jobs_gender, 'jobs-gender');
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-gender_user', $jobs_gender);
                    }

                    //rate
                    if ($jobs_salary_rate == 'days') {
                        $convert_rate = 24;
                    } elseif ($jobs_salary_rate == 'week') {
                        $convert_rate = (24 * 7);
                    } elseif ($jobs_salary_rate == 'month') {
                        $convert_rate = (24 * 7 * 4);
                    } elseif ($jobs_salary_rate == 'year') {
                        $convert_rate = (24 * 7 * 4 * 12);
                    } else {
                        $convert_rate = 1;
                    }

                    $jobs_salary_convert_min = $jobs_salary_convert_max = $jobs_price_convert_min = $jobs_price_convert_max = '';
                    if ($jobs_salary_show == 'range') {
                        $jobs_salary_convert_min = number_format(intval($jobs_salary_minimum) / $convert_rate, 2);
                        $jobs_salary_convert_max = number_format(intval($jobs_salary_maximum) / $convert_rate, 2);
                    }
                    if ($jobs_salary_show == 'starting_amount') {
                        $jobs_price_convert_min = number_format(intval($jobs_minimum_price) / $convert_rate, 2);
                    }
                    if ($jobs_salary_show == 'maximum_amount') {
                        $jobs_price_convert_max = number_format(intval($jobs_maximum_price) / $convert_rate, 2);
                    }

                    //field

                    if (isset($jobs_title)) {
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_post_title', $jobs_title);
                    }

                    if (isset($jobs_des)) {
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_post_des', $jobs_des);
                    }

                    if (isset($jobs_quantity)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_quantity', $jobs_quantity);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_quantity', $jobs_quantity);
                    }

                    if (isset($jobs_days_closing)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_days_closing', $jobs_days_closing);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_days_closing', $jobs_days_closing);
                    }

                    if (isset($jobs_select_apply)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_select_apply', $jobs_select_apply);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_select_apply', $jobs_select_apply);
                    }

                    if (isset($jobs_apply_email)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_apply_email', $jobs_apply_email);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_apply_email', $jobs_apply_email);
                    }

                    if (isset($jobs_apply_external)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_apply_external', $jobs_apply_external);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_apply_external', $jobs_apply_external);
                    }

                    if (isset($jobs_apply_call_to)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_apply_call_to', $jobs_apply_call_to);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_apply_call_to', $jobs_apply_call_to);
                    }

                    if (isset($jobs_salary_show)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_show', $jobs_salary_show);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_salary_show', $jobs_salary_show);
                    }

                    if (isset($jobs_currency_type)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_currency_type', $jobs_currency_type);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_currency_type', $jobs_currency_type);
                    }

                    if (isset($jobs_salary_minimum)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_minimum', $jobs_salary_minimum);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_salary_minimum', $jobs_salary_minimum);
                    }

                    if (isset($jobs_salary_maximum)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_maximum', $jobs_salary_maximum);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_salary_maximum', $jobs_salary_maximum);
                    }

                    if (isset($jobs_maximum_price)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_maximum_price', $jobs_maximum_price);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_maximum_price', $jobs_maximum_price);
                    }

                    if (isset($jobs_minimum_price)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_minimum_price', $jobs_minimum_price);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_minimum_price', $jobs_minimum_price);
                    }

                    if (isset($jobs_salary_rate)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_rate', $jobs_salary_rate);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_salary_rate', $jobs_salary_rate);
                    }

                    if (isset($jobs_salary_convert_min)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_convert_min', $jobs_salary_convert_min);
                    }

                    if (isset($jobs_salary_convert_max)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_salary_convert_max', $jobs_salary_convert_max);
                    }

                    if (isset($jobs_price_convert_min)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_price_convert_min', $jobs_price_convert_min);
                    }

                    if (isset($jobs_price_convert_max)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_price_convert_max', $jobs_price_convert_max);
                    }

                    if (isset($jobs_video_url)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_video_url', $jobs_video_url);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_video_url', $jobs_video_url);
                    }

                    if (isset($jobs_map_address)) {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_address', $jobs_map_address);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_address', $jobs_map_address);
                    }

                    //Add Company
                    if(!empty($jobs_select_company)){
                        if($jobs_select_company == 'new_company'){
                            if(!empty($company_title)){
                                $new_company = array(
                                    'post_type' => 'company',
                                    'post_title' => $company_title,
                                    'post_status' => 'publish',
                                );

                                $company_id = wp_insert_post($new_company, true);

                                if (isset($company_email)) {
                                    update_post_meta($company_id, FELAN_METABOX_PREFIX . 'company_email', $company_email);
                                }

                                if (isset($company_avatar_url) && isset($company_avatar_id)) {
                                    $company_avatar = array(
                                        'id'  => $company_avatar_id,
                                        'url' => $company_avatar_url,
                                    );
                                    update_post_meta($company_id, FELAN_METABOX_PREFIX . 'company_logo', $company_avatar);
                                }

                                update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_select_company', $company_id);
                                delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_select_company', $company_id);
                            }
                        } else {
                            update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_select_company', $jobs_select_company);
                            delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_select_company', $jobs_select_company);
                        }
                    }
                } else {

                    if (!empty($jobs_type)) {
                        $jobs_type = array_map('intval', $jobs_type);
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-type_user', $jobs_type);
                    }

                    if (!empty($jobs_categories)) {
                        $jobs_categories = intval($jobs_categories);
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-categories_user', $jobs_categories);
                    }

                    if (!empty($jobs_skills)) {
                        $jobs_skills = array_map('intval', $jobs_skills);
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-skills_user', $jobs_skills);
                    }

                    if (!empty($jobs_location)) {
                        $jobs_location = intval($jobs_location);
                        update_user_meta($user_id,  FELAN_METABOX_PREFIX . 'jobs-location_user', $jobs_location);
                    }

                    if (!empty($jobs_career)) {
                        $jobs_career = intval($jobs_career);
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-career_user', $jobs_career);
                    }

                    if (!empty($jobs_experience)) {
                        $jobs_experience = intval($jobs_experience);
                        update_user_meta($user_id,  FELAN_METABOX_PREFIX . 'jobs-experience_user', $jobs_experience);
                    }

                    if (!empty($jobs_qualification)) {
                        $jobs_qualification = array_map('intval', $jobs_qualification);
                        update_user_meta($user_id,  FELAN_METABOX_PREFIX . 'jobs-qualification_user', $jobs_qualification);
                    }

                    if (!empty($jobs_gender)) {
                        $jobs_gender = intval($jobs_gender);
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs-gender_user', $jobs_gender);
                    }

                    //field

                    if (isset($jobs_title)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_post_title', $jobs_title);
                    }

                    if (isset($jobs_des)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_post_des', $jobs_des);
                    }

                    if (isset($jobs_quantity)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_quantity', $jobs_quantity);
                    }

                    if (isset($jobs_days_closing)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_days_closing', $jobs_days_closing);
                    }

                    if (isset($jobs_select_apply)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_select_apply', $jobs_select_apply);
                    }

                    if (isset($jobs_apply_email)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_apply_email', $jobs_apply_email);
                    }

                    if (isset($jobs_apply_external)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_apply_external', $jobs_apply_external);
                    }

                    if (isset($jobs_apply_call_to)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_apply_call_to', $jobs_apply_call_to);
                    }

                    if (isset($jobs_salary_show)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_salary_show', $jobs_salary_show);
                    }

                    if (isset($jobs_currency_type)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_currency_type', $jobs_currency_type);
                    }

                    if (isset($jobs_salary_minimum)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_salary_minimum', $jobs_salary_minimum);
                    }

                    if (isset($jobs_salary_maximum)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_salary_maximum', $jobs_salary_maximum);
                    }

                    if (isset($jobs_salary_rate)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_salary_rate', $jobs_salary_rate);
                    }

                    if (isset($jobs_maximum_price)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_maximum_price', $jobs_maximum_price);
                    }

                    if (isset($jobs_minimum_price)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_minimum_price', $jobs_minimum_price);
                    }

                    if (isset($jobs_select_company)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_select_company', $jobs_select_company);
                    }

                    if (isset($jobs_video_url)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_video_url', $jobs_video_url);
                    }

                    if (isset($jobs_map_address)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_address', $jobs_map_address);
                    }

                    if (isset($jobs_postal_code)) {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_zip', $jobs_postal_code);
                    }
                }

                if (isset($jobs_map_location)) {
                    $lat_lng = $jobs_map_location;
                    $address = $jobs_map_address;
                    $arr_location = array(
                        'location' => $lat_lng,
                        'address' => $address,
                    );
                    if ($submit_button == 'submit_jobs') {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_location', $arr_location);
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_address', $jobs_map_address);
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_latitude', $jobs_latitude);
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_longtitude', $jobs_longtitude);

                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_location', $arr_location);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_address', $jobs_map_address);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_latitude', $jobs_latitude);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_longtitude', $jobs_longtitude);
                    } else {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_location', $arr_location);
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_address', $jobs_map_address);
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_latitude', $jobs_latitude);
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_longtitude', $jobs_longtitude);
                    }
                }

                $get_additional = felan_render_custom_field('jobs');
                if (count($get_additional) > 0 && !empty($custom_field_jobs)) {
                    foreach ($get_additional as $key => $field) {
                        if (count($custom_field_jobs) > 0 && isset($custom_field_jobs[$field['id']])) {
                            if ($field['type'] == 'checkbox_list') {
                                $arr = array();
                                foreach ($custom_field_jobs[$field['id']] as $v) {
                                    $arr[] = $v;
                                }
                                if ($submit_button == 'submit_jobs') {
                                    update_post_meta($jobs_id, $field['id'], $arr);
                                    delete_user_meta($user_id, $field['id'], $arr);
                                } else {
                                    update_user_meta($user_id, $field['id'], $arr);
                                }
                            } elseif ($field['type'] == 'image') {
                                $custom_field_jobs_url = wp_get_attachment_url($custom_field_jobs[$field['id']]);
                                $custom_image = array(
                                    'id'  => $custom_field_jobs[$field['id']],
                                    'url'  => $custom_field_jobs_url,
                                );
                                if ($submit_button == 'submit_jobs') {
                                    update_post_meta($jobs_id, $field['id'], $custom_image);
                                    delete_user_meta($user_id, $field['id'], $custom_image);
                                } else {
                                    update_user_meta($user_id, $field['id'], $custom_image);
                                }
                            } else {
                                if ($submit_button == 'submit_jobs') {
                                    update_post_meta($jobs_id, $field['id'], $custom_field_jobs[$field['id']]);
                                    delete_user_meta($user_id, $field['id'], $custom_field_jobs[$field['id']]);
                                } else {
                                    update_user_meta($user_id, $field['id'], $custom_field_jobs[$field['id']]);
                                }
                            }
                        }
                    }
                }

                if (isset($jobs_thumbnail_url) && !empty($jobs_thumbnail_id)) {
                    $jobs_thumbnail = array(
                        'id'  => $jobs_thumbnail_id,
                        'url' => $jobs_thumbnail_url,
                    );
                    if ($submit_button == 'submit_jobs') {
                        update_post_meta($jobs_id, '_thumbnail_id', $jobs_thumbnail_id);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_thumbnail_ids', $jobs_thumbnail_id);
                    } else {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_thumbnail_ids', $jobs_thumbnail_id);
                    }
                }

                if (isset($felan_gallery_ids)) {
                    $str_img_ids = '';
                    foreach ($felan_gallery_ids as $jobs_img_id) {
                        $felan_gallery_ids[] = intval($jobs_img_id);
                        $str_img_ids .= '|' . intval($jobs_img_id);
                    }
                    $str_img_ids = substr($str_img_ids, 1);
                    if ($submit_button == 'submit_jobs') {
                        update_post_meta($jobs_id, FELAN_METABOX_PREFIX . 'jobs_images', $str_img_ids);
                        delete_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_images', $str_img_ids);
                    } else {
                        update_user_meta($user_id, FELAN_METABOX_PREFIX . 'jobs_user_images', $str_img_ids);
                    }
                }
            }

            wp_die();
        }

        /**
         * True if an the user can edit a jobs.
         */
        public function user_can_edit_jobs($jobs_id)
        {
            $can_edit = true;

            if (!is_user_logged_in() || !$jobs_id) {
                $can_edit = false;
            } else {
                $jobs = get_post($jobs_id);

                if (!$jobs || (absint($jobs->post_author) !== get_current_user_id() && !current_user_can('edit_post', $jobs_id))) {
                    $can_edit = false;
                }
            }

            return apply_filters('felan_user_can_edit_jobs', $can_edit, $jobs_id);
        }
    }
}
