<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Felan_Freelancer_Trans_Log')) {
    /**
     * Class Felan_Freelancer_Trans_Log
     */
    class Felan_Freelancer_Trans_Log
    {
        /**
         * Insert log
         * @param $payment_type
         * @param $item_id
         * @param $user_id
         * @param $payment_for
         * @param $payment_method
         * @param int $paid
         * @param string $payment_id
         * @param string $payer_id
         * @return int|WP_Error
         */
        public function insert_trans_log($payment_type, $item_id, $user_id, $payment_for, $payment_method, $paid = 0, $payment_id = '', $payer_id = '', $status = 1, $message = '')
        {

            $price_per_submission = felan_get_option('price_per_listing', '0');
            $price_per_submission      = floatval($price_per_submission);

            $price_featured_submission = felan_get_option('price_featured_listing', '0');
            $price_featured_submission = floatval($price_featured_submission);
            $total_money = 0;
            if ($payment_type != 'Package') {
                if ($payment_for == 3) {
                    $total_money = $price_featured_submission;
                } else {
                    if ($payment_for == 2) {
                        $total_money = $price_per_submission + $price_featured_submission;
                    } elseif ($payment_for == 1) {
                        $total_money = $price_per_submission;
                    }
                }
            } else {
                $freelancer_package_free = get_post_meta($item_id, FELAN_METABOX_PREFIX . 'freelancer_package_free', true);
                if ($freelancer_package_free == 1) {
                    $total_money = 0;
                } else {
                    $total_money = get_post_meta($item_id, FELAN_METABOX_PREFIX . 'freelancer_package_price', true);
                }
            }
            $time = time();
            $trans_log_freelancer_date = date('Y-m-d H:i:s', $time);

            $felan_meta = array();
            $felan_meta['trans_log_freelancer_item_id'] = $item_id;
            $felan_meta['trans_log_freelancer_item_price'] = $total_money;
            $felan_meta['trans_log_freelancer_purchase_date'] = $trans_log_freelancer_date;
            $felan_meta['trans_log_freelancer_user_id'] = $user_id;
            $felan_meta['trans_log_freelancer_payment_type'] = $payment_type;
            $felan_meta['trans_log_freelancer_payment_method'] = $payment_method;
            $felan_meta['trans_payment_id'] = $payment_id;
            $felan_meta['trans_payer_id'] = $payer_id;
            $felan_meta['trans_log_freelancer_message'] = $message;
            $args = array(
                'post_title'    => 'Log',
                'post_status'    => 'publish',
                'post_type'     => 'trans_log_freelancer'
            );
            $trans_log_freelancer_id =  wp_insert_post($args);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_user_id', $user_id);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_item_id', $item_id);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_price', $total_money);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_date', $trans_log_freelancer_date);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_payment_type', $payment_type);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_payment_method', $payment_method);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_payment_status', $paid);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_payment_id', $payment_id);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_payer_id', $payer_id);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_status', $status);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_message', $message);
            update_post_meta($trans_log_freelancer_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_meta', $felan_meta);

            $update_post = array(
                'ID'         => $trans_log_freelancer_id,
                'post_title' => 'Log ' . $trans_log_freelancer_id,
            );
            wp_update_post($update_post);
            return $trans_log_freelancer_id;
        }

        /**
         * get_trans_log_freelancer_meta
         * @param $post_id
         * @param bool|false $field
         * @return array|bool|mixed
         */
        public function get_trans_log_freelancer_meta($post_id, $field = false)
        {
            $defaults = array(
                'trans_log_freelancer_item_id' => '',
                'trans_log_freelancer_item_price' => '',
                'trans_log_freelancer_purchase_date' => '',
                'trans_log_freelancer_user_id' => '',
                'trans_log_freelancer_payment_type' => '',
                'trans_log_freelancer_payment_method' => '',
                'trans_payment_id' => '',
                'trans_payer_id' => '',
            );
            $meta = get_post_meta($post_id, FELAN_METABOX_PREFIX . 'trans_log_freelancer_meta', true);
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
    }
}
