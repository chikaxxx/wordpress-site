<!DOCTYPE html>
<?php
	global $is_IE;
	global $is_edge;
	global $is_gecko;
	global $is_chrome;
	global $old_android;

	if(wp_is_mobile()) {
		preg_match("/(Android\s([0-9\.]*))/", $_SERVER['HTTP_USER_AGENT'], $result);
		if (count($result)){
			$version = $result[2];
			list($major, $minor) = explode(".", $version);
		}
		$browserClass = '';
		if(is_android()) {
			$browserClass = 'is-android';
		}
		if (count($result)){
			if ($version <= 4.4){
				$browserClass = 'is-android is-android-old';
				$old_android = true;
			}
		}
	} else {
		$browserClass = '';
		if($is_IE){
			$browserClass = 'is-ie is-ie11';
		} else if($is_edge) {
			$browserClass = 'is-ie is-edge';
		} else if($is_gecko) {
			$browserClass = 'is-firefox';
		} else if($is_chrome) {
			$browserClass = 'is-chrome';
		}
	}
?>

<html lang="<?php bloginfo( 'language' ) ?>" class="<?php echo $browserClass;?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>" />

	<?php if(wp_is_mobile()):?>
		<meta name="viewport" content="width=device-width">
	<?php endif; ?>

	<title><?php echo get_page_title(); ?></title>
	<meta name="description" content="<?php echo get_page_description(); ?>">
	<!-- OG -->
	<?php
		$ogfield = get_field('og_image', 'options');
		$ogimage = get_OG_image($ogfield);
	?>
	<meta name="og:image" content="<?php echo esc_url( home_url( '/' ) ); ?><?php echo $ogimage; ?>">
	<meta property="og:title" content="<?php $page_title =  get_page_title(); echo $page_title ?>" >
	<meta property="og:url" content="<?php echo esc_url( home_url( '/' )); ?>" >
	<meta property="og:description" content="<?php echo get_page_description(); ?>" >
	<meta property="og:type" content="article" >

	<link rel="icon" href="<?php echo esc_url( home_url( '/' )); ?>favicon.ico">

	<?php if(wp_is_mobile()):?>
		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/stylesheets/style.sp.css?<?php echo file_date(get_template_directory() . '/stylesheets/style.sp.css'); ?>">
	<?php else : ?>
		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/stylesheets/style.pc.css?<?php echo file_date(get_template_directory() . '/stylesheets/style.pc.css'); ?>">
	<?php endif; ?>
</head>
<body <?php body_class('js-navigation'); ?>>
<div class="ly-wrapper">
	<div class="ly-header">
		<div class="inner">
			<h1 class="logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo get_bloginfo('name'); ?>
				</a>
			</h1>

			<?php if ( !is_404() ) : ?>

			<?php if ($old_android ) {
				$icon_animation_type = 'slider';
			} else {
				$icon_animation_type = 'squeeze';
			};?>

			<div class="btn-nav js-navigation-btn">
				<button class="hamburger hamburger--<?php echo $icon_animation_type; ?>" type="button">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</button>
			</div>

			<nav class="navigation js-navigation-contents">
				<ul>
					<li class="menu"><a class="js-navigation-item" href="#anc-menu"><span>MENU 01</span></a></li>
					<li class="menu"><a class="js-navigation-item" href="#anc-menu"><span>MENU 02</span></a></li>
					<li class="menu"><a class="js-navigation-item" href="#anc-menu"><span>MENU 03</span></a></li>
				</ul>
			</nav>
			<?php endif; ?>

		</div>
	</div>