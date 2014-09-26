<?php get_header(); ?>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div id="content" role="main">
        <div class="alert alert-warning alert-404 text-center">
          <h1><i class="glyphicon glyphicon-warning-sign"></i> Error 404</h1>
          <p>The page you were looking for does not exist.</p>
          <p><?php get_search_form(); ?></p>
        </div>
      </div><!-- #content -->
    </div><!-- .col-sm-12 -->
  </div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
