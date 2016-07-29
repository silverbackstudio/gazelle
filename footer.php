<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

		<?php if(has_instagram() && apply_filters('show_instagram_footer', is_front_page())): ?>
		<section id="instagram">
			<header class="section-header">
				<h3 class="section-title"><?php _e('Check out our Instagram Gallery', 'gazelle'); ?></h3>
			</header>
			<div id="instafeed" class="section-content"></div>
		</section>
		<?php endif; ?>

		</div><!-- .site-content -->

		<footer id="colophon" class="site-footer full-width" role="contentinfo">

			<div class="site-info content-wrapper">
				<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
			</div><!-- .site-info -->
			
			<div class="site-info content-wrapper">
				<p class="contact-info">
					<span class="contact-address"><?php bloginfo('contact_address'); ?></span>
					<span class="contact-phone"><a href="tel:<?php bloginfo('contact_phone'); ?>"><?php bloginfo('contact_phone'); ?></a></span>
					<span class="contact-email"><?php echo hide_email(get_bloginfo('contact_email','display')); ?></a></span>
				</p>
				<p class="company-info">
					<span class="contact-company-name"><?php bloginfo('contact_company_name'); ?></span>
					<span class="contact-address2"><?php bloginfo('contact_address2'); ?></span>
					<span class="contact-vat"><?php _e('VAT ID','gazelle'); ?>&nbsp;<?php bloginfo('contact_vat'); ?></span>
				</p>
			</div><!-- .site-info -->
			
			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentysixteen' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'social',
							'menu_class'     => 'social-links-menu',
							'depth'          => 1,
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
						) );
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>
			
			<div id="legal">
				<span id="copyright"><?php printf(__('Copyright &copy; %s'), date('Y')); ?></span>
				<nav class="service-navigation" id="privacy" role="navigation" aria-label="<?php esc_attr_e( 'Privacy Menu', 'twentysixteen' ); ?>">
					<ul>
						<?php $config = \Silverback\WP\Themes\Gazelle\get_config(); ?>
						<?php if(isset($config['iubenda']) && isset($config['iubenda']['privacyPolicyId'])): ?>
						<li id="privacy-policy">
							<a href="//www.iubenda.com/privacy-policy/<?php echo $config['iubenda']['privacyPolicyId']; ?>" class="iubenda-nostyle no-brand iubenda-embed" title="<?php _e('Privacy Policy', 'gazelle'); ?>"><?php _e('Privacy Policy', 'gazelle'); ?></a>
						</li>
						<?php endif; ?>
						<?php if(isset($config['iubenda']) && isset($config['iubenda']['cookiePolicyId'])): ?>
						<li id="cookie-policy">
							<a href="https://www.iubenda.com/privacy-policy/<?php echo $config['iubenda']['cookiePolicyId']; ?>/cookie-policy" title="<?php _e('Cookie Policy', 'gazelle'); ?>"><?php _e('Cookie Policy', 'gazelle'); ?></a>
						</li>
						<?php endif; ?>
					</ul>
				</nav><!-- .main-navigation -->
			</div>
			
			<div id="credits">Made with passion by <a href="http://www.silverbackstudio.it" target="_blank" rel="external">SilverbackStudio</a></div>
		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
