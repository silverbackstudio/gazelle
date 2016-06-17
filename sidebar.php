<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' )  ) : ?>
	<aside id="secondary" class="sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>

<?php if(has_instagram() && apply_filters('show_instagram_footer', is_front_page())): ?>
<section id="instagram">
	<header class="section-header">
		<h3 class="section-title"><?php _e('Check out our Instagram Gallery', 'gazelle'); ?></h3>
	</header>
	<div id="instafeed" class="section-content"></div>
</section>
<?php endif; ?>