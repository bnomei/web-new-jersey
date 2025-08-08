<?php snippet('html-header') ?>

<div class="container">
<?php snippet('header-tag') ?>

  <main id="main" role="main" class="row mato_2">

	<article id="__<?php echo $page->uid() ?>" class="<?php echo ($site->hyphenate() == 'yes')?'hyphenate ':'' ?><?php echo $page->template()!='default'?'T__'.$page->template().' ':'' ?>" >
	<?php 
		if($page->template() == 'serie') : ?>
		<?php snippet('flickity', array("flick"=>$page)) ?>
		<div class="info">
			<h2><?php echo $page->title() ?></h2>
			<time datetime="<?php echo $page->date('c') ?>"><?php echo $page->date('y – m') ?></time>
			<?php echo $page->text()->kirbytext() ?>
		</div>
	<?php endif; ?>
	<?php echo $page->text()->kirbytext() ?>
	</article>

  </main>

<?php snippet('footer-tag') ?>
</div><!-- container -->

<?php snippet('html-footer') ?>