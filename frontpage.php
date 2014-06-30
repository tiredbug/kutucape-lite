<?php
/*
Template Name: Frontpage Template
*/
?>

<?php get_header(); ?>
    
<?php if(have_posts()): while(have_posts()): the_post();?>
  <?php the_content()?>
  <?php endwhile; ?> 
  <?php else: ?>
  <?php wp_redirect(get_bloginfo('siteurl').'/404', 404); exit; ?>
<?php endif;?>
    
<?php get_footer(); ?>
