<?php get_header(); ?>

<div class="container">
  <div class="row row-offcanvas row-offcanvas-right">
    
    <div class="col-xs-12 col-sm-8">
      <p class="pull-right visible-xs">
        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle Sidebar</button>
      </p>      
      <div id="content" role="main">
        <?php if(have_posts()): while(have_posts()): the_post();?>
        <article role="article" id="post_<?php the_ID()?>" <?php post_class()?>>
          <header>
            <h2><?php the_title()?></h2>
            <hr/>
          </header>
          <?php the_content()?>
        </article>
        <?php endwhile; ?> 
        <?php else: ?>
        <?php wp_redirect(get_bloginfo('siteurl').'/404', 404); exit; ?>
        <?php endif;?>
      </div><!-- #content -->
    </div>
    
    <div class="col-xs-6 col-sm-4 sidebar-offcanvas sidebar" id="sidebar" role="navigation">
        <?php get_sidebar(); ?>
    </div><!-- /.col-sm-4 .sidebar -->
    
<?php get_footer(); ?>
