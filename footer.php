<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shedrub_network
 */

?>
<?php 
$copyright_info = get_field('copyright_info', 'option');
?>
<footer id="main-footer" class="site-footer">
        <div class="container">
            <p>Copyright © <?php echo date('Y'). ' '.$copyright_info;?></p>
            <ul class="social-links">
            <?php 
            $copyright_info = get_field('copyright_info', 'option');
            $social_links = get_field('social_links', 'option');
            if ( have_rows( 'social_links','option' ) ) 
            {
            while ( have_rows( 'social_links','option' ) ) :
            the_row();
            $image_url  = get_template_directory_uri().'/dist/images/facebook.svg';
            $get_image = get_sub_field( 'social_logo');             
            if ( ! empty( $get_image ) ) {
                $image_url = $get_image['sizes']['social_logo'];
            }
            $link = get_sub_field( 'link');
            ?>
            <li><a href="<?php echo $link;?>" target="_blank"><img src="<?php echo $image_url;?>" alt="social link"></a></li>
            <?php
            endwhile;
            }
            ?>
            </ul>
        </div>
    </footer>
    <!-- /site-footer -->
	<?php wp_footer(); ?>
</body>
</html>