<section class="band band-full logos" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
	<header class="section-header band-header">
		<h2 class="section-title title"><?php the_sub_field('title'); ?></h2>
	</header>
	<div class="logo-list main-band-content" >
		<?php while ( have_rows('logos') ) : the_row(); ?>
			<a class="logo" href="<?php the_sub_field('target_url'); ?>" rel="external" ><?php echo wp_get_attachment_image(get_sub_field('logo'), 'full'); ?></a>
		<?php endwhile; ?>
	</div>
</section>