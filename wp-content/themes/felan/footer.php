<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */
$footer_type = Felan_Helper::get_setting("footer_type");

$footer_type  = apply_filters('felan_footer_type', $footer_type);

$id = get_the_ID();
$footer_show = $footer_page = '';
if (!empty($id)) {
	$footer_page = get_post_meta($id, 'felan-footer_type', true);
	$footer_show = get_post_meta($id, 'felan-footer_show', true);
} else {
	$footer_page = '';
}
?>

</div><!-- End #content -->
<?php if ($footer_show !== '0') { ?>
	<footer class="site-footer">
		<div class="inner-footer">
			<?php if ($footer_page == '') { ?>
				<?php if ($footer_type !== '') { ?>
					<?php
					if (!function_exists('elementor_location_exits') || !elementor_location_exits('footer', true)) {
						if (defined('ELEMENTOR_VERSION')) {
							echo \Elementor\Plugin::$instance->frontend->get_builder_content($footer_type);
						} else {
							$footer = get_post($footer_type);
							if (!empty($footer->post_content)) {
								$footer_content = $footer->post_content;
								echo wp_kses_post($footer_content);
							}
						}
					} else {
						if (function_exists('elementor_theme_do_location')) :
							elementor_theme_do_location('footer');
						endif;
					}
					?>
				<?php } else { ?>
					<?php get_template_part('templates/footer/copyright'); ?>
				<?php } ?>
			<?php } else {
				if (defined('ELEMENTOR_VERSION')) {
					echo \Elementor\Plugin::$instance->frontend->get_builder_content($footer_page);
				} else {
					$footer = get_post($footer_page);
					if (!empty($footer->post_content)) {
						$footer_content = $footer->post_content;
						echo wp_kses_post($footer_content);
					}
				}
			} ?>
		</div>
	</footer>
<?php } ?>
</div><!-- End #wrapper -->

<?php wp_footer(); ?>

</body>

</html>