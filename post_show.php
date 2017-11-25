# WordPress
<?php
function post_show(){
	$args	=	array(
		'post_status' 		=> 'publish',
		'post_type'			=>	'post',
		'posts_per_page'	=>	10,
		'orderby'			=> 'date',
		'order'				=>	'DESC'
	);
	$custom		=	new WP_Query($args);
	if($custom->have_posts()):
?>
	<ul class="post_show">
		<?php 
			$stt	=	0;
			while ($custom->have_posts()):$custom->the_post();
		?>
			<li id="post_item<?php echo $stt;?>" <?php if($stt==0):?>class="active"<?php endif;?>>
				<h3><a href="<?php the_permalink()?>"><?php the_title()?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></h3>
			</li>
		<?php $stt++;endwhile;?>
	</ul>
	<script>
		(function($) {
			$(document).ready(function(){
				function trendingLoop() {
					var et_trending_next_post_eq;

					et_trending_next_post_eq = et_trending_active_post_eq + 1;

					if (et_trending_post_count === et_trending_next_post_eq) {
						et_trending_next_post_eq = 0;
					}

					$et_trending_posts.eq(et_trending_active_post_eq).fadeOut(et_trending_fade_speed, function () {
						$et_trending_posts.eq(et_trending_next_post_eq).fadeIn(et_trending_fade_speed);
						et_trending_active_post_eq = et_trending_next_post_eq;
					});

				}
				var $et_trending_container	=	$('ul.post_show');
				if ($et_trending_container.length) {
					var $et_trending_posts = $et_trending_container.children('ul.post_show li'),
						et_trending_post_count = $et_trending_posts.length,
						et_trending_post_duration = 5000,
						et_trending_fade_speed = 300,
						et_trending_active_post_eq = 0;

					$et_trending_posts.not('ul.post_show li:first-child').hide();

					setInterval(function () {
						trendingLoop();
					}, et_trending_post_duration);
				}
			});
		})(jQuery);
	</script>
<?php 
	endif;wp_reset_query();
}
