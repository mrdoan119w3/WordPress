# WordPress
function cpt_excerpt($text, $chars = 120) {
	if($text){$count = strlen($text);}else{
		$text = get_the_content();
		$text = strip_tags($text);
		$count = strlen($text);
	};
	if($count<=$chars){return $text;}else{
	$text = $text." ";	
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."...";
	return $text;}
}
