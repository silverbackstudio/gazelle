<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php twentysixteen_post_thumbnail('page-cover'); ?>
	
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php if($sub = get_field('subtitle')): ?><p class="entry-subtitle subtitle"><?php echo $sub; ?></p><?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php add_filter('the_content', 'strip_first_gallery'); ?>
		<?php the_content(); ?>
		<?php remove_filter('the_content', 'strip_first_gallery'); ?>
	</div><!-- .entry-content -->

	<?php if(get_post_gallery()): ?>
		<?php echo get_post_gallery(); ?>
	<?php endif; ?>

	<footer class="entry-footer">
		<?php twentysixteen_entry_meta(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
