<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Felan_freelancer_withdraw')) {
    /**
     * Class Felan_freelancer_withdraw
     */
    class Felan_freelancer_withdraw
    {
        /**
         * Get total my freelancer_withdraw
         * @return int
         */
        public function get_total_my_freelancer_withdraw()
        {
            $args = array(
                'post_type' => 'freelancer_withdraw',
                'meta_query' => array(
                    array(
                        'key' => FELAN_METABOX_PREFIX . 'freelancer_withdraw_user_id',
                        'value' => get_current_user_id(),
                        'compare' => '='
                    )
                )
            );
            $freelancer_withdraws = new WP_Query($args);
            wp_reset_postdata();
            return $freelancer_withdraws->found_posts;
        }

        /**
         * Insert freelancer_withdraw
         * @param $item_id
         * @param $user_id
         * @param $payment_for
         * @param $payment_method
         * @param int $paid
         * @param string $payment_id
         * @param string $payer_id
         * @return int|WP_Error
         */
        public function insert_freelancer_withdraw($total_money, $item_id, $user_id, $payment_method, $status = 'pending')
        {

            $time = time();
            $freelancer_withdraw_date = date('Y-m-d', $time);
            $author_id = get_post_field('post_author', $item_id);
            $author_name = get_the_author_meta('display_name', $author_id);

            $felan_meta = array();
            $felan_meta['freelancer_withdraw_item_id'] = $item_id;
            $felan_meta['freelancer_withdraw_item_price'] = $total_money;
            $felan_meta['freelancer_withdraw_purchase_date'] = $freelancer_withdraw_date;
            $felan_meta['freelancer_withdraw_user_id'] = $user_id;
            $felan_meta['freelancer_withdraw_author_service'] = $author_name;
            $felan_meta['freelancer_withdraw_payment_method'] = $payment_method;
            $posttitle = get_the_title($item_id);
            $args = array(
                'post_title'    => $posttitle,
                'post_status'    => 'publish',
                'post_type'     => 'freelancer_withdraw'
            );

            $freelancer_withdraw_id =  wp_insert_post($args);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_user_id', $user_id);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_author_service', $author_name);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_author_id_service', $author_id);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_item_id', $item_id);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_price', $total_money);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_date', $freelancer_withdraw_date);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_payment_method', $payment_method);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_payment_status', $status);
            update_post_meta($freelancer_withdraw_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_meta', $felan_meta);
            $update_post = array(
                'ID'         => $freelancer_withdraw_id,
            );
            wp_update_post($update_post);

            return $freelancer_withdraw_id;
        }

        /**
         * get_freelancer_withdraw_meta
         * @param $post_id
         * @param bool|false $field
         * @return array|bool|mixed
         */
        public function get_freelancer_withdraw_meta($post_id, $field = false)
        {
            $defaults = array(
                'freelancer_withdraw_item_id' => '',
                'freelancer_withdraw_item_price' => '',
                'freelancer_withdraw_purchase_date' => '',
                'freelancer_withdraw_user_id' => '',
                'freelancer_withdraw_payment_method' => '',
                'trans_payment_id' => '',
                'trans_payer_id' => '',
            );
            $meta = get_post_meta($post_id, FELAN_METABOX_PREFIX . 'freelancer_withdraw_meta', true);
            $meta = wp_parse_args((array)$meta, $defaults);

            if ($field) {
                if (isset($meta[$field])) {
                    return $meta[$field];
                } else {
                    return false;
                }
            }
            return $meta;
        }

        /**
         * @param $payment_method
         * @return string
         */
        public static function get_freelancer_withdraw_payment_method($payment_method)
        {
            switch ($payment_method) {
                case 'Paypal':
                    return esc_html__('Paypal', 'felan-framework');
                    break;
                case 'Stripe':
                    return esc_html__('Stripe', 'felan-framework');
                    break;
                case 'Wire_Transfer':
                    return esc_html__('Wire Transfer', 'felan-framework');
                    break;
                case 'Free_Package':
                    return esc_html__('Free Package', 'felan-framework');
                    break;
                default:
                    return '';
            }
        }
        /**
         * Print freelancer_withdraw
         */
        public function freelancer_withdraw_print_ajax()
        {
            if (!isset($_POST['freelancer_withdraw_id']) || !is_numeric($_POST['freelancer_withdraw_id'])) {
                return;
            }
            $freelancer_withdraw_id = absint(wp_unslash($_POST['freelancer_withdraw_id']));
            $isRTL = 'false';
            if (isset($_POST['isRTL'])) {
                $isRTL = $_POST['isRTL'];
            }
            felan_get_template('freelancer_withdraw/freelancer_withdraw-print.php', array('freelancer_withdraw_id' => intval($freelancer_withdraw_id), 'isRTL' => $isRTL));
            wp_die();
        }

        /**
         * Insert service service_package
         */
        public function insert_user_service_package($user_id, $service_package_id)
        {
            //Service
            $service_package_number_service = get_post_meta($service_package_id, FELAN_METABOX_PREFIX . 'service_package_number_service', true);
            $service_package_number_service_featured = get_post_meta($service_package_id, FELAN_METABOX_PREFIX . 'service_package_number_service_featured', true);
            $enable_package_service_unlimited = get_post_meta($service_package_id, FELAN_METABOX_PREFIX . 'enable_package_service_unlimited', true);

            if ($enable_package_service_unlimited == 1) {
                $service_package_number_service = 999999999999999999;
            }
            update_user_meta($user_id, FELAN_METABOX_PREFIX . 'service_package_number_service', $service_package_number_service);
            update_user_meta($user_id, FELAN_METABOX_PREFIX . 'service_package_number_service_featured', $service_package_number_service_featured);

            //Field
            $field_package = array('jobs_apply', 'jobs_wishlist', 'company_follow');
            foreach ($field_package as $field) {
                $show_field = get_post_meta($service_package_id, FELAN_METABOX_PREFIX . 'show_package_' . $field, true);
                $field_number = get_post_meta($service_package_id, FELAN_METABOX_PREFIX . 'service_package_number_' . $field, true);
                $field_unlimited = get_post_meta($service_package_id, FELAN_METABOX_PREFIX . 'enable_package_' . $field . '_unlimited', true);
                if (intval($show_field) == 1) {
                    if ($field_unlimited == 1) {
                        $field_number = 999999999999999999;
                    }
                    update_user_meta($user_id, FELAN_METABOX_PREFIX . 'service_package_number_' . $field, $field_number);
                }
            }

            $time = time();
            $date = date('Y-m-d H:i:s', $time);
            update_user_meta($user_id, FELAN_METABOX_PREFIX . 'service_package_activate_date', $date);
            update_user_meta($user_id, FELAN_METABOX_PREFIX . 'service_package_id', $service_package_id);
            $service_package_key = uniqid();
            update_user_meta($user_id, FELAN_METABOX_PREFIX . 'service_package_key', $service_package_key);
        }
    }
}
