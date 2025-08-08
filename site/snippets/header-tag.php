<?php
	$j = $pages->find('journal');
	$isJ = $page->is($j) || $page->isDescendantOf($j);
?>
<header role="banner" class="">
	<nav role="navigation" class="row">
		<?php
			$pa = $pages->find('about');
			if($page == $pa) { $pa = $j; } // back link

		?>
		<div class="col">
			<div class="prefix">&nbsp;</div>
			<div id="home" class="button journal"><a href="<?php echo $pa->url() ?>">&nbsp;journal g&nbsp;</a></div>
			<?php if($page->is($j)):
				$tagcloud = tagcloud(page($j), array('sort'=>'name', 'sortdir' => 'asc'));
				if($tagcloud->count() > 0):
			?>
			<div id="sortby" class="dropdown journal">
				<div><a href="<?php echo $page->url() ?>">sort by</a><div id='sorted'></div></div>
				<?php
				$tags = '<ul class="tagcloud">';
				foreach($tagcloud as $tag) {
					$t = '';
					$tagInURL = str_replace("+", " ", param('sortby'));
					$t = $tagInURL==$tag->name()?" active":"";
					$u = strlen($t)>0 ? $j->url() : $tag->url();
					$u = str_replace("/tag:", "/sortby:", $u);
	 				$tags .= "<li class='button $t'><a href='$u'>{$tag->name()}</a></li>";
	 			}
				$tags .= "</ul>";
				echo $tags; ?>
			</div>
			<?php endif; endif; ?>
		</div>
	</nav>
</header>
