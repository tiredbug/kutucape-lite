<hr/>
<div class="container">
  <div class="row">
    <div class="col-sm-12 footer text-center">
      <p>Proudly powered by <a href="http://wordpress.org">WordPress</a> &middot; <a href="http://getbootstrap.com">Twitter Bootstrap</a> &middot; <a href="http://fontawesome.io">Font Awesome</a> &middot; <a href="http://bootswatch.com">Bootswatch</a> &middot; <a href="http://tiredbug.com/kutu-kutu">Kutu Kutu</a></p>
      <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a></p>
    </div>
  </div><!-- .row -->
</div><!-- .container -->

<?php wp_footer(); ?>

<script type="text/javascript">
  $j=jQuery.noConflict();
  $j(document).ready(function(){
    $j(".comment-reply-link").addClass("btn btn-default");
    $j('[data-toggle="offcanvas"]').click(function () {
      $j('.row-offcanvas').toggleClass('active')
    });
    $j('.dropdown > a').attr("data-toggle", "dropdown");
  });
</script>

</body>
</html>
