(function($){
	$(window).on('contentReady', function(){

		if($('.portfolio4').length === 0) {
			return;
		}

		initMasonry();
		setItemHeight();

		$(window).on('resize', $.debounce( 250, function() {
			setItemHeight();
		}));

		$('.portfolio4 .portfolio-item4').addClass('item-visible');

		function initMasonry() {
			var $grid = $('.portfolio4-masonry');
			
			$grid.isotope({
				itemSelector: '.portfolio-item4',
				columnWidth: '.portfolio-grid-sizer',
				percentPosition: true,
				hiddenStyle: {
					opacity: 0,
				},
				visibleStyle: {
					opacity: 1,
				},
				transitionDuration: 0,
			});

			$grid.imagesLoaded().done( function() {
				$('.portfolio4 .portfolio-item4').addClass('item-visible');
				$grid.isotope('layout');
			});
		}
		var canClick = true;
		$('.portfolio4').on('click', '.portfolio-load-more', function(e){
			e.preventDefault();
			if(canClick === false) {
				return;
			}
			canClick = false;
			var ready = false;
			
			var $that = $(this);
			var $parent = $that.parent();
			$parent.velocity({opacity: 0}, 400, function(){
				ready = true;
				$('.page-wrapper').trigger('galleryLoadMore');
			});
			$.get(this.href, function(response){
				if(ready === true) {
					$that.remove();
					insertContent(response);
				} else {
					$('.page-wrapper').on('galleryLoadMore', function(){
						$that.remove();
						insertContent(response);
					});
				}
			});
		});

		function insertContent(response) {
			var $grid = $('.portfolio4-masonry');
			var loadMore = $(response).find('.portfolio-load-more-wrapper').html();
			response = $(response).find('.portfolio4-masonry').html();
			var $response = $(response);
			$grid.append($response);
			$('.page-wrapper').off('galleryLoadMore');

			$grid.imagesLoaded().done( function() {
				$grid.isotope('appended', $response);
				setItemHeight();
				$('.portfolio4 .portfolio-item4').not('.item-visible').addClass('item-visible');
				if(typeof loadMore === "undefined") {
					$('.portfolio-load-more-wrapper').remove();
				} else {
					$('.portfolio-load-more-wrapper').html(loadMore).velocity({opacity: 1});
				}
				canClick = true;
			});

		}

		function setItemHeight() {
			var $grid = $('.portfolio4-masonry'),
			gutter = $grid.data('gutter'),
			itemHeight = ($(window).height() - 58 - (gutter * 8)) /3;
			if(!window.mobile && !window.ipad && $(window).outerWidth() >= 1024) {
				$grid.find('.portfolio-item4').height(itemHeight);
			} else {
				$grid.find('.portfolio-item4').height(250);
			}
			$grid.isotope('layout');
		}
	});
})(jQuery);