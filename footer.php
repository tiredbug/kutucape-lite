<hr/>
<div class="container">
  <div class="row">
    <div class="col-lg-12 footer">
      <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>.</p>
    </div>
  </div><!-- .row -->
</div><!-- .container -->

<?php wp_footer(); ?>

 <!-- addClass to reply button and data-toogle dropdown for Walker Nav Menu -->
<script type="text/javascript">
  $j=jQuery.noConflict();
  $j(document).ready(function(){
    $j(".comment-reply-link").addClass("btn btn-default");
    $j('.dropdown > a').attr("data-toggle", "dropdown");
    $j('[data-toggle="offcanvas"]').click(function () {
      $j('.row-offcanvas').toggleClass('active')
    });
  });
</script>

</body>
</html>
