<?php

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', 'K2-PRO-aL0kZdrjSwxLxIofLmYEf8fQoyspPowQ');


/////////////////////////////////////////
// IMAGEKIT
//
c::set('imagekit.license', 'IMGKT1-1c032cd068da1297956f30f23a561ed7');


/////////////////////////////////////////
// IMAGESET
//
c::set('imageset.license', 'IMGST1-c5ab046d77dfc9dc68c108fdd48b9e00');
c::set('imageset.placeholder', 'color');
c::set('imageset.presets', [
  'default' => [
    [ '320-1920,1' ],
  ],
  'gallery-cell' => [
    [ '320-1920,3' ], // generic desktop
    [ '422,844' ], // portrait .. 133,200,
    //[ '400,910' ], // ipad landscape
    //[ '302' ], // iphones landscape, desktop portrait small
  ],
]);

/*

---------------------------------------
Kirby Configuration
---------------------------------------

By default you don't have to configure anything to
make Kirby work. For more fine-grained configuration
of the system, please check out http://getkirby.com/docs/advanced/options

*/

c::set('home', 'journal');
c::set('markdown.extra', true);

c::set('loadmore', 5);
c::set('fingerprint', true);

c::set('columns.container', 'kirby-row');
c::set('columns.item', 'col');

c::set('kirbytext.snippets', array(
  'lorem' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo eum repudiandae voluptatum at debitis voluptate quasi! Labore sapiente iusto, est, nobis, mollitia aspernatur non illum corporis iste eius amet esse!'
));

c::set('routes', array(
  array(
    'pattern' => 'api/random-image',
    'action'  => function() {

      if($j = page('journal')) {
        $series = $j->children()->visible();
        $r = rand(0, $series->count()-1);
        $s = $series->nth($r);
        $images = $s->images();
        $ri = rand(0, $images->count()-1);
        $img = $images->nth($ri);
        if($img) {
            // echo $img->imageset('gallery-cell', []);
          	echo brick('a', '&nbsp;')
      			->attr('href', $s->url())
      			->attr('target', '_blank')
      			->attr('style', 'background-image:url('.$img->resize(1200)->url().');');
          	return true;
        }
      }
      return response::error();
    }
  )
));
