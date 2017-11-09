# WordPress
function og_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='og-pagination'>";
        
                  
         if($pages>1){
         	if($paged == 1){ $classone = 'class="current"';}         	
         	echo '<a href="'.get_pagenum_link(1).'" '.$classone.'>1</a>';
         }
     if($paged-$range>2){echo '...';}
         for ($i=$paged-$range; $i <= $paged+$range; $i++)
         {
         	if($paged == $i){$currentclass = 'class="current"';}else{$currentclass = '';}
             if($i>1 && $i<$pages){
             	echo '<a href="'.get_pagenum_link($i).'"'.$currentclass.'>'.$i.'</a>';
             }
        
         }
      if($paged+$range<$pages-1){echo '...';}
     	if($pages>1){
         	if($paged == $pages){ $classtwo = 'class="current"';}         	
         	echo '<a href="'.get_pagenum_link($pages).'" '.$classtwo.'>'.$pages.'</a>';
         }
if($_POST[jumtopage]){
	$gotopage=$_POST[jumtopage];
	if($gotopage>$pages){$gotopage = $pages;}
	if($gotopage<1){$gotopage = 1;}	
	$linktopage = get_pagenum_link($gotopage);
?>
<script>
	document.location.href='<?php echo $linktopage;?>';
</script>
<?php 
}
?>

<form action="<?php home_url()?>" method="post">
	<label>JUMP TO: </label>
	<input type="text" value="" name="jumtopage" placeholder="#page">
</form>

<?php 
         echo "</div>\n";
     }
}

#home page
<?php
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
				$args = array(
				  'posts_per_page' => 8,
				  'paged' => $paged
				);				
				query_posts($args); 
					if(have_posts()):
					while(have_posts()):the_post();
          endwhile;
          ?>
          <div class="top-pagination">	
							
					<?php 			
					global $wp_query;
         			$pages = $wp_query->max_num_pages;		
						if($paged-1>0){
					?>					
					<a href="<?php echo get_pagenum_link($paged-1)?>" class="prev"><span></span>Previous</a>
					<?php }?>
					<?php if($paged+1<=$pages){?>
					<a href="<?php echo get_pagenum_link($paged+1)?>" class="next">Next<span></span></a>
					<?php }?>
					<div class="clear"></div>
				</div>
				<?php og_pagination();?>
        <?php endif;wp_reset_query();?>
          
