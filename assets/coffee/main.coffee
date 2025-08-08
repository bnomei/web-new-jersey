#-----------------------------------------
HASH = undefined
FADE = 0 #ms
HYPHENATE = true
USEFLICKITY = false
FLICKITY_DRAGGABLE = false
GALLERY_LOAD = 5 #entries
MOBILE = false

#----------------------------------------
waitForFinalEvent = do ->
	timers = {}
	(callback, ms, uniqueId) ->
		if !uniqueId
			uniqueId = 'Don\'t call this twice without a uniqueId'
		if timers[uniqueId]
			clearTimeout timers[uniqueId]
		timers[uniqueId] = setTimeout(callback, ms)
		return

#----------------------------------------
echo = (obj) ->
	console.log obj

#----------------------------------------
preloadImg = (src) ->
	$('<img/>').attr('src', src).appendTo('body').css('display','none')
	return # preloadImg

#----------------------------------------
registerEvents = ->

	$("#olderentries.button").click (ev) ->
		ev.preventDefault()
		$("article.jquery-hide").slice(0, GALLERY_LOAD).each ->
			$(this).addClass('loaded').removeClass('jquery-hide')
			#$(this).find('.gallery-cell img').slice(0, 2).each ->
			#	lazyloadImageAndRetina $(this)
			$(this).find('.gallery').each ->
				updateFlickity $(this)
			return
		if $("article.jquery-hide") == undefined or $("article.jquery-hide").length == 0
			$(this).hide()
		return

	$('.button').not('.filter').not('.home').not('#newerentries').not('#olderentries').click (ev) ->
		lnk = $(this).find('a')
		if lnk != undefined and lnk.attr('href') != undefined
			if lnk.attr('target') == '_blank'
				window.open(lnk.attr('href'), "_blank");
			else
				window.location = lnk.attr('href')
			ev.preventDefault()
		return

	$('#sorted').click (ev) ->
		if $("body").hasClass("B__journal") then return

		FILTER = ''
		HASH = '-' # http://bit.ly/1Aw6qsy just '' would cause to scroll to Top
		$(this).html('')
		$(".isocontainer").isotope({ filter: FILTER })
		$.scrollTo('+=1px',1) # trigger lazyload refresh

		window.location.hash = "#" + HASH
		ev.preventDefault()

		return

	$(".button, .dropdown").hover ->
		$(this).addClass("hover")
		$(this).find("a").first().addClass("hover")
		return
	, ->
		$(this).removeClass("hover")
		$(this).find("a").first().removeClass("hover")
		return

	$("#sortby").hover (ev) ->
		menu($(this), true)
		return
	, ->
		menu($(this), false)
		return

	$(".gallery-cell").mousemove (ev) ->
		if MOBILE or !USEFLICKITY then return
		x = ev.pageX - $(this).offset().left
		wp = x / $(this).width()
		fl = $(this).parents('.gallery')
		if wp <= 0.5
			$(this).toggleClass 'cursor-left', $(this).prev('.gallery-cell').length != 0
			$(this).removeClass 'cursor-right'
		else
			$(this).toggleClass 'cursor-right', $(this).next('.gallery-cell').length != 0
			$(this).removeClass 'cursor-left'
		return

	$(".gallery-cell").hover (ev) ->
		if MOBILE or !USEFLICKITY then return
		# mousemove
		return
	, ->
		if MOBILE or !USEFLICKITY then return
		$(this).removeClass 'cursor-left'
		$(this).removeClass 'cursor-right'
		return

	$(".gallery-cell").click (ev) ->
		if MOBILE or !USEFLICKITY then return
		x = ev.pageX - $(this).offset().left
		wp = x / $(this).width()
		fl = $(this).parents('.gallery').first()
		if wp <= 0.5
			fl.flickity( 'previous', false, true )
		else
			fl.flickity( 'next', false, true ) # http://flickity.metafizzy.co/api.html#next
		return

	$(window).resize ->
			waitForFinalEvent (->
				$('.gallery.flickity-enabled').each ->
					$(this).flickity('resize')
			), 500, 'waitForFinalEvent_resize'
			return # window.resize

	return # registerEvents


#----------------------------------------
menu = (obj, show) ->
	if show == undefined
		show = not obj.is(':hidden')

	if show
		if obj.hasClass('animating') then return
		obj.addClass('animating').find('ul').removeClass('jquery-hide').show()
	else
		if obj.hasClass('animating') == false then return
		obj.removeClass('animating').find('ul').hide()
	return

#----------------------------------------
updateFlickity = (sel) ->
	if !USEFLICKITY then return
	ll = if MOBILE then true else 3
	fl = $(sel).flickity({
		#cellAlign: 'center',
		cellSelector: '.gallery-cell'
		draggable: FLICKITY_DRAGGABLE # does not work well with custom 50/50 click event
		#accessibility: false, #projects prev next bound to arrow keys already
		#imagesLoaded: true
		wrapAround: true
		pageDots: false
		prevNextButtons: !FLICKITY_DRAGGABLE
		#bgLazyLoad: ll
		percentPosition: true
		#lazyLoad: ll
	})
	fl.on( 'cellSelect', ->
		flkty = $(this).data('flickity')
		idx = flkty.selectedIndex + 1
		fl = $(flkty.selectedElement)
		fl.parent().parent().parent().find(".cellnum span").html(idx)
	)
	fl.flickity('resize')
	return

#----------------------------------------
# DOCUMENT LOAD
$ ->
	preloadImg '/assets/images/new-jersey.png'
	preloadImg '/assets/images/white.png'
	preloadImg '/assets/images/light.png'
	preloadImg '/assets/images/pink.png'
	preloadImg '/assets/images/lazy.png'

	MOBILE = $('body').hasClass 'mobile'
	FLICKITY_DRAGGABLE = MOBILE

	# get hash
	hashParts = String(window.location).split('#');
	if hashParts.length == 2 then HASH = String(hashParts[1])
	if HASH != undefined then HASH = HASH.toLowerCase()
	if HASH != undefined && HASH.length > 0
		nf = '.' + HASH
		if $(nf).length > 0
			FILTER = nf
			$('.tagcloud>li>a[data-filter="'+FILTER+'"]').parent().addClass('active')

	$("#sortby>ul").addClass("jquery-hide")
	so = $('.tagcloud>li.active').find('a').html()
	if so != undefined and $("#sortby").hasClass("journal")
		jr = window.location.href.substr(0, window.location.href.indexOf('/sortby:'))
		so = '<a href="'+jr+'">this&nbsp;is&nbsp;' + so + '</a>'
		$("#sortby>div>a").hide()
	else
		$("#sortby>div>a").show()
	$("#sorted").html(so)

	if $("article.jquery-hide") == undefined or $("article.jquery-hide").length == 0
		$('#olderentries.button').hide()

	# HACK: journal about footer
	if document.title.indexOf('about') >= 0
		$("a.about").attr('href','/').text('journal')

	# events
	registerEvents()

	$('article:not(.jquery-hide) .gallery').each ->
		updateFlickity $(this)

	if HASH == undefined
		# ios hide scrollbar
		setTimeout(->
			window.scrollTo(0, 1)
		, 10)

	if $('article.scroll') != undefined
		setTimeout(->
			$.scrollTo($('article.scroll'))
		, 20)


	return
