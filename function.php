# WordPress
function daiuy_setup() {
	//add_image_size( 'home_word', 265, 265, true );	
	function widget_theme() {
		register_sidebar( array(
			'name'          => __( 'widget'),
			'id'            => 'widget',
			'description'   => __( 'widget'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
add_action( 'widgets_init', 'widget_theme' );

}
add_action( 'after_setup_theme', 'daiuy_setup' );

function useAjaxInWp(){
	$style_file = array(
		"responsive"		=>	'css/responsive.css',
	);
	$script_file = array(
		'main'	=> 'js/main.js',
	);
	
	foreach ($style_file as $k=>$v){
		wp_register_style( $k, esc_url( trailingslashit( get_stylesheet_directory_uri() ) . $v ),array(), 'all' );
		wp_enqueue_style( $k );
	}
	foreach ($script_file as $k=>$v){
		wp_register_script( $k, esc_url( trailingslashit( get_stylesheet_directory_uri() ) . $v ),  array( 'jquery' ),'1.0', true );
		wp_enqueue_script( $k );
	}
}	
add_action( 'wp_enqueue_scripts', 'useAjaxInWp', 99 );
