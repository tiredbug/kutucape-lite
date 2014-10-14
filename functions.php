<?php

// Add page on theme activation and set bootswatch_style automatically
if (isset($_GET['activated']) && is_admin()){
  add_action('init', 'theme_setup_init');
}
function theme_setup_init(){
  if(get_option('page_on_front')=='0' && get_option('show_on_front')=='posts'){
    // Create frontpage
    $frontpage = array(
      'post_type'    => 'page',
      'post_title'    => 'Frontpage',
      'post_content'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consequat, orci ac laoreet cursus, dolor sem luctus lorem, eget consequat magna felis a magna. Aliquam scelerisque condimentum ante, eget facilisis tortor lobortis in. In interdum venenatis justo eget consequat. Morbi commodo rhoncus mi nec pharetra. Aliquam erat volutpat. Mauris non lorem eu dolor hendrerit dapibus. Mauris mollis nisl quis sapien posuere consectetur. Nullam in sapien at nisi ornare bibendum at ut lectus. Pellentesque ut magna mauris. Nam viverra suscipit ligula, sed accumsan enim placerat nec. Cras vitae metus vel dolor ultrices sagittis. Duis venenatis augue sed risus laoreet congue ac ac leo. Donec fermentum accumsan libero sit amet iaculis. Duis tristique dictum enim, ac fringilla risus bibendum in. Nunc ornare, quam sit amet ultricies gravida, tortor mi malesuada urna, quis commodo dui nibh in lacus. Nunc vel tortor mi. Pellentesque vel urna a arcu adipiscing imperdiet vitae sit amet neque. Integer eu lectus et nunc dictum sagittis. Curabitur commodo vulputate fringilla. Sed eleifend, arcu convallis adipiscing congue, dui turpis commodo magna, et vehicula sapien turpis sit amet nisi.',
      'post_status'   => 'publish',
      'post_author'   => 1
    ); 
    // Insert the post into the database
    $frontpage_id =  wp_insert_post( $frontpage );
    // Set the page template 
    update_post_meta($frontpage_id, '_wp_page_template', 'page-canvas.php');
    // Set static front page
    $staticpage = get_page_by_title( 'Frontpage' );
    update_option( 'page_on_front', $staticpage->ID );
    update_option( 'show_on_front', 'page' );
  }
  set_theme_mod( 'bootswatch_style', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' );
}

// Clean up wp_head()
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Remove the annoying:
// <style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
add_filter( 'show_recent_comments_widget_style', '__return_false' );

// Add Post Thumbnails Support
add_theme_support('post-thumbnails');

// Register Menu Support
register_nav_menu('primary', __('Primary Menu'));

// Register widgets support for theme
function theme_widgets_init() {
  register_sidebar( array(
    'name' => __( 'Sidebar', 'theme' ),
    'id' => 'sidebar-widget-area',
    'description' => __( 'The sidebar widget area', 'theme' ),
    'before_widget' => '<section class="%1$s %2$s">',
    'after_widget' => '</section>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ) );
}
add_action( 'widgets_init', 'theme_widgets_init' );

// Replace searh form
function theme_search_form( $form ) {
  $form = '
    <form class="form-inline" role="search" method="get" id="searchform" action="' . home_url('/') . '" >
      <div class="input-group">
        <input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" />
        <span class="input-group-btn">
          <button type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> '. esc_attr__('Go') .'</button>
        </span>
      </div>
    </form>';
    return $form;
}
add_filter( 'get_search_form', 'theme_search_form' );

// Add favicon 
function blog_favicon() { ?>
<link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory') ?>/favicon.ico" >
<?php }
add_action('wp_head', 'blog_favicon');

// Add Enqueues
function theme_enqueues()
{

  wp_register_style('bootswatch_style', get_theme_mod('bootswatch_style'));
  wp_enqueue_style('bootswatch_style');

  wp_register_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
  wp_enqueue_style('font-awesome');
    
  wp_register_style('style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('style');

  wp_deregister_script('jquery');
  wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', '', '', true );
  wp_enqueue_script('jquery');

  wp_register_script('modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.min.js', '', '', true );
  wp_enqueue_script('modernizr');

  wp_register_script('html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.min.js', '', '', true );
  wp_enqueue_script('html5shiv');

  wp_register_script('respond', '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js', '', '', true );
  wp_enqueue_script('respond');

  wp_register_script('bootstrapjs', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js', '', '', true );
  wp_enqueue_script('bootstrapjs');

  if (is_singular() && comments_open() && get_option('thread_comments')) {
  wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'theme_enqueues', 100);

// Simple WordPress Walker Nav Menu extends for Bootstrap 
class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
  function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
    $id_field = $this->db_fields['id'];
    if(!empty($children_elements[$element->$id_field])) {
      $element->classes[] = 'dropdown';
        $element->title .= ' <b class="caret"></b>';
    }
      Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $classes = array( 'sub-menu dropdown-menu' );
    $class_names = implode( ' ', $classes );
    // build html
    $indent = str_repeat( "\t", $depth );
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
  }    
}

// Reduce nav classes, leaving only 'dropdown'
function nav_class_filter( $var ) {
  return is_array($var) ? array_intersect($var, array('current-menu-item', 'dropdown')) : '';
}
add_filter('nav_menu_css_class', 'nav_class_filter', 100, 1);
add_filter('nav_menu_item_id', '__return_null');

// Bootswatch Costumizer
function bootswatch_register_theme_customizer( $wp_customize ){
  $styles = array(
    'Amelia' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/amelia/bootstrap.min.css',
    'Cerulean' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/cerulean/bootstrap.min.css',
    'Cosmo' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/cosmo/bootstrap.min.css',
    'Cyborg' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/cyborg/bootstrap.min.css',
    'Darkly' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/darkly/bootstrap.min.css',
    'Default' => '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
    'Flaty' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/flatly/bootstrap.min.css',
    'Journal' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/journal/bootstrap.min.css',
    'Lumen' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/lumen/bootstrap.min.css',
    'Paper' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/paper/bootstrap.min.css',
    'Readable' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/readable/bootstrap.min.css',
    'Sandstone' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/sandstone/bootstrap.min.css',
    'Simplex' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css',
    'Slate' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/slate/bootstrap.min.css',
    'Spacelab' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/spacelab/bootstrap.min.css',
    'Superhero' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/superhero/bootstrap.min.css',
    'United' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/united/bootstrap.min.css',
    'Yeti' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/yeti/bootstrap.min.css'
  );
  $labels = array_flip( $styles );
  $wp_customize->add_section(
    'bootswatch_themes',
    array(
      'title'     => 'BootSwatch Themes',
      'priority'  => 200
    )
  );
  $wp_customize->add_setting(
    'bootswatch_style',
      array(
        'default'     => '',
        #'transport'   => 'postMessage'
      )
  );
  $wp_customize->add_control(
    'bootswatch_style',
    array(
      'section'		=> 'bootswatch_themes',
      'label'		=> __( 'Bootswatch Theme', 'theme' ),
      'type'		=> 'select',
      'choices'		=> $labels,
      'settings'	=> 'bootswatch_style'
    )
  );
}
add_action( 'customize_register', 'bootswatch_register_theme_customizer' );

function navbar_customizer( $wp_customize ) {
  $wp_customize->add_section( 'navbar_options_section' , array(
    'title'      => __( 'Navbar Options', 'theme' ),
    'priority'   => 190,
  ) );
  $wp_customize->add_setting( 'navbar_toggle', array( 
    'default' => 0 
  ) );
  $wp_customize->add_control( 'navbar_toggle', array(
    'label'     => __( 'Inverse Navbar', 'theme' ),
    'section'   => 'navbar_options_section',
    'priority'  => 10,
    'type'      => 'checkbox'
  ) );
}
add_action( 'customize_register', 'navbar_customizer' );

?>
