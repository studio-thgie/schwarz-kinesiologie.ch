(function($) {
	'use strict';
	var sharer = {
		socials: {
			'facebook': 'https://www.facebook.com/sharer/sharer.php?u={url}',
			'twitter': 'https://www.twitter.com/share?text={title}',
			'google+': 'https://plus.google.com/share?url={url}',
			'tumblr': 'http://www.tumblr.com/share/link?url={url}&name={title}&description={desc}',
			'pinterest': 'https://pinterest.com/pin/create/bookmarklet/?media={img}&url={url}&is_video=0&description={title}',
		},
		init: function() {
			var that = this;
			$('body').on('click', 'a.social-share', function(e) {
				e.preventDefault();
				var winHeight = 300;
				var winWidth = 500;
				var winTop = (screen.height / 2) - (winHeight / 2);
				var winLeft = (screen.width / 2) - (winWidth / 2);
				window.open(this.href, this.title, 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
			});

			$('body').on('click', 'a.social-share-self', function(e) {
				e.preventDefault();
				var winHeight = 300;
				var winWidth = 500;
				var winTop = (screen.height / 2) - (winHeight / 2);
				var winLeft = (screen.width / 2) - (winWidth / 2);
				var url = window.location.href;
				var title = document.title;
				var desc = '';
				if($('meta[property="og:description"]').length > 0) {
					desc = $('meta[property="og:description"]').attr('content');
				}
				var img = '';
				if($('meta[property="og:image"]').length > 0) {
					img = $('meta[property="og:image"]').attr('content');
				}
				var social = $(this).data('social');

				social = that.socials[social].replace("{url}", encodeURI(url))
						.replace('{title}', title)
						.replace('{desc}', desc)
						.replace('{img}', img);
				window.open(social, this.title, 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
			});

		},
	};

	sharer.init();
})(jQuery);