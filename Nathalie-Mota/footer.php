
<?php

?>
	<footer>
    <nav class="footer-nav">
      <?php
        wp_nav_menu( array(
          'theme_location' => 'footer', 
          'container' => false, 
          'menu_class' => 'footer-menu', 
        ) );
      ?>
    </nav>


	<?php 
        get_template_part ( 'template-parts/modal/contact'); 		
    ?>

<?php wp_footer(); ?>

</body>
</html>
