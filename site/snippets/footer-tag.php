<?php 
	$j = $pages->find('journal');
?>

<footer role="contentinfo" class="row">

	<?php if($page->template() == 'serie'): ?>
	<ul id="footer-navigation" class="<?php echo $page->template()!='default'?'T__'.$page->template().' ':'' ?> nav">
		<li class="col button <?php echo $page->prevVisible()?'':'disabled' ?>">
			<div class="arrow prev"><?php if( $page->prevVisible()): ?><a href="<?php echo $page->prevVisible()->url() ?>">previous<span class="not-mobile">&nbsp;<?php echo $page->template()=="projekt"?'project':'entry' ?></span></a><?php else: ?>&nbsp;<?php endif; ?></div>
		</li>

		<li class="col button">
			<div class="arrow up"><a href="<?php echo $page->parent()->url() ?><?php ecco($page->isDescendantOf($j),'','#'.$page->uid()) ?>">overview</a></div>
		</li>
		
		<li class="col button <?php echo $page->hasNextVisible()?'':'disabled' ?>">
			<div class="arrow next"><?php if( $page->hasNextVisible()): ?><a href="<?php echo $page->nextVisible()->url() ?>">next<span class="not-mobile">&nbsp;<?php echo $page->template()=="projekt"?'project':'entry' ?></span></a><?php else: ?>&nbsp;<?php endif; ?></div>
		</li>

	</ul>
	<?php endif; ?>

	<div id="footerjournal">
		<?php if($page->is($j)): ?>
		<div id="olderentries" class="col button"><a href="">load more</a></div>
		<?php endif; ?>
		<?php echo kirbytext($site->footertag()->value(), $page); ?>
	</div>
</footer>