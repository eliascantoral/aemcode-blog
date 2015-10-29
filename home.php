<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
Template Name: Home page
*/
get_header();
?>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-9">
        <div class="main-menu hidden-sm hidden-xs">
        <?php 
            // Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)
            // This code based on wp_nav_menu's code to get Menu ID from menu slug

            $menu_name = 'main-menu';
            if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
                $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

                $menu_items = wp_get_nav_menu_items($menu->term_id);
                //var_dump($menu_items);
                $menu_list = '';

                foreach ( (array) $menu_items as $key => $menu_item ) {
                    $title = $menu_item->title;
                    $url = $menu_item->url;
                    $url_img = wp_get_attachment_url( get_post_thumbnail_id($menu_item->object_id) );
                    $menu_list .= '<div class="main-menu-item" align="center"><a href="'.$url.'"><img src="'.$url_img.'" alt="item" width="100px"></a><br><a href="' . $url . '">' . $title . '</a></div>';
                }
                $menu_list .= '';
            } else {
                $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
            }
            echo $menu_list;
        ?>  
        </div>
        <div class="clear"></div>
        <div id="resent-post-wraper">
            <?php 
                // WP_Query arguments
                $args = array (
                        'post_type'              => array( 'post' ),
                        'posts_per_page'         => '4',
                        'order'                  => 'ASC',
                        'orderby'                => 'date',                      
                );

                // The Query
                $the_query = new WP_Query( $args );  

                // The Loop
                if ( $the_query->have_posts() ) {
                        while ( $the_query->have_posts() ) {
                                $the_query->the_post();
                                $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                                ?>
                                        <div class="media">
                                          <div class="media-left media-middle">
                                              <a href="<?php the_permalink();?>">
                                                <img class="media-object" src="<?php echo $url;?>" alt="<?php echo get_the_title();?>" width="300px">
                                            </a>
                                          </div>
                                          <div class="media-body">
                                            <h4 class="media-heading"><?php echo get_the_title();?></h4>
                                            <?php echo the_excerpt_max_charlength_page(get_the_id(), 200);?>
                                          </div>
                                        </div>   
            <hr>
                                    <?php
                        }
                } else {
                        // no posts found
                }
                /* Restore original Post Data */
                wp_reset_postdata();                
            ?>
            
        </div>         
    </div>
 <div class="col-xs-6 col-sm-4 col-md-3">
      <?php get_categorylist();?>
      <?php get_taglist();?>
  
  </div>
  
</div>
<?php
get_footer();