<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post(); ?>
			
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<p class="entry-subtitle subtitle"><?php the_field('subtitle'); ?></p>
					</header><!-- .entry-header -->
				
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
					
					<?php theme_content_bands(); ?>							
				
				</article><!-- #post-## -->

			<?php
			// End the loop.
			endwhile;
			
		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
