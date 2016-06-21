<section class="band title-text" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
     <?php if(get_sub_field('title')): ?>
	<header class="section-header band-header">
		<h2 class="section-title"><?php the_sub_field('title'); ?></h2>
	</header>
	<?php endif; ?>
	<div class="section-content band-content"><?php the_sub_field('content'); ?></div>
</section>	