<section class="band gallery-and-text" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
	<?php if($gallery = get_sub_field('gallery', false, false)): ?>
	<div class="band-gallery main-band-content js-flickity" data-flickity-options='{ "cellAlign": "left", "pageDots": false, "imagesLoaded": true, "autoPlay": true }'>
		<?php foreach( $gallery as $image_id ): ?> 
            <div class="carousel-cell">
                <?php echo wp_get_attachment_image($image_id, 'band'); ?> 
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; 			    
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