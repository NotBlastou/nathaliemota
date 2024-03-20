<?php

function nathalie_mota_load() { 

  if( 
		! isset( $_REQUEST['nonce'] ) or 
       	! wp_verify_nonce( $_REQUEST['nonce'], 'nathalie_mota_nonce' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
      exit;
  	}


  $categorie_id = sanitize_text_field($_POST['categorie_id']);
  $format_id = sanitize_text_field($_POST['format_id']);
  $orderby = sanitize_text_field($_POST['orderby']);
  $order = sanitize_text_field($_POST['order']);
  $paged = intval($_POST['paged']);


  $custom_args = array(
    'post_type' => 'photo',
      'posts_per_page' => get_option( 'posts_per_page'), 
      'orderby' => $orderby,
      'order' => $order,
      'paged' => $paged, 
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

    $query_more = new WP_Query( $custom_args ); 

    $total_posts = get_posts( $custom_args );
    $nb_total_posts  = $query_more->found_posts;
    $max_pages = $query_more->max_num_pages;   

    $custom_args2 = array_replace($custom_args, array( 'posts_per_page' => -1, 'nopaging' => true,));
    $total_posts = get_posts( $custom_args2 );
    $nb_total_posts = count($total_posts);

    $response = '';

    if ($paged === 1) :
    ?>
    <form>                 
      <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r( $total_posts); ?>">     
      <input type='hidden' name='max_pages' id='max_pages' value='<?php echo $max_pages; ?>'>
      <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php  echo $nb_total_posts; ?>">                                   
    </form>  
  
    <?php 
    endif;

    if($query_more->have_posts()) {
      while($query_more->have_posts()) : $query_more->the_post();
        $response .= get_template_part('template-parts/post/publication');
      endwhile;        
    } else {
      $response = ''; 
    }

    wp_reset_postdata();
    exit;
  }
  add_action('wp_ajax_nathalie_mota_load', 'nathalie_mota_load');
  add_action('wp_ajax_nopriv_nathalie_mota_load', 'nathalie_mota_load');



function nathalie_mota_lightbox() {
  if( 
		! isset( $_REQUEST['nonce'] ) or 
       	! wp_verify_nonce( $_REQUEST['nonce'], 'nathalie_mota_nonce' ) 
    ) {
    	wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
      exit;
  	}


  if( ! isset( $_POST['photo_id'] ) ) {
    wp_send_json_error( "L'identifiant de la photo est manquant.", 403 );
    exit;
  }


  $photo_id = intval($_POST['photo_id']);
  

  $query_lightbox = new WP_Query([
    'post_type' => 'photo',
    'posts_per_page' => -1,
  ]);
 
$response = '';

if($query_lightbox->have_posts()) {
  while($query_lightbox->have_posts()) : $query_lightbox->the_post();
  if ( get_the_id() == $photo_id) {
    $response = get_template_part('template-parts/modal/lightbox');
  }
  endwhile;
} else {
  $response = '';

}

wp_reset_postdata();
exit;
 }
add_action('wp_ajax_nathalie_mota_lightbox', 'nathalie_mota_lightbox');
add_action('wp_ajax_nopriv_nathalie_mota_lightbox', 'nathalie_mota_lightbox');

?>