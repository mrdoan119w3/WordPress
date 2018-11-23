# WordPress
<div class="fb-like" data-href="<?php echo home_url()?>" data-colorscheme="dark" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
<div class="fb-comments" data-href="<?php echo get_the_permalink($post)?>" data-numposts="10" data-width="100%"></div>


function og_share($args=array(),$post = null){
    if(!$post) $post = get_queried_object();
    $defaults = array(
        'facebook'  =>array('link'=>'https://www.facebook.com/sharer/sharer.php?u='.get_permalink($post),'icon'=>'<i class="fa fa-facebook" aria-hidden="true"></i>'),
        'twitter'   =>array('link'=>'http://twitter.com/home?status='.get_permalink($post),'icon'=>'<i class="fa fa-twitter" aria-hidden="true"></i>'),
        'google'    =>array('link'=>'https://plus.google.com/share?url='.get_permalink($post),'icon'=>'<i class="fa fa-google-plus" aria-hidden="true"></i>'),
        'getpocket' =>array('link'=>'https://getpocket.com/save?='.get_permalink($post),'icon'=>'<i class="fa fa-get-pocket" aria-hidden="true"></i>'),
        'linked'    =>array('link'=>'https://www.linkedin.com/shareArticle?mini=true&url='.get_permalink($post),'icon'=>'<i class="fa fa-linkedin" aria-hidden="true"></i>'),
        'pint'      =>array('link'=>'http://pinterest.com/pinthis?url='.get_permalink($post),'icon'=>'<i class="fa fa-pinterest-p" aria-hidden="true"></i>'),
        'mail'      =>array('link'=>'mailto:?subject=Check%20this%20out%20on%20Productionlist.org&body='.get_permalink($post),'icon'=>'<i class="fa fa-envelope" aria-hidden="true"></i>'),
        
    );
    ?>
	<div class="og-share clearfix">
<ul>
	<?php foreach ($args as $key=>$social) {?>
	<li class="<?php echo $social;?>"><a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="<?php echo $defaults[$social]['link'];?>"><?php echo $defaults[$social]['icon']?></a></li>
	<?php }?>
</ul>
	</div>
<?php 
}
