<section class="band image-abstract-button <?php echo get_sub_field('full_width')?'band-full':''; ?>" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
	
	<?php if(get_sub_field('image')): ?>
	<div class="band-image main-band-content"><?php
	 echo wp_get_attachment_image(get_sub_field('image'), get_sub_field('full_width')?'band-full':'band'); 
	?></div><?php
	 endif;    			
	?><div class="secondary-band-content">
		<?php if(get_sub_field('title') || get_sub_field('subtitle')): ?>
		<header class="section-header band-header">
		    <?php if(get_sub_field('title')): ?>
			<h2 class="section-title"><?php the_sub_field('title'); ?></h2>
			<?php endif; ?>
			<?php if(get_sub_field('subtitle')): ?>
			<p class="section-subtitle subtitle"><?php the_sub_field('subtitle'); ?></p>
			<?php endif; ?>
		</header>
		<?php endif; ?>

		<div class="section-content band-content"><?php the_sub_field('content'); ?></div>
		
		<?php if(get_sub_field('button_link') && get_sub_field('button_label')): ?>
		<div class="band-action ">
			<a class="action-button band-button" href="<?php the_sub_field('button_link'); ?>"><?php the_sub_field('button_label'); ?></a>
		</div>
		<?php endif; ?>
		
	</div>
</section>