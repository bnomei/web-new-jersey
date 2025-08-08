<?php
if($page->template() == 'serie' && !c::get('debug', false)):
	go($page->parent()->url().'/serie:'.$page->slug());
	/*
	?>
<!DOCTYPE html><html><head><meta http-equiv="refresh" content="0; url=<?php echo $page->parent()->url(); ?>#<?php echo $page->slug(); ?>" /></head><body></body></html>
<?php exit();
	*/
endif; ?><?php
    $detect = new Mobile_Detect;
    $isMobile = $detect->isMobile() || $detect->isTablet();
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$wi = "959";
		$ti = $site->title()->html()." | ".$page->title()->html();
		if(trim($site->title()) == trim($page->title())) {
			$ti = $site->title()->html();
		}
		$de = $site->description()->html();
		$ke = $site->keywords()->html();
	?>

  	<meta charset="utf-8" />
  	<meta name="viewport" content="width=<?php echo $wi ?>"> <!-- width=device-width, initial-scale=1.0 -->

  	<title><?php echo $ti ?></title>
  	<meta name="description" content="<?php echo $de ?>">
  	<meta name="keywords" content="<?php echo $ke ?>">

	<link rel="shortcut icon" href="favicon.png" type="image/png">

	<?php $f = $pages->findByURI('feed'); ?>
	<link rel="alternate" type="application/rss+xml" href="<?php echo $f->url() ?>" title="<?php echo $f->title() ?>" />

	<?php
    $gakey = $site->ganalytics()->isEmpty() ? c::get('google.analytics.apikey','UA-') : $site->ganalytics();

    if(!is_localhost() && strlen($gakey) > strlen("UA-") ): ?>
    <!-- Google Analytics -->
    <script type="text/javascript">
    var gaProperty = '<?php echo $gakey ?>';
    var disableStr = 'ga-disable-' + gaProperty;
    if (document.cookie.indexOf(disableStr + '=true') > -1) { window[disableStr] = true;
    }
    function gaOptout() {
    document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
    window[disableStr] = true; }
    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', '<?php echo $gakey ?>', 'auto');
      ga('set', 'anonymizeIp', true);
      ga('send', 'pageview');
    </script>
    <?php endif;


	echo css('assets/css/main.journal.css');
	?>
    <style>
        @font-face {
            font-family: 'WindsorPro';
            src: url('/assets/fonts/WindsorPro-Regular.woff2') format('woff2');
            font-style: normal;
            font-weight: bold;
            text-rendering: optimizeLegibility;
        }
        @font-face {
            font-family: 'WindsorPro';
            src: url('/assets/fonts/WindsorPro-Bold.woff2') format('woff2');
            font-style: normal;
            font-weight: bold;
            text-rendering: optimizeLegibility;
        }

        * {
            font-family: 'WindsorPro', sans-serif !important;
            color: #0986BF !important;
        }
        #home {
            font-size: 34px;
        }
        #journal-intro {
            font-size: 16px;
            line-height: 21px;
            max-width: 92ch;
            margin: 0 auto;
            padding-bottom: 5rem;
        }
        header nav.row .col>div.prefix {
            height: auto !important;
        }
    </style>

	<!-- LoadJS: https://github.com/muicss/loadjs -->
  <?php
    $assets = kirby()->roots()->assets() . DS;
    $loadjs = $assets . '/js/loadjs.min.js';
    if(f::exists($loadjs)): ?>
      <script>
        <?= f::read($loadjs) ?>
      </script>

      <script>
        function load_libs() {
          loadjs(
            [
              '/assets/js/html5shiv.min.js',
              '/assets/js/respond.min.js',
              '/assets/js/jquery.cookieBar.min.js',
              '/assets/js/jquery.scrollTo.min.js',
							'/assets/js/flickity.pkgd.min.js'
            ],
            {
              success: function() {
                loadjs('/assets/js/main.min.js');
              }
            }
          );
        }
        loadjs('/assets/js/jquery.min.js', { success: load_libs });
      </script>
    <?php endif;
  ?>

  <script>
    (function(w, d){
      function loadJS(u){var r = d.getElementsByTagName("script")[0], s = d.createElement("script");s.src = u;r.parentNode.insertBefore( s, r );}
      if(!window.HTMLPictureElement){
        d.createElement('picture');
        loadJS("<?= url('assets/plugins/imageset/js/dist/respimage.min.js') ?>");
      }
    })(window, document);
  </script>
	<?= js('assets/plugins/imageset/js/dist/imageset.js') ?>

</head>
<?php flush(); /* https://developer.yahoo.com/performance/rules.html */ ?>
<body class="B__<?php echo $page->template().' '; ?><?php ecco($isMobile, 'mobile ', ''); ecco(is_localhost(), 'localhost ', '') ?>">
