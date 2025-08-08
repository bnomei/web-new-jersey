<?php 
/*
	taglist snippet, kirby 2
	by bruno meilick, 2015/02/17
*/
kirbytext::$pre[] = function($kirbytext, $value) {

	$p = $kirbytext->field->page;
 	$taglist = explode(', ', $p->tags() );
	$tags = '<ul class="taglist">';
	foreach($taglist as $t) {
		if(site()->filterTagsOnServer() != 'yes') {
			$tags .= '<li><a href="'.$p->parent()->url().'#'.str_replace(' ', '-', $t).'">'.$t.'</a></li>';
		} else {
			$tags .= '<li><a href="'.$p->parent()->url().'/tag:'.str_replace(' ', '+', $t).'">'.$t.'</a></li>';
		}
	}
	$tags .= "</ul>";

	return $value = str_replace("{{tags}}", $tags, $value);
};

?>