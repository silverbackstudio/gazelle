<section class="band map-abstract" id="<?php echo esc_attr(sanitize_title(get_sub_field('title'))); ?>">
	<?php if($latlng = get_sub_field('mappa')): ?>
	<div class="band-map main-band-content map-container map-locker locked" data-map-lng="<?php echo esc_attr($latlng['lng']); ?>" data-map-lat="<?php echo esc_attr($latlng['lat']); ?>">
  	    <div id="map" class="google-map" ></div>
		<div class="map-lock">
            <span class="unlock-label"><?php _e('Unlock map', 'gazelle'); ?></span>
            <span class="lock-label"><?php _e('Lock map', 'gazelle'); ?></span>
        </div>
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
	</div>
</section>	