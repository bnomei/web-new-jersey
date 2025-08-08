<?php 

if($blog = page('journal')) {
	echo $blog->children()->visible()->flip()->limit(12)->feed(array(
	  'title'       => $blog->title(),
	  'description' => $blog->text(),
	  'link'        => 'journal'
	));
}

?>