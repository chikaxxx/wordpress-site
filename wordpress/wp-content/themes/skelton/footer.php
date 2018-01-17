
	<footer class="ly-footer">
		<p class="copyright"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><small><span class="copymark">&copy;</span> <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?> All Rights Reserved.</small></a></p>
	</footer>



</div><!-- /.ly-wrapper -->

<?php wp_footer(); ?>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-fixme-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-fixme-1');
</script>

<script src="https://use.typekit.net/ley3isx.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>


<?php if(wp_is_mobile()):?>
	<script src="<?php bloginfo( 'template_url' ); ?>/javascripts/bundle.sp.js?<?php echo file_date(get_template_directory() . '/javascripts/bundle.sp.js'); ?>"></script>
<?php else : ?>
	<script src="<?php bloginfo( 'template_url' ); ?>/javascripts/bundle.pc.js?<?php echo file_date(get_template_directory() . '/javascripts/bundle.pc.js'); ?>"></script>
<?php endif; ?>

</body>
</html>