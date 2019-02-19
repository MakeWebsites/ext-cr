<?php
/*
Plugin Name: Extended-CR
Description: Extensions to ClimaRisk Genesis sites
Version: 1.0
Author: Angel Utset
License: GPLv2
*/

//* Enqueue Lato Google font
/*add_action( 'wp_enqueue_scripts', 'cr_load_google_fonts' );
function cr_load_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}*/

//Registering bootstrap
function cr_registers () {
	
	wp_deregister_script('jquery'); //Deregister custom WordPress Jquery
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'); // Registering Google lib
	wp_enqueue_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'); // Registering Bootstrap 4
    wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
	wp_enqueue_style( 'cr-css', plugin_dir_url( __FILE__ ).'css/cr.css');
	wp_enqueue_script('cr-js', plugin_dir_url( __FILE__ ).'js/cr.js');
}
add_action('wp_enqueue_scripts', 'cr_registers');

//Remove header
add_action('get_header', 'cr_remove_header');
function cr_remove_header() {
remove_action( 'genesis_header', 'genesis_do_header' );
}
//Custom header
add_action ('genesis_header', 'cr_custom_header');
function cr_custom_header() { ?>
<div class="row pt-1">
<div class="col-7">
<a href="<?php echo site_url() ?>/contact/" title="Contact ClimaRisk">
	<img  width="250" class="img-fluid float-left align-middle imgs imheader" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/climarisk-header.gz" 
		alt="ClimaRisk"></a></div>
		<div class="col-5">
		<a href="https://climarisk.com/es"> <img class="img-fluid float-right mt-2 pt-1 imgs" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/es.gz" 
		alt="ClimaRisk en español" title="ClimaRisk en español"></a>
		<a href="https://twitter.com/Clima_Risk" target="_blank"> <img class="img-fluid rounded float-right align-top mt-2 mr-4 imgs" style="height:20%;" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/twitter-climarisk.gif" 
		alt="ClimaRisk Twitter" title="ClimaRisk Twitter"></a>
		<a href="https://www.facebook.com/climarisk/" target="_blank"> <img class="img-fluid rounded float-right align-top mt-2 mr-4 imgs" style="height:20%;" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/facebook-climarisk.png" 
		alt="ClimaRisk Facebook site" title="ClimaRisk Facebook site"></a></div>
</div>
	 <?php
}

function find_browser () {
$info = $_SERVER['HTTP_USER_AGENT'];
 if(strpos($info,"Chrome") == true) {
	$browser = "Chrome";
 }
 	elseif (strpos($info,"Firefox") == true) {
		$browser="Firefox";
	}
		elseif (strpos($info,"IE") == true)
		$browser = "IE"; 
		else
		$browser = "Other";	
return $browser;
}	
	
//* Customize the Genesis credits
add_filter( 'genesis_footer_creds_text', 'cr_footer_creds_text' );
function cr_footer_creds_text() { ?>
	<div class="float-left">Copyright &copy
	<?php echo date('Y'); ?>
	&middot
	<a href="http://climarisk.com" title="ClimaRisk">
	<img  class="img-fluid mr-1 align-top" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/climarisk.png" 
		alt="ClimaRisk">ClimaRisk
	</a></div>
	
<?php 	
}

function cr_login_logo() { // Customize login logo ?> 
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/climarisk.png);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'cr_login_logo' );

function cr_login_logo_url_title() {
    return 'ClimaRisk - Entrada al Backend del sitio';
}
add_filter( 'login_headertitle', 'cr_login_logo_url_title' );

function cr_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'cr_login_logo_url' );


// HTML5
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'mwe_breadcrumb_args' );
function mwe_breadcrumb_args( $args ) {
	$args['home'] = 'Home';
	$args['sep'] = ' / ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
	$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
	$args['heirarchial_categories'] = true; // Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = 'You are here: ';
	$args['labels']['author'] = 'Lectures about ';
	$args['labels']['category'] = ''; // Genesis 1.6 and later
	$args['labels']['tag'] = 'Lectures about  ';
	$args['labels']['date'] = 'Lectures about  ';
	$args['labels']['search'] = 'Search for ';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';
	$args['labels']['404'] = 'Not found: '; // Genesis 1.5 and later
return $args;
}

