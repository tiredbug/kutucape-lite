<?php

// Add page on theme activation and set it as homepage automatically
if (isset($_GET['activated']) && is_admin()){
    add_action('init', 'theme_frontpage_setup');
}

function theme_frontpage_setup(){
 if(get_option('page_on_front')=='0' && get_option('show_on_front')=='posts'){
        // Create frontpage
        $frontpage = array(
            'post_type'    => 'page',
            'post_title'    => 'Frontpage',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1
        ); 
        // Insert the post into the database
        $frontpage_id =  wp_insert_post( $frontpage );
        // Set the page template 
        update_post_meta($frontpage_id, '_wp_page_template', 'frontpage.php');
	// Set static front page
	$staticpage = get_page_by_title( 'Frontpage' );
	update_option( 'page_on_front', $staticpage->ID );
	update_option( 'show_on_front', 'page' );
    }
}

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
  function start_lvl( &$output ) {
    $classes = array( 'sub-menu dropdown-menu' );
    $class_names = implode( ' ', $classes );
    // build html
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
  }    
}

?>
