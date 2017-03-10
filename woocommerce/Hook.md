# Query Hook Meta_value(Meta_key)

function capt_query_hook($query){	
	if(!is_admin() && $query->is_main_query() && (is_shop()|| is_tax('product_cat')) ){
		$query->set('order','DESC');
		$query->set('orderby','meta_value_num date');
		$query->set('meta_key','san_pham_ban_chay');
		//$query->set('posts_per_page','2');
	}
}
add_action('pre_get_posts','capt_query_hook');
