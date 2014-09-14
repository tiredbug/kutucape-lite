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
          <button type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> '. esc_attr__('Search') .'</button>
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
  wp_register_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css');
  wp_enqueue_style('bootstrap');

  wp_register_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
  wp_enqueue_style('font-awesome');
    
  wp_register_style('bootswatch_style', get_theme_mod('bootswatch_style'));
  wp_enqueue_style('bootswatch_style');
  
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

class wp_bootstrap_navwalker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if ( $args->has_children )
				$class_names .= ' dropdown';

			if ( in_array( 'current-menu-item', $classes ) )
				$class_names .= ' active';

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';

			// If item has_children add atts to a.
			if ( $args->has_children && $depth === 0 ) {
				$atts['href']   		= '#';
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle';
				$atts['aria-haspopup']	= 'true';
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			if ( ! empty( $item->attr_title ) )
				$item_output .= '<a'. $attributes .'><i class="fa ' . esc_attr( $item->attr_title ) . '"></i>&nbsp;&nbsp;';
			else
				$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';

				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';

			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ( $container )
				$fb_output .= '</' . $container . '>';

			echo $fb_output;
		}
	}
}

// Bootswatch Costumizer
function bootswatch_register_theme_customizer( $wp_customize ){
  $styles = array(
    'Amelia' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/amelia/bootstrap.min.css',
    'Cerulean' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/cerulean/bootstrap.min.css',
    'Cosmo' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/cosmo/bootstrap.min.css',
    'Cyborg' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/cyborg/bootstrap.min.css',
    'Darkly' => '//netdna.bootstrapcdn.com/bootswatch/3.2.0/darkly/bootstrap.min.css',
    'Default' => '',
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

	// add "Navbar Options" section
	$wp_customize->add_section( 'navbar_options_section' , array(
		'title'      => __( 'Navbar Options', 'theme' ),
		'priority'   => 190,
	) );
	
	// add setting for toggle checkbox
	$wp_customize->add_setting( 'navbar_toggle', array( 
		'default' => 1 
	) );
	
	// add control for toggle checkbox
	$wp_customize->add_control( 'navbar_toggle', array(
		'label'     => __( 'Inverse Navbar', 'theme' ),
		'section'   => 'navbar_options_section',
		'priority'  => 10,
		'type'      => 'checkbox'
	) );
}
add_action( 'customize_register', 'navbar_customizer' );

?>
