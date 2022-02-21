<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package shedrub_network
 */
get_header();
?>
<main class="main" role="main">
    <div class="content-area">
        <div class="primary-content">
            <div class="text-container">
                <?php
                    the_content();
                ?>
            </div>
            
            <div class="category-large-nav">
                <ul class="gridder">
                <?php
                global $post;
                $featured_tab_lists = get_posts( array(
                    'offset' => 0,
                    'posts_per_page' =>6,
                    'post_type'      => 'tab-feature'
                ));
                
                $counter_main = 1;
                if ( $featured_tab_lists ) {
                foreach ( $featured_tab_lists as $post ) : 
                setup_postdata( $post );               
                
                $svg_image = get_field('svg_image_code');      
                $color_code = get_field('color_code');               
                $ture  = 'false';
                if($counter_main == 1){  $ture ='true'; }
                ?>
                   <li class="gridder-list " style="color:<?php echo $color_code;?>!important"  data-griddercontent="#gridder-content-<?php echo get_the_ID();?>">
                        <div class="inner-gridder-content">
                        <i><?php echo $svg_image;?></i>
                        <h3><?php the_title();?></h3>
                        <p><?php the_field('short_detail');?></p>
                        </div>
                    </li>
                <?php                    
                $counter_main++;
                endforeach;
                }       
                ?>
                </ul>                
                <div class="tab-content" id="categoryTabContent">
                <?php
                $counter = 1;
                if ( $featured_tab_lists ) {
                foreach ( $featured_tab_lists as $post ) : 
                setup_postdata( $post );
                $color_code = get_field('color_code');        
                ?>                                       
                    <div id="gridder-content-<?php echo get_the_ID();?>" class="gridder-content">
                        <div class=" row gx-5" style="color:<?php echo $color_code;?>!important;">
                            <div class="col-md-4">
                                <div class="description">
                                    <p><?php the_field('short_detail');?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="sites">
                                    <?php
                                    if ( have_rows( 'domain_feature_list' ) ) :
                                    while ( have_rows( 'domain_feature_list' ) ) :
                                    the_row();         
                                    ?>
                                    <li class="site">
                                        <h3 style="color:<?php echo $color_code;?>!important;"><?php the_sub_field('title');?></h3>
                                        <a href="<?php echo addUrlLink(strtolower(get_sub_field('domain_name')));?>" target="_blank" style="color:<?php echo $color_code;?>!important;"><?php the_sub_field('domain_name');?></a>
                                        <p><?php the_sub_field('details');?></p>
                                    </li>
                                    <?php
                                    endwhile;  
                                    endif;
                                    ?>                                
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
                }
                ?> 
            </div>
            </div>
        </div>
        <div class="secondary-content">
            <div class="news-list">
                <?php
                global $post;
                $post_lists = get_posts( array(
                    'offset' => 0,
                    'posts_per_page' =>4,
                    'post_type'      => 'post'
                ));

                if ( $post_lists ) {
                foreach ( $post_lists as $post ) : 
                setup_postdata( $post );
                
                $postcat = get_the_category( get_the_ID() );
                $cat_id = '';
                if ( ! empty( $postcat ) ) {
                    $cat_id =  $postcat[0]->cat_ID;
                }
                $color_val = get_field('category_font_color','category_'.$cat_id);
                ?> 

                <article class="international-centers" >
                    <h2 ><a href="<?php the_permalink();?>" style="color:<?php echo $color_val;?>!important"><?php the_title();?></a></h2>                    
                    <time datetime="<?php echo get_the_date('F jS Y');?>"><?php echo get_the_date('F j');?><sup><?php echo get_the_date('S');?></sup>, <?php echo get_the_date('Y');?></time>
                    <p><?php echo wordlimit(get_the_excerpt(),'15','...');?></p>
                </article>
                <?php
                endforeach;
                wp_reset_postdata();
                }
                ?>
            </div>
            <a href="/news" class="more-news">› More news</a>
        </div>
    </div>
</main>
<?php
get_footer();
