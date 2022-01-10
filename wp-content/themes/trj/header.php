<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package TRJ
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property=og:site_name content="TRJ Company Limited | Fintech Portfolio Management Company">
	<meta property=og:title content="TRJ Company Limited | Fintech Portfolio Management Company">
	<meta property=og:url content="https://trjcompanylimited.com/">
	<meta property=og:type content=website>
	<meta property=og:image content="https://trjcompanylimited.com/wp-content/uploads/2021/02/TCL-Logo.png">
	<meta property=og:locale content="en-gb">
	<meta name=twitter:card content=summary_large_image>
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'trj' ); ?></a>
	<!--Message-->
		<div class="warning">
			<p class="warning-text">
				Kindly beware of fraudulent messages being circulated. TRJ Company Limited does not approve loans by SMS 					and would never request payment before approving or disbursing your loan
			</p>
			<span class="warning-del">X</span>
		</div>
		<script>
			var warning = document.querySelector(".warning");
			var warningRemove = document.querySelector(".warning-del");
			warningRemove.addEventListener("click", function(){
				warning.style.display = "none";
			})
		</script>
	<!--End Message-->
	<header id="masthead" class="site-header trj-header">
		
		</div>
		<div class="main-nav">
			<div class="site-branding">
				<?php

					the_custom_logo();

				?>
			</div>

			<nav id="site-navigation" class="main-navigation trj-nav">

				<button style="display:none;" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<?php esc_html_e( 'Primary Menu', 'trj' ); ?>
				</button>
				<div class="hamburger">
					<span></span>
					<span></span>
					<span></span>
				</div>
				
				

					<div class="menu-center">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
						?>
					</div>

					<div class="menu-right">
						<ul>
							<a href="https://trjcompanylimited.com/contact" class="trj-cta">Book A Consultation</a>
						</ul>
					</div>

			</nav>

		</div>

		<div class="mobile-menu">

			<div class="menulr">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
					?>
					<a href="https://trjcompanylimited.com/contact" class="trj-cta">Book A Consultation</a>
			</div>

		</div>
		
		<!-- Facebook Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window,document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		 fbq('init', '3434875429945261'); 
		fbq('track', 'PageView');
		</script>
		<noscript>
		 <img height="1" width="1" 
		src="https://www.facebook.com/tr?id=3434875429945261&ev=PageView
		&noscript=1"/>
		</noscript>
		<!-- End Facebook Pixel Code -->
	
	</header>
