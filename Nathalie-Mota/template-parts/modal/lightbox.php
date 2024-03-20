<?php

$term = get_queried_object();
 $term_id  = my_acf_load_value('ID', $term);
 $refPhoto = "";
 if (get_field('reference')) {
     $refPhoto = get_field('reference');
 }; 

 $categorie  = my_acf_load_value('name', get_field('categorie-acf'));

?>
<?php the_post_thumbnail('lightbox'); ?>
<div class="lightbox__info flexrow">
     <p class="photo-category-<?php the_id(); ?>"><?php echo $refPhoto; ?></p>
    <p class="photo-year-<?php the_id(); ?>"><?php echo the_time( 'Y' ); ?></p>
</div> 