add_action( 'get_header', 'remove_titles_from_pages' );
function remove_titles_from_pages() {
    if ( is_page(array('Home', 'Contact') ) ) {
        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    }
}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'cr_excerpt_length' );
function cr_excerpt_length( $length ) {
	return 30; // pull first 30 words
}

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'cr_read_more_link' );
function cr_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">[Keep reading...]</a>';
}

// Para usar shortcodes en descripciones de categoria y en widgets
//add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');
add_filter( 'genesis_term_intro_text_output', 'do_shortcode' );


add_action( 'pre_get_posts', 'prefix_reverse_post_order' );
function prefix_reverse_post_order( $query ) {
	// Only change the query for post archives.
	if ( $query->is_main_query() && is_archive() && ! is_post_type_archive() ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'ASC' );
	}
}

// Enable PHP in widgets
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , 'cr_next_page_link' );
function cr_next_page_link ( $text ) {
    return 'Following &#x000BB;';
}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'cr_previous_page_link' );
function cr_previous_page_link ( $text ) {
    return '&#x000AB; Previous';
}

function cr_custom_tag_cloud_widget($args) {
	$args['number'] = 20; //adding a 0 will display all tags
	$args['largest'] = 150; //largest tag
	$args['smallest'] = 120; //smallest tag
	$args['unit'] = '%'; //tag font unit
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'cr_custom_tag_cloud_widget' );

//* Customize search form input box text
add_filter( 'genesis_search_text', 'cr_search_text' );
function cr_search_text( $text ) {
	return esc_attr( 'Search in ClimaRisk...' );
}

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Customize the author box title
add_filter( 'genesis_author_box_title', 'custom_author_box_title' );
function custom_author_box_title() {
	$linea = do_shortcode('[post_author_link before="Author: <em>" after="</em></br>"]');
	return $linea;
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'cr_author_box_gravatar_size' );
function cr_author_box_gravatar_size( $size ) {
	return '80';
}

//Introduce PHP code at the end of the post according to post custom meta
/*add_action( 'genesis_after_entry_content', 'cr_after_content_php' );
function cr_after_content_php() {
	$cr_path = plugin_dir_path( __FILE__ ).'cr-includes/';
	if (is_single(1741)) {
	include_once($cr_path.'/nitrates.php');
	}
} */


// Shortcodes

function utset_divider() {
	return '<div class="divider"></div>';
}
add_shortcode('divider', 'utset_divider');

function c_bmodal ($attr, $content) {

$divm = $attr['divm']; //Name of the modal div - Compulsory
$hrefr = get_permalink()."#$divm";
$mtitle = $attr['mtitle']; // Modal title
$content = esc_html($content);
$ppim = plugin_dir_url( __FILE__ ).'images/icon_info.gif';
	if (isset($attr['mtitle'])) {
$bmh = <<<bmht
<div class="modal-header">
<h4 class="modal-title">$mtitle</h4>
<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
</div>
bmht;
	}
	else
$bmh = null;

if (isset($attr['divm'])) {
$bmd = <<<bdivm
<a data-target="#$divm" data-toggle="modal"> <img data-toggle="modal" class="align-top imgs" src="$ppim" title="Click for more information"></a>
<div class="modal fade" id="$divm">
<div class="modal-dialog">
<div class="modal-content">
$bmh
<div class="modal-body text-justify">
$content
</div>
<div class="modal-footer">
<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
bdivm;
}
else
	$bmd = null;
return $bmd;

}

add_shortcode('bmodal', 'c_bmodal');


/// Includes additional PHP file
function cr_include_func( $atts ) {
  extract( shortcode_atts( array(
    'include' => '',
  ), $atts ) );
  
  
  
  $include = $atts['include'];
  if ($include!='') { // Algo a incluir
    
      $ppi = plugin_dir_path( __FILE__ ) .'cr-includes/'.$include.'/';
      $file = $ppi.$include.'.php';
      ob_start(); // turn on output buffering
      include_once($file);
      $res = ob_get_contents(); 
      ob_end_clean(); 	  
	}
  return $res;
 }
 
add_shortcode( 'cr_include', 'cr_include_func' );


?>