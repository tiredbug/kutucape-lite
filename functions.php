<?php

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
      <div class="form-group">
        <input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" />
      </div>
      <button type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> '. esc_attr__('Search') .'</button>
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
  wp_register_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css');
  wp_enqueue_style('bootstrap');

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
  return is_array($var) ? array_intersect($var, array('dropdown')) : '';
}
add_filter('nav_menu_css_class', 'nav_class_filter', 100, 1);
add_filter('nav_menu_item_id', '__return_null');

?>
