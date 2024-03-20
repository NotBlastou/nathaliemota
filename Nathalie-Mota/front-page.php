<?php


    get_header();
?>
  <div id="front-page"> 
      <section id="content">    

        <?php get_template_part( 'template-parts/header/hero' ); ?>
        

        <?php get_template_part( 'template-parts/post/photo-filter' ); ?>
        
        
        <?php  

        $categorie_id = "";
        $format_id = "";
        $order = "";
        $orderby = "date";
         
 

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $term = get_queried_object();
        $term_id  = my_acf_load_value('ID', $term);


        $custom_args = array(
        'post_type' => 'photo',
        // 'posts_per_page' => 8,
        'posts_per_page' => get_option( 'posts_per_page'), 
        'order' => $order, 
        'orderby' =>  $orderby, 
        'paged' => 1,
        'meta_query'    => array(
            'relation'      => 'AND', 
            array(
                'key'       => 'categorie-acf',
                'compare'   => 'LIKE', 
                'value'     =>  $categorie_id,
            ),
            array(
                'key'       => 'format-acf',
                'compare'   => 'LIKE',
                'value'     => $format_id,
            )
            ),
            'nopaging' => false,
            );            

            $query = new WP_Query( $custom_args ); 
            $max_pages = $query->max_num_pages;

            $custom_args2 = array_replace($custom_args, array( 'posts_per_page' => -1, 'nopaging' => true,));
            $total_posts = get_posts( $custom_args2 );
            $nb_total_posts = count($total_posts);          
                      
            ?>

            <?php if($query->have_posts()) : ?>
                <article class="publication-list container-news flexrow">

                    <form> 
                        <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r( $total_posts); ?>">     
                        <input type='hidden' name='max_pages' id='max_pages' value='<?php echo $max_pages; ?>'>
                        <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php  echo $nb_total_posts; ?>">
                    </form> 

                    <?php while($query->have_posts()) : $query->the_post();               
                            get_template_part('template-parts/post/publication');
                        endwhile; 
                    ?>
                </article>
                <div class="lightbox hidden" id="lightbox">    
                    <button class="lightbox__close" title="Refermer cet agrandissement">Fermer</button>
                    <div class="lightbox__container">
                        <div class="lightbox__loader hidden"></div>
                        <div class="lightbox__container_info flexcolumn" id="lightbox__container_info"> 
                            <div class="lightbox__container_content flexcolumn" id="lightbox__container_content"></div>   
                            <button class="lightbox__next" aria-label="Voir la photo suivante" title="Photo suivante"></button>
                            <button class="lightbox__prev" aria-label="Voir la photo précente" title="Photo précédente"></button>                     
                        </div>
                    </div> 
                </div>
            <?php else : ?>
                <p>Désolé. Aucun article ne correspond à cette demande.</p>          
            
            <?php endif; ?>
        
        <?php

        wp_reset_postdata();       
        ?>
        
        <div id="pagination">

            <form>
                <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
                <input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
                <input type="hidden" name="posts_per_page" id="posts_per_page" value="<?php echo get_option( 'posts_per_page'); ?>">
                <input type="hidden" name="currentPage" id="currentPage" value="<?php  echo $paged; ?>">
                <input type="hidden" name="ajaxurl" id='ajaxurl' value="<?php echo admin_url( 'admin-ajax.php' ); ?>">
                
                <input type="hidden" name="nonce" id='nonce' value="<?php echo wp_create_nonce( 'nathalie_mota_nonce' ); ?>" > 

                <?php if ($max_pages > 1): ?>
                    <button class="btn_load-more" id="load-more">Charger plus</button>
                    <span class="camera"></span>
                <?php endif ?>
            </form>                 
        </div>
      </section>   

  </div>
<?php get_footer(); ?>