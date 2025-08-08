<?php snippet('html-header') ?>

<div class="container">
<?php snippet('header-tag') ?>

  <main id="main" role="main" class="row">

      <header id="journal-intro">
          <?php echo $page->text()->kirbytext() ?>
      </header>

	<section id="__<?php echo $page->uid() ?>" class="<?php echo $page->template()!='default'?'T__'.$page->template():'' ?>">
		<?php
		$tag = param('sortby');
		$j = $pages->find('journal');
		$liste = $page->children()->visible()->flip();
		if($tag) {
			$tag = str_replace("+", " ", $tag);
  			$liste = $liste->filterBy('tags', $tag, ',');
		}
		$gotoSerie = param('serie');
		$serie = null;
		if($gotoSerie) {
			$serie = $j->children()->find($gotoSerie);
		}

		$pre = 0;
		$c=0;
		$hide = false;
		$notFoundSerie = true;
		foreach ($liste as $pchi):
			$isScrollTarget = $serie && $serie->is($pchi);
			if($c >= c::get('loadmore', 5)) {
				$hide = true;
			}
			if($serie && $notFoundSerie) {
				$hide = false;
			}
			?>

			<article id="__<?php echo $pchi->uid() ?>" class="<?php ecco($isScrollTarget,'scroll ','') ?><?php echo $pchi->template()!='default'?'T__'.$pchi->template().' ':'' ?> <?php ecco($hide,'jquery-hide',''); echo " ".str_replace(array(", "," ","?"), array("?","-"," "), $pchi->tags()); ?>" >

				<div class="info">
					<h2><?php echo $pchi->title() ?></h2>
					<time datetime="<?php echo $pchi->date('c') ?>"><?php echo $pchi->date('y — m') ?></time>
					<?php echo $pchi->text()->kirbytext() ?>
				</div>

				<?php snippet('flickity', array("flick"=>$pchi)) ?>

			</article>

		<?php $c++;

		if($isScrollTarget) {
			$notFoundSerie = false;
		}

		endforeach; ?>
	</section>

  </main>

<?php snippet('footer-tag') ?>
</div><!-- container -->

<?php snippet('html-footer') ?>
