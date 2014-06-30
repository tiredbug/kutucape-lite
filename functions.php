<?php

add_theme_support('post-thumbnails');

register_nav_menu('top-bar', __('Primary Menu'));

wp_enqueue_script('jquery');

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

class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {

  function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
    $id_field = $this->db_fields['id'];
    if(!empty($children_elements[$element->$id_field])) {
      $element->classes[] = 'dropdown';
        $element->title .= ' <b class="caret"></b>';
    }
      Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }

  function start_lvl( &$output ) {
    $classes = array( 'sub-menu dropdown-menu' );
    $class_names = implode( ' ', $classes );
    // build html
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
  }
    
}

?>
