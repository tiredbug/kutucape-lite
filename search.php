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
           <h4><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h4> 
            <hr/>
          </header>
          <?php the_excerpt()?>
        </article>
        <?php endwhile; ?> 
        <?php else: ?>
        <div class="alert alert-warning">
          <i class="glyphicon glyphicon-exclamation-sign"></i> Sorry, your search yielded no results.
        </div>
        <?php endif;?>
      </div><!-- #content -->
    </div>
    
    <div class="col-xs-6 col-sm-4 sidebar-offcanvas sidebar" id="sidebar" role="navigation">
        <?php get_sidebar(); ?>
    </div><!-- /.col-sm-4 .sidebar -->

  </div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
