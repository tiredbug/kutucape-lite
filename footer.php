<hr/>

<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
	      <span class="pull-left">&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>.</span>
	      <span class="pull-right">Proudly powered by <a href="http://wordpress.org">WordPress</a> and <a href="http://getbootstrap.com">Twitter Bootstrap 3</a>.</span>
      </div>
    </div>
  </div>
</div>

<?php wp_footer(); ?>

<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
$j=jQuery.noConflict();
$j(document).ready(function(){
  $j(".comment-reply-link").addClass("btn btn-default");
  $j('.dropdown > a').attr("data-toggle", "dropdown");
});
</script>

</body>
</html>
