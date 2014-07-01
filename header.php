<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> <?php wp_title('•', true, ''); ?></title>

  <!-- Shortcut Icon -->
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">

  <!-- Bootstrap -->
  <link rel="stylesheet" id="bootstrap-css"  href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" media="all" />

  <!-- Font Awesome -->
  <link rel="stylesheet" id="font-awesome-css"  href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" type="text/css" media="all" />

  <!-- Costumize CSS -->
  <link rel="stylesheet" id="style-css"  href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <?php wp_head(); ?>
  
</head>

<body <?php body_class(); ?>>

<!--[if lt IE 8]>
<div class="alert alert-warning">
  You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
</div>
<![endif]-->    

<!-- Navbar -->
<nav class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>
    </div><!-- /.navbar-header -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">    
      <?php				
        $args = array(
          'theme_location' => 'primary',
          'depth' => 0,
          'container'	=> false,
          'fallback_cb' => false,
          'menu_class' => 'nav navbar-nav',
          'walker' => new Bootstrap_Walker_Nav_Menu()
        );
        wp_nav_menu($args);
      ?>
    </div><!-- /.navbar-collapse -->
  </div>
</nav>
<!-- End Navbar -->

<?php if ( !is_page('frontpage') ) : ?>
<!-- Header -->
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h1 class="site-title"> 
      <a class="text-muted" href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a>
      </h1>
      <h4 class="site-description"><?php bloginfo('description'); ?></h4>
    </div>
  </div>
  <hr/>
</div>
<!-- End Header -->
<?php endif; ?>
