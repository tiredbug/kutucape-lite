<hr/>
  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>. <select></select></p>
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
    $j('[data-toggle="offcanvas"]').click(function () {
      $j('.row-offcanvas').toggleClass('active')
    });
  });
  $j.get("http://api.bootswatch.com/3/", function (data) {
    var themes = data.themes;
    var select = $j("select");
    select.show();
    $j(".alert").toggleClass("alert-info alert-success");
    $j(".alert h4").text("Success!");
  
    themes.forEach(function(value, index){
      select.append($j("<option />")
            .val(index)
            .text(value.name));
    });
  
    select.change(function(){
      var theme = themes[$j(this).val()];
      $j("link").attr("href", theme.css);
    }).change();

  }, "json").fail(function(){
      $j(".alert").toggleClass("alert-info alert-danger");
      $j(".alert h4").text("Failure!");
  });
</script>

</body>
</html>
