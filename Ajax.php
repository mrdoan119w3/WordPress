<?php
function get_id_list_term($taxonomy){
	$list_id = array();
	$all_topic = get_terms(array(
		'taxonomy'	=>	$taxonomy,
		'hide_empty' => false,
	));
	if($all_topic && !empty($all_topic)){
		foreach ($all_topic as $term){
			$list_id[] = $term->term_id;
		}
	}
	return $list_id;
}

add_action('wp_ajax_dvd_action', 'dvd_action_func');
add_action('wp_ajax_nopriv_dvd_action', 'dvd_action_func');
function dvd_action_func() {
    if(isset($_POST['data'])){
        $data = $_POST['data'];
    }
    $params = array();
	parse_str($_POST['data'], $params);	
	
	$all_topic = get_id_list_term('topic');
	$all_industry = get_id_list_term('industry');
	$all_product = get_id_list_term('product');
	$all_content_type = get_id_list_term('content_type');
	
	
	$paged = (isset($_POST['paged']) && $_POST['paged'] )? intval($_POST['paged']) : 1;
	
	$search_text = esc_attr($params['search_text']);
	$test_topic = (isset($params['test_topic']) && $params['test_topic'] )? intval($params['test_topic']) : '';
	$test_industry = (isset($params['test_industry']) && $params['test_industry'] )? intval($params['test_industry']) : '';
	$test_product = (isset($params['test_product']) && $params['test_product'] )? intval($params['test_product']) : '';
	$test_content_type = (isset($params['test_content_type']) && $params['test_content_type'] )? intval($params['test_content_type']) : '';

	$tax_query_child = array();
	
	if($test_topic) {
		$tax_query_child[] = array(					
			'taxonomy' => 'topic',
			'field'    => 'term_id',
			'terms'    => $test_topic,	
		);
	}
	if($test_industry) {
		$tax_query_child[] = array(
			'taxonomy' => 'industry',
			'field'    => 'term_id',
			'terms'    => $test_industry,
		);
	}
	if($test_product) {
		$tax_query_child[] = array(
			'taxonomy' => 'product',
			'field'    => 'term_id',
			'terms'    => $test_product,
		);
	}
	if($test_content_type) {
		$tax_query_child[] = array(
			'taxonomy' => 'content_type',
			'field'    => 'term_id',
			'terms'    => $test_content_type,
		);
	}
	
	if(!$test_topic && !$test_industry && !$test_product && !$test_content_type){
		$tax_query_child[] = array(					
			'taxonomy' => 'topic',
			'field'    => 'term_id',
			'terms'    => $all_topic,	
		);
		$tax_query_child[] = array(
			'taxonomy' => 'industry',
			'field'    => 'term_id',
			'terms'    => $all_industry,
		);
		$tax_query_child[] = array(
			'taxonomy' => 'product',
			'field'    => 'term_id',
			'terms'    => $all_product,
		);
		$tax_query_child[] = array(
			'taxonomy' => 'content_type',
			'field'    => 'term_id',
			'terms'    => $all_content_type,
		);
		
		$tax_query_child = implode(', ', $tax_query_child);
	}
	
	
    $tax_query = array(
    	'relation' => 'AND',
		$tax_query_child								
	);		
			
    ?>
        <?php
        $args	=	array(
            'post_type'			=>	'resources',
            'paged'				=>	$paged,
            'orderby'			=>	'date',            
            'order'				=>	'ASC',
            'posts_per_page'	=>	8,
        	's'					=>	$search_text,
        	'tax_query' 		=>  $tax_query
        );
        $custom	=	new WP_Query($args);
        $max_num_pages = $custom->max_num_pages;
        
        if($paged > $max_num_pages) wp_send_json_error();
        
        ob_start();
        if($custom -> have_posts()):
            while ($custom->have_posts()):$custom->the_post();
		?>
		<?php 
			$modal_view	=	get_field('modal_view');
			 $term_type		=	get_the_terms($post,'content_type');
			 $add_file		=	get_field('add_file');
			 $content		=	get_the_content();
			 $sub			=	substr($content,0,50)."...";
			if($term_type){
				foreach ($term_type as $cat){
					$name=$cat->name;
					$icon	=	get_field('icon_img','content_type_'.$cat->term_id);
				}	
			}	
			
		?>
			<div class="col-md-3 col-sm-6">
			<?php if($modal_view==true){?>
				<div class="img">				
					<a class="fancybox_video" rel="group" href="#ex<?php echo get_the_ID($post);?>">
						<?php the_post_thumbnail('img-resources');?>
					</a>
					<a class="btn-filter fancybox_video" href="#ex<?php echo get_the_ID($post);?>">
						<img src="<?php echo $icon['url'];?>"/>
						<?php echo $name;?>
					</a>		
				</div>
				<div class="excerpt">
					<?php echo $sub;?>
				</div>
				<div id="ex<?php echo get_the_ID($post);?>" style="display:none;">
				    <video controls id="video-id">
				    	<source src="<?php echo $add_file['url'];?>" type="video/mp4">
				    </video>
				 </div>
			<?php }else {?>
				<div class="img">				
					<a href="<?php echo $add_file['url'];?>" target="_blank">
						<?php the_post_thumbnail('img-resources');?>
					</a>
					<a class="btn-filter" href="<?php echo $add_file['url'];?>" target="_blank">
						<img src="<?php echo $icon['url'];?>"/>
						<?php echo $name;?>
					</a>		
				</div>
				<div class="excerpt">
					<?php echo $sub;?>
				</div>
			<?php }?>
			</div>
            <?php endwhile;
            $content = ob_get_clean();
	        wp_send_json_success($content);
        else:
        	wp_send_json_error();        
    	endif;wp_reset_query();
        
    die();
}
?>

