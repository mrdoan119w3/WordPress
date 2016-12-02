# WordPress
/* Content */
<?php get_header(); ?>
<div class="resources-container">

	<div class="container">
	<form action="" class="form_filtter">
		<div class="main-top">
			<h1><?php the_field('title_resource','option');?></h1>
			<p><?php the_field('description_resource','option');?></p>
			
			<div class="rs-search">
					<input class="search-text" type="text" id="" name="search_text" placeholder="Search" value="" />               				 
       				 <button type="button" name="asas" id="search_button">
       				 </button>
			</div>
		</div><!-- main-top -->
		<div class="filter-select">
			
			<?php $list_terms = array('topic','product','industry','content_type');?>
			<?php foreach ($list_terms as $term_slug):?>
			<div class="col-md-3 col-sm-6">
				<select class="test test_<?php echo $term_slug;?>" name="test_<?php echo $term_slug;?>">
				<option value="">Filter by <?php echo get_taxonomy($term_slug)->label;?></option>
				<?php
						$taxonomy_terms = get_terms( array(
						    'taxonomy' => $term_slug,
    						'hide_empty' => false,
						));
					?>
				<?php if($taxonomy_terms && is_array($taxonomy_terms) && !is_wp_error($taxonomy_terms)):?>
				<?php foreach ($taxonomy_terms as $terms):?>
					<option data-taxonomy="<?php echo $term_slug;?>" value="<?php echo $terms->term_id;?>"><?php echo $terms->name;?></option>
				<?php endforeach;?>
				<?php endif;?>
				</select>
				</div>
			<?php endforeach;?>
			
			
		</div>
	</form>
		
		<div class="rs-content">
		<?php 
			$page	=	get_query_var('page') ? get_query_var('page') : 1;
			$args	=	array(
				'post_type'	=>	'resources',
				'paged'	=>	'paged',
				'orderby'	=>	'date',
				'order'	=>	'ASC',
				'posts_per_page'	=>	'8'
			);
			$custom	=	new WP_Query($args);
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
				    <video controls id="video-id" >
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
		<?php endwhile;endif;wp_reset_query();?>		
		</div>
		<h5 class="read-more">
			<a href="#" data-page="1" class="load_more">
				LOAD MORE
				<img src="<?php echo get_stylesheet_directory_uri() . '/img/loading.gif' ;?>" style="display:none"/>
			</a>
		</h5>
	</div><!-- container -->	
</div>
<script>
(function($){
	$(document).ready(function(){
		function ajax_js(){
			var data = $('.form_filtter').serialize(); //Lấy giá trị form,mã hóa thành chuỗi
			 $.ajax({
				 type : 'POST',
				 dataType: 'json',//json kiểu dữ liệu trả về
				 data : {
					 'action' : 'dvd_action',
					 'data' : data					 
				 },
				 url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
				 //beforeSend: Hiển thị nội dung trước khi load
				 beforeSend: function(){
					 $('.rs-content').html('<img src="<?php echo get_stylesheet_directory_uri() . '/img/ajax-loading.gif' ;?>" class="load_img" />');
				 },
				 //success: Load nội dung
				 success : function (resp){
					$('.load_more').attr('data-page',1);
					$('.load_more').text('Load more');
					 //if: Load có kết quả trả về data
					if(resp.success){
						$('.rs-content').html(resp.data);
						$('.load_more').fadeIn();
					//else: Load k có giá trị trả về
					}else{
						$('.rs-content').html('No post to load!');
						$('.load_more').fadeOut();
					}
				 }
			 });
		 }
		//
		$('.form_filtter').bind('change submit',function(){
				ajax_js();
			 return false;
		 });
		 $('.load_more').click(function(event){
			 event.preventDefault();//dừng sự kiện khi click .load_more
			 var pageCurrent = parseInt($(this).attr('data-page'));//parseInt sử lý dữ liệu dạng số
			 var data = $('.form_filtter').serialize();
			 $.ajax({
				 type : 'POST',
				 dataType: 'json',
				 data : {
					 'action' : 'dvd_action',
					 'data' : data,
					 'paged' : parseInt(pageCurrent + 1)
				 },
				 url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
				 beforeSend: function(){
					 $('.read-more img').css('display','block');
				 },
				 success : function (resp){
					 if(resp.success){
						$('.load_more').attr('data-page',parseInt(pageCurrent + 1));
					 	$('.rs-content').append(resp.data);//append: up dữ liệu vào cuối danh sách			 	
					 }else{
						 $('.load_more').text('No more post to load!');
						 setTimeout(function(){
							 $('.load_more').fadeOut();
						 },1000);
					 }
					 $('.read-more img').css('display','none');
				 }
			 });
		 });
		 
	});		 
})(jQuery);
</script>
<?php get_footer(); ?>
