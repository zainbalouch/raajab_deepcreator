<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<textarea placeholder="<?php esc_attr_e('Write your message', 'felan-framework'); ?>" name="ricetheme_send_mess"></textarea>
<button id="btn-write-message">
    <?php esc_html_e('Send', 'felan-framework'); ?>
    <span class="btn-loading"><i class="far fa-spinner fa-spin large"></i></span>
</button>