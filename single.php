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
            <h5>
              <em>
                <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php the_time('jS F Y') ?></time>
                <span class="text-muted" class="author">by <?php the_author() ?> under <?php _e(''); ?> <?php the_category(', ') ?> with <?php comments_popup_link('None', '1', '%'); ?> comments.</span>
              </em>
            </h5>
            <hr/>
          </header>
          <?php the_post_thumbnail(); ?>
          <?php the_content()?>
          <hr/>
        </article>
        <?php comments_template(); ?>
        <?php endwhile; ?>
        <?php else: ?>
        <?php wp_redirect(get_bloginfo('siteurl').'/404', 404); exit; ?>  
        <?php endif;?>
      </div><!-- #content -->
    </div>
    
    <div class="col-xs-6 col-sm-4 sidebar-offcanvas sidebar" id="sidebar" role="navigation">
        <?php get_sidebar(); ?>
    </div><!-- /.col-sm-4 .sidebar -->
    
  </div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
