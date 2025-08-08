<?php
	if(!isset($ignore)) $ignore = [];
	if(!isset($images)) $images = $flick->images()->sortBy('sort', 'asc');

	$carousel = brick('div')
		->attr('id', 'S__'.$flick->uid())
		->addClass('gallery');

	$imageCount = 0;
	foreach ($images as $img) {
		// ignore list
		$skip = false;
		foreach ($ignore as $ign) {
			if($img->uri() == $ign->uri()) {
				$skip = true;
				break;
			}
		}
		if($skip) continue;
		else $imageCount++;

		$url = thumb($img, ['height' => 640])->url();

		/*
		$i = brick('img')
			//->attr('src', kirby()->urls()->assets().'/images///pink.png') // placeholder
			//->addClass()
			->attr('src', $url);
		*/
	
		$i = $img->imageset('gallery-cell', []);

		$cell = brick('div', $i)
			->addClass('gallery-cell '.$img->orientation());
			//->attr('data-flickity-bg-lazyload', $url);

		$carousel->append($cell);
	}

	$carousel->append("<div class='cellnum'><span>1</span>/{$imageCount}</div>");

	if($imageCount > 0) {
		echo "<!-- FLICKITY -->\n";
		if($imageCount == 1) $carousel->addClass('single');
		echo $carousel;
	}
