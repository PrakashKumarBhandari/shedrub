<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shedrub_network
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">    
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri();?>/dist/images/favicon/apple-touch-icon-180x180.png" />
	<?php wp_head(); ?>
</head>
<body>
<?php 
$site_logo = get_field('site_title', 'site_logo');
$site_title = get_field('site_title', 'option');
$site_slogon = get_field('site_slogon', 'option');
$top_menu_tootle_shortcode = get_field('menu_tootle_shortcode', 'option');
?>
<?php wp_body_open(); ?>
<header id="masthead" class="site-header">        
    <?php echo do_shortcode($top_menu_tootle_shortcode);?>

    <nav class="mobile-header d-md-none">
        <a href="javascript:void(0);" class="open-mobile-nav">
            <img src="<?php echo get_template_directory_uri();?>/dist/images/menu-navigation-icon.svg" alt="hamburger-icon">
        </a>
        <h3>Shedrub</h3>
        <select name="lang" class="mobile-language-selector">
            <option value="" selected="">en</option>
            <option value="">de</option>
            <option value="">es</option>
            <option value="">ru</option>
            <option value="">中文</option>
            <option value="">vi</option>
        </select>
    </nav>

    <section id="main-banner" class="site-main-banner">
        <div class="mainBanner-carousel owl-carousel">
            <?php 
            $default_banner = get_template_directory_uri().'/dist/images/banner_img1.jpg';
            if ( have_rows( 'slider_or_banner_images' ) ) 
            {
            while ( have_rows( 'slider_or_banner_images' ) ) :
            the_row();
            $image_url  = get_template_directory_uri().'/dist/images/banner_img1.jpg';
            $get_image = get_sub_field( 'image' );
            
            if ( ! empty( $get_image ) ) {
                $image_url = $get_image['sizes']['home_page_slider'];
            }
            ?>
            <div class="main-banner-item" style='background-image: url("<?php echo $image_url;?>");'></div>
            <?php 
            endwhile;  
            }
            else{
            ?>
            <div class="main-banner-item" style='background-image: url("<?php echo $default_banner;?>");'></div>
            <?php
            }         
            ?>
        </div>
        <hgroup>
            <h1 class="d-none d-md-block"><?php echo $site_title? $site_title : _e('Shedrub','shedrub_network'); ?></h1>
            <h2><?php echo $site_slogon? $site_slogon : _e('The Online Home of Chokyi Nyima Rinpoche','shedrub_network'); ?> </h2>
        </hgroup>
        <ul class="nav language-menu d-none d-md-flex">
            <li class="nav-item"><a class="nav-link active disabled">en</a></li>
            <li class="nav-item"><a class="nav-link" href="">de</a></li>
            <li class="nav-item"><a class="nav-link" href="">rs</a></li>
            <li class="nav-item"><a class="nav-link" href="">ru</a></li>
            <li class="nav-item"><a class="nav-link" href="">中文</a></li>
            <li class="nav-item"><a class="nav-link" href="">vi</a></li>
        </ul>
    </section>

    <nav id="main-header-navigation" class="site-navigation">
        <a href="javascript:void(0);" class="close-mobile-nav"><img src="<?php echo get_template_directory_uri();?>/dist/images/menu-mobile-close.white.svg" alt="close"></a>
        <div class="container">
            <?php
            clean_custom_menu('primary_menu');
            ?>
        </div>
    </nav>
</header>