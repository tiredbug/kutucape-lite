<?php
/*
Template Name: Page Canvas
*/
?>

<?php get_header(); ?>

<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12">
      <?php if(have_posts()): while(have_posts()): the_post();?>
        <?php the_content()?>
      <?php endwhile; else: endif;?>
    </div>
  </div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
