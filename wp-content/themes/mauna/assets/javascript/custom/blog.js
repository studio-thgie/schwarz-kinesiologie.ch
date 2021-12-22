(function($){
	$(window).on('contentLoaded', function(){
		$('.post-share').each(function(){
			var that = $(this);
			var share = false;
			that.find('.mobile-share a').on('click', function(e){
				e.preventDefault();
				if(share === false) {
					that.find('.shares').velocity('slideDown');
					share = true;
				} else {
					that.find('.shares').velocity('slideUp');
					share = false;
				}
			});
		});
		if($('.blog').length === 0) {
			return;
		}
		$('.post-columns').not('.post-visible').addClass('post-visible');
		
		$('.page-wrapper').addClass('show-additional');

		$('.page-wrapper').on('click', '.blog-load-more', function(e){
			var ready = false;
			e.preventDefault();
			var $that = $(this);
			var $parent = $that.parent();
			$parent.velocity({opacity: 0}, 400, function(){
				ready = true;
				$('.page-wrapper').trigger('blogLoadMore');
			});
			$.get(this.href, function(response){
				if(ready === true) {
					$parent.remove();
					insertContent(response);
				} else {
					$('.page-wrapper').on('blogLoadMore', function(){
						$parent.remove();
						insertContent(response);
					});
				}
			});
		});

		function insertContent(response) {
			$('.blog-posts').append($(response).find('.blog-posts').html());
			$('.page-wrapper').off('blogLoadMore');
			setTimeout(function(){
				$('.post-columns').not('.post-visible').addClass('post-visible');
			}, 200);
		}
	});
	
})(jQuery);