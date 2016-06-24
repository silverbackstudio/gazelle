<section class="band band-full feedback" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
	<header class="section-header band-header">
		<h2 class="section-title"><?php the_sub_field('title'); ?></h2>
		<p class="section-subtitle subtitle"><?php the_sub_field('subtitle'); ?></p>
	</header>
	<ul class="customer-feedback main-band-content js-flickity" data-flickity-options='{ "cellSelector": ".feedback", "imagesLoaded": false, "autoPlay": true }' >
		<?php while ( have_rows('feedback') ) : the_row(); ?>
			<li class="feedback"><?php the_sub_field('testo'); ?><span class="author"><?php the_sub_field('author'); ?></span></li>
		<?php endwhile; ?>
	</ul>
</section>