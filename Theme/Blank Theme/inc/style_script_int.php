<?php
$style_file = array(
	'style'		=> 'css/style.css',
	'respon'	=>	'css/respon.css',
);
$script_file = array();
function useAjaxInWp() {
	global $style_file,$script_file;
	//Style
	if(!CPTDEV_DEV_MODE){
		wp_register_style( 'style', esc_url( trailingslashit( get_template_directory_uri() ) . 'style.css' ),array(), CPTDEV_VERSION, 'all' );
	}else{	
		foreach ($style_file as $k=>$v){
			wp_register_style( $k, esc_url( trailingslashit( get_template_directory_uri() ) . $v ),array(), CPTDEV_VERSION, 'all' );
		}
	}
	//Script
	if(!CPTDEV_DEV_MODE){
		wp_register_script( 'cptdev-main', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/cptdev.jquery.min.js' ), array( 'jquery' ), CPTDEV_VERSION, true );
	}else{
		wp_register_script( 'cptdev-main', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/cptdev_main.js' ), array( 'jquery' ), CPTDEV_VERSION, true );
		foreach ($script_file as $k=>$v){
			wp_register_script( $k, esc_url( trailingslashit( get_template_directory_uri() ) . $v ),  array( 'jquery' ), CPTDEV_VERSION, true );
		}	
	}
	$php_array = array( 
		'admin_ajax'		=>	admin_url( 'admin-ajax.php'),
		'home_url'			=>	home_url(),
		'tempURL'			=>	TEMP_URL,
	);
	wp_localize_script( 'cptdev-main', 'cptdev_array', $php_array );	
}
function enqueue_UseAjaxInWp() {
	global $style_file,$script_file;
	if(!CPTDEV_DEV_MODE){
		wp_enqueue_style( 'style' );	
	}else{	
		foreach ($style_file as $k=>$v){
			wp_enqueue_style( $k );
		}
	}
	if(!CPTDEV_DEV_MODE){
		wp_enqueue_script( 'cptdev-main' );
	}else{
		foreach ($script_file as $k=>$v){
			wp_enqueue_script( $k );
		}
		wp_enqueue_script( 'cptdev-main' );
	}
}
add_action( 'wp_enqueue_scripts', 'useAjaxInWp', 1 );
add_action( 'wp_enqueue_scripts', 'enqueue_UseAjaxInWp' );