<?php 

   $order = "";          
   $orderby = "date";

   $term = get_queried_object();
   $publication = get_queried_object_id();

   $categorie_id  =  get_post_meta( get_the_ID(), 'categorie-acf', true );   
   $format_id  =  get_post_meta( get_the_ID(), 'format-acf', true );
   $categorie_name  = my_acf_load_value('name', get_field('categorie-acf'));
     
   $custom_args = array(
      'post_type' => 'photo',
      'posts_per_page' => 2,
      'order' => $order,
      'orderby'   => $orderby,
      'meta_key' => 'categorie-acf',
      'meta_value' => $categorie_id,
      'compare'   => 'LIKE',
      'post__not_in' => array($publication),
      'nopaging' => false,
   );
   

   $query = new WP_Query( $custom_args );


   $custom_args2 = array_replace($custom_args, array( 'posts_per_page' => -1, 'nopaging' => true,));

   $total_posts = get_posts( $custom_args2 );
   $nb_total_posts = count($total_posts);

   $max_pages = $query->max_num_pages;
  
?>

  <?php if($query->have_posts()) : ?>
   <article class="container-common flexrow">

       <?php while($query->have_posts()) : ?>
           <?php $query->the_post();?> 

            <?php

               $term = get_queried_object();                                              
               $term_id  = my_acf_load_value('ID', $term);
 
               $categorie  = my_acf_load_value('name', get_field('categorie-acf')); 
            ?>
           
           <div class="news-info brightness">
               <?php if(has_post_thumbnail()) : ?>
                  <div class="thumbnail">
                     <h2 class="info-title"><?php the_title(); ?></h2>
                     <h3 class="info-tax"><?php echo $categorie; ?></h3>
                     <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" aria-label="<?php the_title(); ?>"><span class="detail-photo"></span></a>                            
                     <?php the_post_thumbnail('desktop-home'); ?>                     
                     <form>
                        <input type="hidden" name="postid" class="postid" value="<?php the_id(); ?>">
                        <button class="openLightbox" title="Afficher la photo en plein écran" alt="Afficher la photo en plein écran"
                              data-postid="<?php echo get_the_id(); ?>"            
                              data-arrow="true" 
                        >
                        </button>
                     </form>
                  </div>   
                  <?php endif; ?>
            </div>
       <?php endwhile; ?>
   </article>
   <div class="lightbox hidden" id="lightbox">    
      <button class="lightbox__close" title="Refermer le plein écran"></button>
      <div class="lightbox__container">               
         <div class="lightbox__loader hidden"></div>
         <div class="lightbox__container_info flexcolumn" id="lightbox__container_info"> 
            <div class="lightbox__container_content flexcolumn" id="lightbox__container_content"></div>   
            <button class="lightbox__next" aria-label="Voir la photo suivante" title="Photo suivante"></button>
            <button class="lightbox__prev" aria-label="Voir la photo précédente" title="Photo précédente"></button>                     
            </div>        
         </div>
      </div> 
   </div>
<?php else : ?>
   <p>Désolé, aucun article ne correspond à cette requête</p>  
<?php endif; 

  wp_reset_query();
?>


<form>
   <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r( $total_posts); ?>">
   <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php  echo $nb_total_posts; ?>">
   <input type="hidden" name="categorie_id" id="categorie_id" value="<?php echo $categorie_id; ?>">
   <input type="hidden" name="format_id" id="format_id" value="<?php echo $format_id; ?>">
   <input type="hidden" name="orderby" id="orderby" value="<?php echo $orderby; ?>">
   <input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
   <input type="hidden" name="max_pages" id="max_pages" value="<?php echo $max_pages; ?>">
   <input type="hidden" name="ajaxurl" id='ajaxurl' value="<?php echo admin_url( 'admin-ajax.php' ); ?>">

   <input type="hidden" name="nonce" id='nonce' value="<?php echo wp_create_nonce( 'nathalie_mota_nonce' ); ?>" > 
</form>  

