<?php
/**
 * The header
 *
 * @package WordPress
 * @subpackage nathalie-mota
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta name="keywords" content="photographe événementiel, photographe event, nathalie mota, photo format hd"/>
	<meta name="description" content="Nathalie Mota - Site personnel pour la vente de mes photos en impression HD."
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

	<!-- Récupération sur Fontawesome des icones dont on aura besoin -->
	<script src="https://kit.fontawesome.com/57bf6f7049.js" crossorigin="anonymous"></script>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<header class="header">
    <div class="header_container" id="site-navigation">
        <div class="logo">
            <a href="<?php echo home_url('/'); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_nathalie_mota.png" 
				alt="Logo <?php echo bloginfo('name'); ?>">
			</a>
			</div>

<!-- menu burger -->
<div class="burgerMenu">
	<span class="bar"></span>
	<span class="bar"></span>
	<span class="bar"></span>
</div>

<!-- Navigation (Menu) -->
<nav class="nav-links-container">
	<?php
		wp_nav_menu(array(
			'theme_location' => 'main',
			'menu_class' => 'header-menu', // classe CSS pour customiser mon menu
		));
	?>
</nav>
</div>
</header>	
