<?php
/**
 * The header for our theme
 * @package ProCoders
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
	<div data-homeurl="<?= get_home_url(); ?>" id="home-url"></div>
		<nav id="site-navigation" class="main-navigation">
			<div class="main-navigation__logo">Logo</div>
			<div class="main-navigation__menu">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
						)
					);
				?>
				<a href="#" class="main-navigation__btn">Sign In</a>
			</div>
		</nav>
		<div id="nav-pop" class="nav-popup" style="display:none;">
			<div class="nav-popup__top">
				<div class="nav-popup__left">
					<div class="nav-popup__learningcenter">
						<div class="nav-popup__data-learning"><img src="<?= get_template_directory_uri(); ?>/images/list.svg" alt="SVG Image"><p class="nav-popup__learningtitle">Learning Center</p></div>
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-2',
									'menu_id'        => 'learningcenter-menu',
								)
							);
						?>
					</div>
					<div class="nav-popup__blog">
					<div class="nav-popup__data-blog"><img src="<?= get_template_directory_uri(); ?>/images/focus.svg" alt="SVG Image"><p class="nav-popup__blogtitle">Blog</p></div>
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-3',
									'menu_id'        => 'blog-menu',
								)
							);
						?>
					</div>
				</div>
				<div class="nav-popup__right">
					<div class="nav-popup__event">
					<div class="nav-popup__data-event"><img src="<?= get_template_directory_uri(); ?>/images/list.svg" alt="SVG Image"><p class="nav-popup__eventtitle">Events</p></div>
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-4',
									'menu_id'        => 'event-menu',
									'walker'         => new EventWalkerMenu()
								)
							);
						?>
					</div>
				</div>
			</div>
			<div class="nav-popup__bottom">
				<div class="nav-popup__text">
					<p class="nav-popup__topline">Ready to get started?</p>
					<p class="nav-popup__subline">See how our application works, how easy it is</p>
				</div>
				<a href="#" class="nav-popup__cta">WATCH DEMO</a>
			</div>
		</div>
	</header>
