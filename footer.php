<hr/>
  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>.</p>
        </div>
      </div>
    </div>
  </div>

<?php wp_footer(); ?>

 <!-- addClass to reply button and data-toogle dropdown for Walker Nav Menu -->
<script type="text/javascript">
  $j=jQuery.noConflict();
  $j(document).ready(function(){
    $j(".comment-reply-link").addClass("btn btn-default");
    $j('.dropdown > a').attr("data-toggle", "dropdown");
  });
  
</script>

</body>
</html>
