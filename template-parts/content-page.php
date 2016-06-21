<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php twentysixteen_post_thumbnail(); ?>	
	
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<p class="entry-subtitle subtitle"><?php echo get_field('subtitle'); ?></p>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		add_filter('the_content', 'strip_first_gallery');
		the_content();
		remove_filter('the_content', 'strip_first_gallery');

		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if(get_post_gallery()): ?>
		<?php echo get_post_gallery(); ?>
	<?php endif; ?>	
		
	<div class="content-bands">
		<?php get_template_part( 'template-parts/content', 'bands' ); ?>
	</div>	

</article><!-- #post-## -->
