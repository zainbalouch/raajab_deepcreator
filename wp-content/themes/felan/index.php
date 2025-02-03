<?php

/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header();

$blog_content_layout = Felan_Helper::get_setting("blog_content_layout");
$blog_number_column = Felan_Helper::get_setting("blog_number_column");
$blog_sidebar = Felan_Helper::get_setting("blog_sidebar");
$blog_enable_categories = Felan_Helper::get_setting("blog_enable_categories");
$blog_sidebar = !empty($_GET["sidebar"])
	? Felan_Helper::felan_clean(wp_unslash($_GET["sidebar"]))
	: $blog_sidebar;

if (isset($_GET["layout"]) && sanitize_text_field($_GET["layout"]) == "grid") {
	$blog_content_layout = "layout-grid";
} elseif (
	isset($_GET["layout"]) &&
	sanitize_text_field($_GET["layout"]) == "list"
) {
	$blog_content_layout = "layout-list";
} elseif (
	isset($_GET["layout"]) &&
	sanitize_text_field($_GET["layout"]) == "masonry"
) {
	$blog_content_layout = "layout-masonry";
}

$sidebar_classes[] = $blog_sidebar;
if ($blog_sidebar != "no-sidebar" && is_active_sidebar("sidebar")) {
	$sidebar_classes[] = "has-sidebar";
}
$post_classes = [
	"archive-post",
	"grid",
	$blog_content_layout,
	$blog_number_column,
	"columns-sm-2",
	"columns-xs-1",
];

if ($blog_content_layout == "layout-list") {
	$post_classes = ["archive-post", $blog_content_layout];
}
?>

<?php echo Felan_Templates::page_title(); ?>

<div class="main-content content-blog">

	<div class="container">

		<div class="site-layout <?php echo join(" ", $sidebar_classes); ?>">

			<div id="primary" class="content-area">

				<?php if ($blog_enable_categories) :
					echo Felan_Templates::post_categories();
				endif; ?>

				<main id="main" class="site-main">

					<?php if (have_posts()) : ?>

						<div class="<?php echo join(" ", $post_classes); ?>">

							<?php
							while (have_posts()) :
								the_post();

								/*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
								get_template_part("templates/archive/" . $blog_content_layout);
							endwhile; ?>

						</div>

						<?php echo Felan_Templates::pagination(); ?>

					<?php else : get_template_part("components/post/content", "none");
					endif; ?>

				</main>

			</div>

			<?php if (is_active_sidebar("sidebar")) : ?>

				<?php get_sidebar(); ?>

			<?php endif; ?>

		</div>

	</div>

</div>

<?php get_footer();
