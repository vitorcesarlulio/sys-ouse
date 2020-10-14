/*!
 * AdminLTE v3.0.4 (https://adminlte.io)
 * Copyright 2014-2020 Colorlib <http://colorlib.com>
 * Licensed under MIT (https://github.com/ColorlibHQ/AdminLTE/blob/master/LICENSE)
 */
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
  typeof define === 'function' && define.amd ? define(['exports'], factory) :
  (global = global || self, factory(global.adminlte = {}));
}(this, (function (exports) { 'use strict';

  /**
   * --------------------------------------------
   * AdminLTE ControlSidebar.js
   * License MIT
   * --------------------------------------------
   */
  var ControlSidebar = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'ControlSidebar';
    var DATA_KEY = 'lte.controlsidebar';
    var EVENT_KEY = "." + DATA_KEY;
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      COLLAPSED: "collapsed" + EVENT_KEY,
      EXPANDED: "expanded" + EVENT_KEY
    };
    var Selector = {
      CONTROL_SIDEBAR: '.control-sidebar',
      CONTROL_SIDEBAR_CONTENT: '.control-sidebar-content',
      DATA_TOGGLE: '[data-widget="control-sidebar"]',
      CONTENT: '.content-wrapper',
      HEADER: '.main-header',
      FOOTER: '.main-footer'
    };
    var ClassName = {
      CONTROL_SIDEBAR_ANIMATE: 'control-sidebar-animate',
      CONTROL_SIDEBAR_OPEN: 'control-sidebar-open',
      CONTROL_SIDEBAR_SLIDE: 'control-sidebar-slide-open',
      LAYOUT_FIXED: 'layout-fixed',
      NAVBAR_FIXED: 'layout-navbar-fixed',
      NAVBAR_SM_FIXED: 'layout-sm-navbar-fixed',
      NAVBAR_MD_FIXED: 'layout-md-navbar-fixed',
      NAVBAR_LG_FIXED: 'layout-lg-navbar-fixed',
      NAVBAR_XL_FIXED: 'layout-xl-navbar-fixed',
      FOOTER_FIXED: 'layout-footer-fixed',
      FOOTER_SM_FIXED: 'layout-sm-footer-fixed',
      FOOTER_MD_FIXED: 'layout-md-footer-fixed',
      FOOTER_LG_FIXED: 'layout-lg-footer-fixed',
      FOOTER_XL_FIXED: 'layout-xl-footer-fixed'
    };
    var Default = {
      controlsidebarSlide: true,
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'l'
    };
    /**
     * Class Definition
     * ====================================================
     */

    var ControlSidebar = /*#__PURE__*/function () {
      function ControlSidebar(element, config) {
        this._element = element;
        this._config = config;

        this._init();
      } // Public


      var _proto = ControlSidebar.prototype;

      _proto.collapse = function collapse() {
        // Show the control sidebar
        if (this._config.controlsidebarSlide) {
          $('html').addClass(ClassName.CONTROL_SIDEBAR_ANIMATE);
          $('body').removeClass(ClassName.CONTROL_SIDEBAR_SLIDE).delay(300).queue(function () {
            $(Selector.CONTROL_SIDEBAR).hide();
            $('html').removeClass(ClassName.CONTROL_SIDEBAR_ANIMATE);
            $(this).dequeue();
          });
        } else {
          $('body').removeClass(ClassName.CONTROL_SIDEBAR_OPEN);
        }

        var collapsedEvent = $.Event(Event.COLLAPSED);
        $(this._element).trigger(collapsedEvent);
      };

      _proto.show = function show() {
        // Collapse the control sidebar
        if (this._config.controlsidebarSlide) {
          $('html').addClass(ClassName.CONTROL_SIDEBAR_ANIMATE);
          $(Selector.CONTROL_SIDEBAR).show().delay(10).queue(function () {
            $('body').addClass(ClassName.CONTROL_SIDEBAR_SLIDE).delay(300).queue(function () {
              $('html').removeClass(ClassName.CONTROL_SIDEBAR_ANIMATE);
              $(this).dequeue();
            });
            $(this).dequeue();
          });
        } else {
          $('body').addClass(ClassName.CONTROL_SIDEBAR_OPEN);
        }

        var expandedEvent = $.Event(Event.EXPANDED);
        $(this._element).trigger(expandedEvent);
      };

      _proto.toggle = function toggle() {
        var shouldClose = $('body').hasClass(ClassName.CONTROL_SIDEBAR_OPEN) || $('body').hasClass(ClassName.CONTROL_SIDEBAR_SLIDE);

        if (shouldClose) {
          // Close the control sidebar
          this.collapse();
        } else {
          // Open the control sidebar
          this.show();
        }
      } // Private
      ;

      _proto._init = function _init() {
        var _this = this;

        this._fixHeight();

        this._fixScrollHeight();

        $(window).resize(function () {
          _this._fixHeight();

          _this._fixScrollHeight();
        });
        $(window).scroll(function () {
          if ($('body').hasClass(ClassName.CONTROL_SIDEBAR_OPEN) || $('body').hasClass(ClassName.CONTROL_SIDEBAR_SLIDE)) {
            _this._fixScrollHeight();
          }
        });
      };

      _proto._fixScrollHeight = function _fixScrollHeight() {
        var heights = {
          scroll: $(document).height(),
          window: $(window).height(),
          header: $(Selector.HEADER).outerHeight(),
          footer: $(Selector.FOOTER).outerHeight()
        };
        var positions = {
          bottom: Math.abs(heights.window + $(window).scrollTop() - heights.scroll),
          top: $(window).scrollTop()
        };
        var navbarFixed = false;
        var footerFixed = false;

        if ($('body').hasClass(ClassName.LAYOUT_FIXED)) {
          if ($('body').hasClass(ClassName.NAVBAR_FIXED) || $('body').hasClass(ClassName.NAVBAR_SM_FIXED) || $('body').hasClass(ClassName.NAVBAR_MD_FIXED) || $('body').hasClass(ClassName.NAVBAR_LG_FIXED) || $('body').hasClass(ClassName.NAVBAR_XL_FIXED)) {
            if ($(Selector.HEADER).css("position") === "fixed") {
              navbarFixed = true;
            }
          }

          if ($('body').hasClass(ClassName.FOOTER_FIXED) || $('body').hasClass(ClassName.FOOTER_SM_FIXED) || $('body').hasClass(ClassName.FOOTER_MD_FIXED) || $('body').hasClass(ClassName.FOOTER_LG_FIXED) || $('body').hasClass(ClassName.FOOTER_XL_FIXED)) {
            if ($(Selector.FOOTER).css("position") === "fixed") {
              footerFixed = true;
            }
          }

          if (positions.top === 0 && positions.bottom === 0) {
            $(Selector.CONTROL_SIDEBAR).css('bottom', heights.footer);
            $(Selector.CONTROL_SIDEBAR).css('top', heights.header);
            $(Selector.CONTROL_SIDEBAR + ', ' + Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', heights.window - (heights.header + heights.footer));
          } else if (positions.bottom <= heights.footer) {
            if (footerFixed === false) {
              $(Selector.CONTROL_SIDEBAR).css('bottom', heights.footer - positions.bottom);
              $(Selector.CONTROL_SIDEBAR + ', ' + Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', heights.window - (heights.footer - positions.bottom));
            } else {
              $(Selector.CONTROL_SIDEBAR).css('bottom', heights.footer);
            }
          } else if (positions.top <= heights.header) {
            if (navbarFixed === false) {
              $(Selector.CONTROL_SIDEBAR).css('top', heights.header - positions.top);
              $(Selector.CONTROL_SIDEBAR + ', ' + Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', heights.window - (heights.header - positions.top));
            } else {
              $(Selector.CONTROL_SIDEBAR).css('top', heights.header);
            }
          } else {
            if (navbarFixed === false) {
              $(Selector.CONTROL_SIDEBAR).css('top', 0);
              $(Selector.CONTROL_SIDEBAR + ', ' + Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', heights.window);
            } else {
              $(Selector.CONTROL_SIDEBAR).css('top', heights.header);
            }
          }
        }
      };

      _proto._fixHeight = function _fixHeight() {
        var heights = {
          window: $(window).height(),
          header: $(Selector.HEADER).outerHeight(),
          footer: $(Selector.FOOTER).outerHeight()
        };

        if ($('body').hasClass(ClassName.LAYOUT_FIXED)) {
          var sidebarHeight = heights.window - heights.header;

          if ($('body').hasClass(ClassName.FOOTER_FIXED) || $('body').hasClass(ClassName.FOOTER_SM_FIXED) || $('body').hasClass(ClassName.FOOTER_MD_FIXED) || $('body').hasClass(ClassName.FOOTER_LG_FIXED) || $('body').hasClass(ClassName.FOOTER_XL_FIXED)) {
            if ($(Selector.FOOTER).css("position") === "fixed") {
              sidebarHeight = heights.window - heights.header - heights.footer;
            }
          }

          $(Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).css('height', sidebarHeight);

          if (typeof $.fn.overlayScrollbars !== 'undefined') {
            $(Selector.CONTROL_SIDEBAR + ' ' + Selector.CONTROL_SIDEBAR_CONTENT).overlayScrollbars({
              className: this._config.scrollbarTheme,
              sizeAutoCapable: true,
              scrollbars: {
                autoHide: this._config.scrollbarAutoHide,
                clickScrolling: true
              }
            });
          }
        }
      } // Static
      ;

      ControlSidebar._jQueryInterface = function _jQueryInterface(operation) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _options = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new ControlSidebar(this, _options);
            $(this).data(DATA_KEY, data);
          }

          if (data[operation] === 'undefined') {
            throw new Error(operation + " is not a function");
          }

          data[operation]();
        });
      };

      return ControlSidebar;
    }();
    /**
     *
     * Data Api implementation
     * ====================================================
     */


    $(document).on('click', Selector.DATA_TOGGLE, function (event) {
      event.preventDefault();

      ControlSidebar._jQueryInterface.call($(this), 'toggle');
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = ControlSidebar._jQueryInterface;
    $.fn[NAME].Constructor = ControlSidebar;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return ControlSidebar._jQueryInterface;
    };

    return ControlSidebar;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE Layout.js
   * License MIT
   * --------------------------------------------
   */
  var Layout = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'Layout';
    var DATA_KEY = 'lte.layout';
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Selector = {
      HEADER: '.main-header',
      MAIN_SIDEBAR: '.main-sidebar',
      SIDEBAR: '.main-sidebar .sidebar',
      CONTENT: '.content-wrapper',
      BRAND: '.brand-link',
      CONTENT_HEADER: '.content-header',
      WRAPPER: '.wrapper',
      CONTROL_SIDEBAR: '.control-sidebar',
      CONTROL_SIDEBAR_CONTENT: '.control-sidebar-content',
      CONTROL_SIDEBAR_BTN: '[data-widget="control-sidebar"]',
      LAYOUT_FIXED: '.layout-fixed',
      FOOTER: '.main-footer',
      PUSHMENU_BTN: '[data-widget="pushmenu"]',
      LOGIN_BOX: '.login-box',
      REGISTER_BOX: '.register-box'
    };
    var ClassName = {
      HOLD: 'hold-transition',
      SIDEBAR: 'main-sidebar',
      CONTENT_FIXED: 'content-fixed',
      SIDEBAR_FOCUSED: 'sidebar-focused',
      LAYOUT_FIXED: 'layout-fixed',
      NAVBAR_FIXED: 'layout-navbar-fixed',
      FOOTER_FIXED: 'layout-footer-fixed',
      LOGIN_PAGE: 'login-page',
      REGISTER_PAGE: 'register-page',
      CONTROL_SIDEBAR_SLIDE_OPEN: 'control-sidebar-slide-open',
      CONTROL_SIDEBAR_OPEN: 'control-sidebar-open'
    };
    var Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'l',
      panelAutoHeight: true,
      loginRegisterAutoHeight: true
    };
    /**
     * Class Definition
     * ====================================================
     */

    var Layout = /*#__PURE__*/function () {
      function Layout(element, config) {
        this._config = config;
        this._element = element;

        this._init();
      } // Public


      var _proto = Layout.prototype;

      _proto.fixLayoutHeight = function fixLayoutHeight(extra) {
        if (extra === void 0) {
          extra = null;
        }

        var control_sidebar = 0;

        if ($('body').hasClass(ClassName.CONTROL_SIDEBAR_SLIDE_OPEN) || $('body').hasClass(ClassName.CONTROL_SIDEBAR_OPEN) || extra == 'control_sidebar') {
          control_sidebar = $(Selector.CONTROL_SIDEBAR_CONTENT).height();
        }

        var heights = {
          window: $(window).height(),
          header: $(Selector.HEADER).length !== 0 ? $(Selector.HEADER).outerHeight() : 0,
          footer: $(Selector.FOOTER).length !== 0 ? $(Selector.FOOTER).outerHeight() : 0,
          sidebar: $(Selector.SIDEBAR).length !== 0 ? $(Selector.SIDEBAR).height() : 0,
          control_sidebar: control_sidebar
        };

        var max = this._max(heights);

        var offset = this._config.panelAutoHeight;

        if (offset === true) {
          offset = 0;
        }

        if (offset !== false) {
          if (max == heights.control_sidebar) {
            $(Selector.CONTENT).css('min-height', max + offset);
          } else if (max == heights.window) {
            $(Selector.CONTENT).css('min-height', max + offset - heights.header - heights.footer);
          } else {
            $(Selector.CONTENT).css('min-height', max + offset - heights.header);
          }

          if (this._isFooterFixed()) {
            $(Selector.CONTENT).css('min-height', parseFloat($(Selector.CONTENT).css('min-height')) + heights.footer);
          }
        }

        if ($('body').hasClass(ClassName.LAYOUT_FIXED)) {
          if (offset !== false) {
            $(Selector.CONTENT).css('min-height', max + offset - heights.header - heights.footer);
          }

          if (typeof $.fn.overlayScrollbars !== 'undefined') {
            $(Selector.SIDEBAR).overlayScrollbars({
              className: this._config.scrollbarTheme,
              sizeAutoCapable: true,
              scrollbars: {
                autoHide: this._config.scrollbarAutoHide,
                clickScrolling: true
              }
            });
          }
        }
      };

      _proto.fixLoginRegisterHeight = function fixLoginRegisterHeight() {
        if ($(Selector.LOGIN_BOX + ', ' + Selector.REGISTER_BOX).length === 0) {
          $('body, html').css('height', 'auto');
        } else if ($(Selector.LOGIN_BOX + ', ' + Selector.REGISTER_BOX).length !== 0) {
          var box_height = $(Selector.LOGIN_BOX + ', ' + Selector.REGISTER_BOX).height();

          if ($('body').css('min-height') !== box_height) {
            $('body').css('min-height', box_height);
          }
        }
      } // Private
      ;

      _proto._init = function _init() {
        var _this = this;

        // Activate layout height watcher
        this.fixLayoutHeight();

        if (this._config.loginRegisterAutoHeight === true) {
          this.fixLoginRegisterHeight();
        } else if (Number.isInteger(this._config.loginRegisterAutoHeight)) {
          setInterval(this.fixLoginRegisterHeight, this._config.loginRegisterAutoHeight);
        }

        $(Selector.SIDEBAR).on('collapsed.lte.treeview expanded.lte.treeview', function () {
          _this.fixLayoutHeight();
        });
        $(Selector.PUSHMENU_BTN).on('collapsed.lte.pushmenu shown.lte.pushmenu', function () {
          _this.fixLayoutHeight();
        });
        $(Selector.CONTROL_SIDEBAR_BTN).on('collapsed.lte.controlsidebar', function () {
          _this.fixLayoutHeight();
        }).on('expanded.lte.controlsidebar', function () {
          _this.fixLayoutHeight('control_sidebar');
        });
        $(window).resize(function () {
          _this.fixLayoutHeight();
        });
        setTimeout(function () {
          $('body.hold-transition').removeClass('hold-transition');
        }, 50);
      };

      _proto._max = function _max(numbers) {
        // Calculate the maximum number in a list
        var max = 0;
        Object.keys(numbers).forEach(function (key) {
          if (numbers[key] > max) {
            max = numbers[key];
          }
        });
        return max;
      };

      _proto._isFooterFixed = function _isFooterFixed() {
        return $('.main-footer').css('position') === 'fixed';
      } // Static
      ;

      Layout._jQueryInterface = function _jQueryInterface(config) {
        if (config === void 0) {
          config = '';
        }

        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _options = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new Layout($(this), _options);
            $(this).data(DATA_KEY, data);
          }

          if (config === 'init' || config === '') {
            data['_init']();
          } else if (config === 'fixLayoutHeight' || config === 'fixLoginRegisterHeight') {
            data[config]();
          }
        });
      };

      return Layout;
    }();
    /**
     * Data API
     * ====================================================
     */


    $(window).on('load', function () {
      Layout._jQueryInterface.call($('body'));
    });
    $(Selector.SIDEBAR + ' a').on('focusin', function () {
      $(Selector.MAIN_SIDEBAR).addClass(ClassName.SIDEBAR_FOCUSED);
    });
    $(Selector.SIDEBAR + ' a').on('focusout', function () {
      $(Selector.MAIN_SIDEBAR).removeClass(ClassName.SIDEBAR_FOCUSED);
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = Layout._jQueryInterface;
    $.fn[NAME].Constructor = Layout;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return Layout._jQueryInterface;
    };

    return Layout;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE PushMenu.js
   * License MIT
   * --------------------------------------------
   */
  var PushMenu = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'PushMenu';
    var DATA_KEY = 'lte.pushmenu';
    var EVENT_KEY = "." + DATA_KEY;
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      COLLAPSED: "collapsed" + EVENT_KEY,
      SHOWN: "shown" + EVENT_KEY
    };
    var Default = {
      autoCollapseSize: 992,
      enableRemember: false,
      noTransitionAfterReload: true
    };
    var Selector = {
      TOGGLE_BUTTON: '[data-widget="pushmenu"]',
      SIDEBAR_MINI: '.sidebar-mini',
      SIDEBAR_COLLAPSED: '.sidebar-collapse',
      BODY: 'body',
      OVERLAY: '#sidebar-overlay',
      WRAPPER: '.wrapper'
    };
    var ClassName = {
      COLLAPSED: 'sidebar-collapse',
      OPEN: 'sidebar-open',
      CLOSED: 'sidebar-closed'
    };
    /**
     * Class Definition
     * ====================================================
     */

    var PushMenu = /*#__PURE__*/function () {
      function PushMenu(element, options) {
        this._element = element;
        this._options = $.extend({}, Default, options);

        if (!$(Selector.OVERLAY).length) {
          this._addOverlay();
        }

        this._init();
      } // Public


      var _proto = PushMenu.prototype;

      _proto.expand = function expand() {
        if (this._options.autoCollapseSize) {
          if ($(window).width() <= this._options.autoCollapseSize) {
            $(Selector.BODY).addClass(ClassName.OPEN);
          }
        }

        $(Selector.BODY).removeClass(ClassName.COLLAPSED).removeClass(ClassName.CLOSED);

        if (this._options.enableRemember) {
          localStorage.setItem("remember" + EVENT_KEY, ClassName.OPEN);
        }

        var shownEvent = $.Event(Event.SHOWN);
        $(this._element).trigger(shownEvent);
      };

      _proto.collapse = function collapse() {
        if (this._options.autoCollapseSize) {
          if ($(window).width() <= this._options.autoCollapseSize) {
            $(Selector.BODY).removeClass(ClassName.OPEN).addClass(ClassName.CLOSED);
          }
        }

        $(Selector.BODY).addClass(ClassName.COLLAPSED);

        if (this._options.enableRemember) {
          localStorage.setItem("remember" + EVENT_KEY, ClassName.COLLAPSED);
        }

        var collapsedEvent = $.Event(Event.COLLAPSED);
        $(this._element).trigger(collapsedEvent);
      };

      _proto.toggle = function toggle() {
        if (!$(Selector.BODY).hasClass(ClassName.COLLAPSED)) {
          this.collapse();
        } else {
          this.expand();
        }
      };

      _proto.autoCollapse = function autoCollapse(resize) {
        if (resize === void 0) {
          resize = false;
        }

        if (this._options.autoCollapseSize) {
          if ($(window).width() <= this._options.autoCollapseSize) {
            if (!$(Selector.BODY).hasClass(ClassName.OPEN)) {
              this.collapse();
            }
          } else if (resize == true) {
            if ($(Selector.BODY).hasClass(ClassName.OPEN)) {
              $(Selector.BODY).removeClass(ClassName.OPEN);
            } else if ($(Selector.BODY).hasClass(ClassName.CLOSED)) {
              this.expand();
            }
          }
        }
      };

      _proto.remember = function remember() {
        if (this._options.enableRemember) {
          var toggleState = localStorage.getItem("remember" + EVENT_KEY);

          if (toggleState == ClassName.COLLAPSED) {
            if (this._options.noTransitionAfterReload) {
              $("body").addClass('hold-transition').addClass(ClassName.COLLAPSED).delay(50).queue(function () {
                $(this).removeClass('hold-transition');
                $(this).dequeue();
              });
            } else {
              $("body").addClass(ClassName.COLLAPSED);
            }
          } else {
            if (this._options.noTransitionAfterReload) {
              $("body").addClass('hold-transition').removeClass(ClassName.COLLAPSED).delay(50).queue(function () {
                $(this).removeClass('hold-transition');
                $(this).dequeue();
              });
            } else {
              $("body").removeClass(ClassName.COLLAPSED);
            }
          }
        }
      } // Private
      ;

      _proto._init = function _init() {
        var _this = this;

        this.remember();
        this.autoCollapse();
        $(window).resize(function () {
          _this.autoCollapse(true);
        });
      };

      _proto._addOverlay = function _addOverlay() {
        var _this2 = this;

        var overlay = $('<div />', {
          id: 'sidebar-overlay'
        });
        overlay.on('click', function () {
          _this2.collapse();
        });
        $(Selector.WRAPPER).append(overlay);
      } // Static
      ;

      PushMenu._jQueryInterface = function _jQueryInterface(operation) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _options = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new PushMenu(this, _options);
            $(this).data(DATA_KEY, data);
          }

          if (typeof operation === 'string' && operation.match(/collapse|expand|toggle/)) {
            data[operation]();
          }
        });
      };

      return PushMenu;
    }();
    /**
     * Data API
     * ====================================================
     */


    $(document).on('click', Selector.TOGGLE_BUTTON, function (event) {
      event.preventDefault();
      var button = event.currentTarget;

      if ($(button).data('widget') !== 'pushmenu') {
        button = $(button).closest(Selector.TOGGLE_BUTTON);
      }

      PushMenu._jQueryInterface.call($(button), 'toggle');
    });
    $(window).on('load', function () {
      PushMenu._jQueryInterface.call($(Selector.TOGGLE_BUTTON));
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = PushMenu._jQueryInterface;
    $.fn[NAME].Constructor = PushMenu;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return PushMenu._jQueryInterface;
    };

    return PushMenu;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE Treeview.js
   * License MIT
   * --------------------------------------------
   */
  var Treeview = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'Treeview';
    var DATA_KEY = 'lte.treeview';
    var EVENT_KEY = "." + DATA_KEY;
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      SELECTED: "selected" + EVENT_KEY,
      EXPANDED: "expanded" + EVENT_KEY,
      COLLAPSED: "collapsed" + EVENT_KEY,
      LOAD_DATA_API: "load" + EVENT_KEY
    };
    var Selector = {
      LI: '.nav-item',
      LINK: '.nav-link',
      TREEVIEW_MENU: '.nav-treeview',
      OPEN: '.menu-open',
      DATA_WIDGET: '[data-widget="treeview"]'
    };
    var ClassName = {
      LI: 'nav-item',
      LINK: 'nav-link',
      TREEVIEW_MENU: 'nav-treeview',
      OPEN: 'menu-open',
      SIDEBAR_COLLAPSED: 'sidebar-collapse'
    };
    var Default = {
      trigger: Selector.DATA_WIDGET + " " + Selector.LINK,
      animationSpeed: 300,
      accordion: true,
      expandSidebar: false,
      sidebarButtonSelector: '[data-widget="pushmenu"]'
    };
    /**
     * Class Definition
     * ====================================================
     */

    var Treeview = /*#__PURE__*/function () {
      function Treeview(element, config) {
        this._config = config;
        this._element = element;
      } // Public


      var _proto = Treeview.prototype;

      _proto.init = function init() {
        this._setupListeners();
      };

      _proto.expand = function expand(treeviewMenu, parentLi) {
        var _this = this;

        var expandedEvent = $.Event(Event.EXPANDED);

        if (this._config.accordion) {
          var openMenuLi = parentLi.siblings(Selector.OPEN).first();
          var openTreeview = openMenuLi.find(Selector.TREEVIEW_MENU).first();
          this.collapse(openTreeview, openMenuLi);
        }

        treeviewMenu.stop().slideDown(this._config.animationSpeed, function () {
          parentLi.addClass(ClassName.OPEN);
          $(_this._element).trigger(expandedEvent);
        });

        if (this._config.expandSidebar) {
          this._expandSidebar();
        }
      };

      _proto.collapse = function collapse(treeviewMenu, parentLi) {
        var _this2 = this;

        var collapsedEvent = $.Event(Event.COLLAPSED);
        treeviewMenu.stop().slideUp(this._config.animationSpeed, function () {
          parentLi.removeClass(ClassName.OPEN);
          $(_this2._element).trigger(collapsedEvent);
          treeviewMenu.find(Selector.OPEN + " > " + Selector.TREEVIEW_MENU).slideUp();
          treeviewMenu.find(Selector.OPEN).removeClass(ClassName.OPEN);
        });
      };

      _proto.toggle = function toggle(event) {
        var $relativeTarget = $(event.currentTarget);
        var $parent = $relativeTarget.parent();
        var treeviewMenu = $parent.find('> ' + Selector.TREEVIEW_MENU);

        if (!treeviewMenu.is(Selector.TREEVIEW_MENU)) {
          if (!$parent.is(Selector.LI)) {
            treeviewMenu = $parent.parent().find('> ' + Selector.TREEVIEW_MENU);
          }

          if (!treeviewMenu.is(Selector.TREEVIEW_MENU)) {
            return;
          }
        }

        event.preventDefault();
        var parentLi = $relativeTarget.parents(Selector.LI).first();
        var isOpen = parentLi.hasClass(ClassName.OPEN);

        if (isOpen) {
          this.collapse($(treeviewMenu), parentLi);
        } else {
          this.expand($(treeviewMenu), parentLi);
        }
      } // Private
      ;

      _proto._setupListeners = function _setupListeners() {
        var _this3 = this;

        $(document).on('click', this._config.trigger, function (event) {
          _this3.toggle(event);
        });
      };

      _proto._expandSidebar = function _expandSidebar() {
        if ($('body').hasClass(ClassName.SIDEBAR_COLLAPSED)) {
          $(this._config.sidebarButtonSelector).PushMenu('expand');
        }
      } // Static
      ;

      Treeview._jQueryInterface = function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _options = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new Treeview($(this), _options);
            $(this).data(DATA_KEY, data);
          }

          if (config === 'init') {
            data[config]();
          }
        });
      };

      return Treeview;
    }();
    /**
     * Data API
     * ====================================================
     */


    $(window).on(Event.LOAD_DATA_API, function () {
      $(Selector.DATA_WIDGET).each(function () {
        Treeview._jQueryInterface.call($(this), 'init');
      });
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = Treeview._jQueryInterface;
    $.fn[NAME].Constructor = Treeview;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return Treeview._jQueryInterface;
    };

    return Treeview;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE DirectChat.js
   * License MIT
   * --------------------------------------------
   */
  var DirectChat = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'DirectChat';
    var DATA_KEY = 'lte.directchat';
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      TOGGLED: "toggled{EVENT_KEY}"
    };
    var Selector = {
      DATA_TOGGLE: '[data-widget="chat-pane-toggle"]',
      DIRECT_CHAT: '.direct-chat'
    };
    var ClassName = {
      DIRECT_CHAT_OPEN: 'direct-chat-contacts-open'
    };
    /**
     * Class Definition
     * ====================================================
     */

    var DirectChat = /*#__PURE__*/function () {
      function DirectChat(element, config) {
        this._element = element;
      }

      var _proto = DirectChat.prototype;

      _proto.toggle = function toggle() {
        $(this._element).parents(Selector.DIRECT_CHAT).first().toggleClass(ClassName.DIRECT_CHAT_OPEN);
        var toggledEvent = $.Event(Event.TOGGLED);
        $(this._element).trigger(toggledEvent);
      } // Static
      ;

      DirectChat._jQueryInterface = function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          if (!data) {
            data = new DirectChat($(this));
            $(this).data(DATA_KEY, data);
          }

          data[config]();
        });
      };

      return DirectChat;
    }();
    /**
     *
     * Data Api implementation
     * ====================================================
     */


    $(document).on('click', Selector.DATA_TOGGLE, function (event) {
      if (event) event.preventDefault();

      DirectChat._jQueryInterface.call($(this), 'toggle');
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = DirectChat._jQueryInterface;
    $.fn[NAME].Constructor = DirectChat;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return DirectChat._jQueryInterface;
    };

    return DirectChat;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE TodoList.js
   * License MIT
   * --------------------------------------------
   */
  var TodoList = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'TodoList';
    var DATA_KEY = 'lte.todolist';
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Selector = {
      DATA_TOGGLE: '[data-widget="todo-list"]'
    };
    var ClassName = {
      TODO_LIST_DONE: 'done'
    };
    var Default = {
      onCheck: function onCheck(item) {
        return item;
      },
      onUnCheck: function onUnCheck(item) {
        return item;
      }
    };
    /**
     * Class Definition
     * ====================================================
     */

    var TodoList = /*#__PURE__*/function () {
      function TodoList(element, config) {
        this._config = config;
        this._element = element;

        this._init();
      } // Public


      var _proto = TodoList.prototype;

      _proto.toggle = function toggle(item) {
        item.parents('li').toggleClass(ClassName.TODO_LIST_DONE);

        if (!$(item).prop('checked')) {
          this.unCheck($(item));
          return;
        }

        this.check(item);
      };

      _proto.check = function check(item) {
        this._config.onCheck.call(item);
      };

      _proto.unCheck = function unCheck(item) {
        this._config.onUnCheck.call(item);
      } // Private
      ;

      _proto._init = function _init() {
        var that = this;
        $(Selector.DATA_TOGGLE).find('input:checkbox:checked').parents('li').toggleClass(ClassName.TODO_LIST_DONE);
        $(Selector.DATA_TOGGLE).on('change', 'input:checkbox', function (event) {
          that.toggle($(event.target));
        });
      } // Static
      ;

      TodoList._jQueryInterface = function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _options = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new TodoList($(this), _options);
            $(this).data(DATA_KEY, data);
          }

          if (config === 'init') {
            data[config]();
          }
        });
      };

      return TodoList;
    }();
    /**
     * Data API
     * ====================================================
     */


    $(window).on('load', function () {
      TodoList._jQueryInterface.call($(Selector.DATA_TOGGLE));
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = TodoList._jQueryInterface;
    $.fn[NAME].Constructor = TodoList;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return TodoList._jQueryInterface;
    };

    return TodoList;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE CardWidget.js
   * License MIT
   * --------------------------------------------
   */
  var CardWidget = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'CardWidget';
    var DATA_KEY = 'lte.cardwidget';
    var EVENT_KEY = "." + DATA_KEY;
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      EXPANDED: "expanded" + EVENT_KEY,
      COLLAPSED: "collapsed" + EVENT_KEY,
      MAXIMIZED: "maximized" + EVENT_KEY,
      MINIMIZED: "minimized" + EVENT_KEY,
      REMOVED: "removed" + EVENT_KEY
    };
    var ClassName = {
      CARD: 'card',
      COLLAPSED: 'collapsed-card',
      COLLAPSING: 'collapsing-card',
      EXPANDING: 'expanding-card',
      WAS_COLLAPSED: 'was-collapsed',
      MAXIMIZED: 'maximized-card'
    };
    var Selector = {
      DATA_REMOVE: '[data-card-widget="remove"]',
      DATA_COLLAPSE: '[data-card-widget="collapse"]',
      DATA_MAXIMIZE: '[data-card-widget="maximize"]',
      CARD: "." + ClassName.CARD,
      CARD_HEADER: '.card-header',
      CARD_BODY: '.card-body',
      CARD_FOOTER: '.card-footer',
      COLLAPSED: "." + ClassName.COLLAPSED
    };
    var Default = {
      animationSpeed: 'normal',
      collapseTrigger: Selector.DATA_COLLAPSE,
      removeTrigger: Selector.DATA_REMOVE,
      maximizeTrigger: Selector.DATA_MAXIMIZE,
      collapseIcon: 'fa-minus',
      expandIcon: 'fa-plus',
      maximizeIcon: 'fa-expand',
      minimizeIcon: 'fa-compress'
    };

    var CardWidget = /*#__PURE__*/function () {
      function CardWidget(element, settings) {
        this._element = element;
        this._parent = element.parents(Selector.CARD).first();

        if (element.hasClass(ClassName.CARD)) {
          this._parent = element;
        }

        this._settings = $.extend({}, Default, settings);
      }

      var _proto = CardWidget.prototype;

      _proto.collapse = function collapse() {
        var _this = this;

        this._parent.addClass(ClassName.COLLAPSING).children(Selector.CARD_BODY + ", " + Selector.CARD_FOOTER).slideUp(this._settings.animationSpeed, function () {
          _this._parent.addClass(ClassName.COLLAPSED).removeClass(ClassName.COLLAPSING);
        });

        this._parent.find('> ' + Selector.CARD_HEADER + ' ' + this._settings.collapseTrigger + ' .' + this._settings.collapseIcon).addClass(this._settings.expandIcon).removeClass(this._settings.collapseIcon);

        var collapsed = $.Event(Event.COLLAPSED);

        this._element.trigger(collapsed, this._parent);
      };

      _proto.expand = function expand() {
        var _this2 = this;

        this._parent.addClass(ClassName.EXPANDING).children(Selector.CARD_BODY + ", " + Selector.CARD_FOOTER).slideDown(this._settings.animationSpeed, function () {
          _this2._parent.removeClass(ClassName.COLLAPSED).removeClass(ClassName.EXPANDING);
        });

        this._parent.find('> ' + Selector.CARD_HEADER + ' ' + this._settings.collapseTrigger + ' .' + this._settings.expandIcon).addClass(this._settings.collapseIcon).removeClass(this._settings.expandIcon);

        var expanded = $.Event(Event.EXPANDED);

        this._element.trigger(expanded, this._parent);
      };

      _proto.remove = function remove() {
        this._parent.slideUp();

        var removed = $.Event(Event.REMOVED);

        this._element.trigger(removed, this._parent);
      };

      _proto.toggle = function toggle() {
        if (this._parent.hasClass(ClassName.COLLAPSED)) {
          this.expand();
          return;
        }

        this.collapse();
      };

      _proto.maximize = function maximize() {
        this._parent.find(this._settings.maximizeTrigger + ' .' + this._settings.maximizeIcon).addClass(this._settings.minimizeIcon).removeClass(this._settings.maximizeIcon);

        this._parent.css({
          'height': this._parent.height(),
          'width': this._parent.width(),
          'transition': 'all .15s'
        }).delay(150).queue(function () {
          $(this).addClass(ClassName.MAXIMIZED);
          $('html').addClass(ClassName.MAXIMIZED);

          if ($(this).hasClass(ClassName.COLLAPSED)) {
            $(this).addClass(ClassName.WAS_COLLAPSED);
          }

          $(this).dequeue();
        });

        var maximized = $.Event(Event.MAXIMIZED);

        this._element.trigger(maximized, this._parent);
      };

      _proto.minimize = function minimize() {
        this._parent.find(this._settings.maximizeTrigger + ' .' + this._settings.minimizeIcon).addClass(this._settings.maximizeIcon).removeClass(this._settings.minimizeIcon);

        this._parent.css('cssText', 'height:' + this._parent[0].style.height + ' !important;' + 'width:' + this._parent[0].style.width + ' !important; transition: all .15s;').delay(10).queue(function () {
          $(this).removeClass(ClassName.MAXIMIZED);
          $('html').removeClass(ClassName.MAXIMIZED);
          $(this).css({
            'height': 'inherit',
            'width': 'inherit'
          });

          if ($(this).hasClass(ClassName.WAS_COLLAPSED)) {
            $(this).removeClass(ClassName.WAS_COLLAPSED);
          }

          $(this).dequeue();
        });

        var MINIMIZED = $.Event(Event.MINIMIZED);

        this._element.trigger(MINIMIZED, this._parent);
      };

      _proto.toggleMaximize = function toggleMaximize() {
        if (this._parent.hasClass(ClassName.MAXIMIZED)) {
          this.minimize();
          return;
        }

        this.maximize();
      } // Private
      ;

      _proto._init = function _init(card) {
        var _this3 = this;

        this._parent = card;
        $(this).find(this._settings.collapseTrigger).click(function () {
          _this3.toggle();
        });
        $(this).find(this._settings.maximizeTrigger).click(function () {
          _this3.toggleMaximize();
        });
        $(this).find(this._settings.removeTrigger).click(function () {
          _this3.remove();
        });
      } // Static
      ;

      CardWidget._jQueryInterface = function _jQueryInterface(config) {
        var data = $(this).data(DATA_KEY);

        var _options = $.extend({}, Default, $(this).data());

        if (!data) {
          data = new CardWidget($(this), _options);
          $(this).data(DATA_KEY, typeof config === 'string' ? data : config);
        }

        if (typeof config === 'string' && config.match(/collapse|expand|remove|toggle|maximize|minimize|toggleMaximize/)) {
          data[config]();
        } else if (typeof config === 'object') {
          data._init($(this));
        }
      };

      return CardWidget;
    }();
    /**
     * Data API
     * ====================================================
     */


    $(document).on('click', Selector.DATA_COLLAPSE, function (event) {
      if (event) {
        event.preventDefault();
      }

      CardWidget._jQueryInterface.call($(this), 'toggle');
    });
    $(document).on('click', Selector.DATA_REMOVE, function (event) {
      if (event) {
        event.preventDefault();
      }

      CardWidget._jQueryInterface.call($(this), 'remove');
    });
    $(document).on('click', Selector.DATA_MAXIMIZE, function (event) {
      if (event) {
        event.preventDefault();
      }

      CardWidget._jQueryInterface.call($(this), 'toggleMaximize');
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = CardWidget._jQueryInterface;
    $.fn[NAME].Constructor = CardWidget;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return CardWidget._jQueryInterface;
    };

    return CardWidget;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE CardRefresh.js
   * License MIT
   * --------------------------------------------
   */
  var CardRefresh = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'CardRefresh';
    var DATA_KEY = 'lte.cardrefresh';
    var EVENT_KEY = "." + DATA_KEY;
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      LOADED: "loaded" + EVENT_KEY,
      OVERLAY_ADDED: "overlay.added" + EVENT_KEY,
      OVERLAY_REMOVED: "overlay.removed" + EVENT_KEY
    };
    var ClassName = {
      CARD: 'card'
    };
    var Selector = {
      CARD: "." + ClassName.CARD,
      DATA_REFRESH: '[data-card-widget="card-refresh"]'
    };
    var Default = {
      source: '',
      sourceSelector: '',
      params: {},
      trigger: Selector.DATA_REFRESH,
      content: '.card-body',
      loadInContent: true,
      loadOnInit: true,
      responseType: '',
      overlayTemplate: '<div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>',
      onLoadStart: function onLoadStart() {},
      onLoadDone: function onLoadDone(response) {
        return response;
      }
    };

    var CardRefresh = /*#__PURE__*/function () {
      function CardRefresh(element, settings) {
        this._element = element;
        this._parent = element.parents(Selector.CARD).first();
        this._settings = $.extend({}, Default, settings);
        this._overlay = $(this._settings.overlayTemplate);

        if (element.hasClass(ClassName.CARD)) {
          this._parent = element;
        }

        if (this._settings.source === '') {
          throw new Error('Source url was not defined. Please specify a url in your CardRefresh source option.');
        }
      }

      var _proto = CardRefresh.prototype;

      _proto.load = function load() {
        this._addOverlay();

        this._settings.onLoadStart.call($(this));

        $.get(this._settings.source, this._settings.params, function (response) {
          if (this._settings.loadInContent) {
            if (this._settings.sourceSelector != '') {
              response = $(response).find(this._settings.sourceSelector).html();
            }

            this._parent.find(this._settings.content).html(response);
          }

          this._settings.onLoadDone.call($(this), response);

          this._removeOverlay();
        }.bind(this), this._settings.responseType !== '' && this._settings.responseType);
        var loadedEvent = $.Event(Event.LOADED);
        $(this._element).trigger(loadedEvent);
      };

      _proto._addOverlay = function _addOverlay() {
        this._parent.append(this._overlay);

        var overlayAddedEvent = $.Event(Event.OVERLAY_ADDED);
        $(this._element).trigger(overlayAddedEvent);
      };

      _proto._removeOverlay = function _removeOverlay() {
        this._parent.find(this._overlay).remove();

        var overlayRemovedEvent = $.Event(Event.OVERLAY_REMOVED);
        $(this._element).trigger(overlayRemovedEvent);
      };

      // Private
      _proto._init = function _init(card) {
        var _this = this;

        $(this).find(this._settings.trigger).on('click', function () {
          _this.load();
        });

        if (this._settings.loadOnInit) {
          this.load();
        }
      } // Static
      ;

      CardRefresh._jQueryInterface = function _jQueryInterface(config) {
        var data = $(this).data(DATA_KEY);

        var _options = $.extend({}, Default, $(this).data());

        if (!data) {
          data = new CardRefresh($(this), _options);
          $(this).data(DATA_KEY, typeof config === 'string' ? data : config);
        }

        if (typeof config === 'string' && config.match(/load/)) {
          data[config]();
        } else {
          data._init($(this));
        }
      };

      return CardRefresh;
    }();
    /**
     * Data API
     * ====================================================
     */


    $(document).on('click', Selector.DATA_REFRESH, function (event) {
      if (event) {
        event.preventDefault();
      }

      CardRefresh._jQueryInterface.call($(this), 'load');
    });
    $(document).ready(function () {
      $(Selector.DATA_REFRESH).each(function () {
        CardRefresh._jQueryInterface.call($(this));
      });
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = CardRefresh._jQueryInterface;
    $.fn[NAME].Constructor = CardRefresh;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return CardRefresh._jQueryInterface;
    };

    return CardRefresh;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE Dropdown.js
   * License MIT
   * --------------------------------------------
   */
  var Dropdown = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'Dropdown';
    var DATA_KEY = 'lte.dropdown';
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Selector = {
      NAVBAR: '.navbar',
      DROPDOWN_MENU: '.dropdown-menu',
      DROPDOWN_MENU_ACTIVE: '.dropdown-menu.show',
      DROPDOWN_TOGGLE: '[data-toggle="dropdown"]'
    };
    var ClassName = {
      DROPDOWN_HOVER: 'dropdown-hover',
      DROPDOWN_RIGHT: 'dropdown-menu-right'
    };
    var Default = {};
    /**
     * Class Definition
     * ====================================================
     */

    var Dropdown = /*#__PURE__*/function () {
      function Dropdown(element, config) {
        this._config = config;
        this._element = element;
      } // Public


      var _proto = Dropdown.prototype;

      _proto.toggleSubmenu = function toggleSubmenu() {
        this._element.siblings().show().toggleClass("show");

        if (!this._element.next().hasClass('show')) {
          this._element.parents('.dropdown-menu').first().find('.show').removeClass("show").hide();
        }

        this._element.parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
          $('.dropdown-submenu .show').removeClass("show").hide();
        });
      };

      _proto.fixPosition = function fixPosition() {
        var elm = $(Selector.DROPDOWN_MENU_ACTIVE);

        if (elm.length !== 0) {
          if (elm.hasClass(ClassName.DROPDOWN_RIGHT)) {
            elm.css('left', 'inherit');
            elm.css('right', 0);
          } else {
            elm.css('left', 0);
            elm.css('right', 'inherit');
          }

          var offset = elm.offset();
          var width = elm.width();
          var windowWidth = $(window).width();
          var visiblePart = windowWidth - offset.left;

          if (offset.left < 0) {
            elm.css('left', 'inherit');
            elm.css('right', offset.left - 5);
          } else {
            if (visiblePart < width) {
              elm.css('left', 'inherit');
              elm.css('right', 0);
            }
          }
        }
      } // Static
      ;

      Dropdown._jQueryInterface = function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          var _config = $.extend({}, Default, $(this).data());

          if (!data) {
            data = new Dropdown($(this), _config);
            $(this).data(DATA_KEY, data);
          }

          if (config === 'toggleSubmenu' || config == 'fixPosition') {
            data[config]();
          }
        });
      };

      return Dropdown;
    }();
    /**
     * Data API
     * ====================================================
     */


    $(Selector.DROPDOWN_MENU + ' ' + Selector.DROPDOWN_TOGGLE).on("click", function (event) {
      event.preventDefault();
      event.stopPropagation();

      Dropdown._jQueryInterface.call($(this), 'toggleSubmenu');
    });
    $(Selector.NAVBAR + ' ' + Selector.DROPDOWN_TOGGLE).on("click", function (event) {
      event.preventDefault();
      setTimeout(function () {
        Dropdown._jQueryInterface.call($(this), 'fixPosition');
      }, 1);
    });
    /**
     * jQuery API
     * ====================================================
     */

    $.fn[NAME] = Dropdown._jQueryInterface;
    $.fn[NAME].Constructor = Dropdown;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return Dropdown._jQueryInterface;
    };

    return Dropdown;
  }(jQuery);

  /**
   * --------------------------------------------
   * AdminLTE Toasts.js
   * License MIT
   * --------------------------------------------
   */
  var Toasts = function ($) {
    /**
     * Constants
     * ====================================================
     */
    var NAME = 'Toasts';
    var DATA_KEY = 'lte.toasts';
    var EVENT_KEY = "." + DATA_KEY;
    var JQUERY_NO_CONFLICT = $.fn[NAME];
    var Event = {
      INIT: "init" + EVENT_KEY,
      CREATED: "created" + EVENT_KEY,
      REMOVED: "removed" + EVENT_KEY
    };
    var Selector = {
      BODY: 'toast-body',
      CONTAINER_TOP_RIGHT: '#toastsContainerTopRight',
      CONTAINER_TOP_LEFT: '#toastsContainerTopLeft',
      CONTAINER_BOTTOM_RIGHT: '#toastsContainerBottomRight',
      CONTAINER_BOTTOM_LEFT: '#toastsContainerBottomLeft'
    };
    var ClassName = {
      TOP_RIGHT: 'toasts-top-right',
      TOP_LEFT: 'toasts-top-left',
      BOTTOM_RIGHT: 'toasts-bottom-right',
      BOTTOM_LEFT: 'toasts-bottom-left',
      FADE: 'fade'
    };
    var Position = {
      TOP_RIGHT: 'topRight',
      TOP_LEFT: 'topLeft',
      BOTTOM_RIGHT: 'bottomRight',
      BOTTOM_LEFT: 'bottomLeft'
    };
    var Default = {
      position: Position.TOP_RIGHT,
      fixed: true,
      autohide: false,
      autoremove: true,
      delay: 1000,
      fade: true,
      icon: null,
      image: null,
      imageAlt: null,
      imageHeight: '25px',
      title: null,
      subtitle: null,
      close: true,
      body: null,
      class: null
    };
    /**
     * Class Definition
     * ====================================================
     */

    var Toasts = /*#__PURE__*/function () {
      function Toasts(element, config) {
        this._config = config;

        this._prepareContainer();

        var initEvent = $.Event(Event.INIT);
        $('body').trigger(initEvent);
      } // Public


      var _proto = Toasts.prototype;

      _proto.create = function create() {
        var toast = $('<div class="toast" role="alert" aria-live="assertive" aria-atomic="true"/>');
        toast.data('autohide', this._config.autohide);
        toast.data('animation', this._config.fade);

        if (this._config.class) {
          toast.addClass(this._config.class);
        }

        if (this._config.delay && this._config.delay != 500) {
          toast.data('delay', this._config.delay);
        }

        var toast_header = $('<div class="toast-header">');

        if (this._config.image != null) {
          var toast_image = $('<img />').addClass('rounded mr-2').attr('src', this._config.image).attr('alt', this._config.imageAlt);

          if (this._config.imageHeight != null) {
            toast_image.height(this._config.imageHeight).width('auto');
          }

          toast_header.append(toast_image);
        }

        if (this._config.icon != null) {
          toast_header.append($('<i />').addClass('mr-2').addClass(this._config.icon));
        }

        if (this._config.title != null) {
          toast_header.append($('<strong />').addClass('mr-auto').html(this._config.title));
        }

        if (this._config.subtitle != null) {
          toast_header.append($('<small />').html(this._config.subtitle));
        }

        if (this._config.close == true) {
          var toast_close = $('<button data-dismiss="toast" />').attr('type', 'button').addClass('ml-2 mb-1 close').attr('aria-label', 'Close').append('<span aria-hidden="true">&times;</span>');

          if (this._config.title == null) {
            toast_close.toggleClass('ml-2 ml-auto');
          }

          toast_header.append(toast_close);
        }

        toast.append(toast_header);

        if (this._config.body != null) {
          toast.append($('<div class="toast-body" />').html(this._config.body));
        }

        $(this._getContainerId()).prepend(toast);
        var createdEvent = $.Event(Event.CREATED);
        $('body').trigger(createdEvent);
        toast.toast('show');

        if (this._config.autoremove) {
          toast.on('hidden.bs.toast', function () {
            $(this).delay(200).remove();
            var removedEvent = $.Event(Event.REMOVED);
            $('body').trigger(removedEvent);
          });
        }
      } // Static
      ;

      _proto._getContainerId = function _getContainerId() {
        if (this._config.position == Position.TOP_RIGHT) {
          return Selector.CONTAINER_TOP_RIGHT;
        } else if (this._config.position == Position.TOP_LEFT) {
          return Selector.CONTAINER_TOP_LEFT;
        } else if (this._config.position == Position.BOTTOM_RIGHT) {
          return Selector.CONTAINER_BOTTOM_RIGHT;
        } else if (this._config.position == Position.BOTTOM_LEFT) {
          return Selector.CONTAINER_BOTTOM_LEFT;
        }
      };

      _proto._prepareContainer = function _prepareContainer() {
        if ($(this._getContainerId()).length === 0) {
          var container = $('<div />').attr('id', this._getContainerId().replace('#', ''));

          if (this._config.position == Position.TOP_RIGHT) {
            container.addClass(ClassName.TOP_RIGHT);
          } else if (this._config.position == Position.TOP_LEFT) {
            container.addClass(ClassName.TOP_LEFT);
          } else if (this._config.position == Position.BOTTOM_RIGHT) {
            container.addClass(ClassName.BOTTOM_RIGHT);
          } else if (this._config.position == Position.BOTTOM_LEFT) {
            container.addClass(ClassName.BOTTOM_LEFT);
          }

          $('body').append(container);
        }

        if (this._config.fixed) {
          $(this._getContainerId()).addClass('fixed');
        } else {
          $(this._getContainerId()).removeClass('fixed');
        }
      } // Static
      ;

      Toasts._jQueryInterface = function _jQueryInterface(option, config) {
        return this.each(function () {
          var _options = $.extend({}, Default, config);

          var toast = new Toasts($(this), _options);

          if (option === 'create') {
            toast[option]();
          }
        });
      };

      return Toasts;
    }();
    /**
     * jQuery API
     * ====================================================
     */


    $.fn[NAME] = Toasts._jQueryInterface;
    $.fn[NAME].Constructor = Toasts;

    $.fn[NAME].noConflict = function () {
      $.fn[NAME] = JQUERY_NO_CONFLICT;
      return Toasts._jQueryInterface;
    };

    return Toasts;
  }(jQuery);

  exports.CardRefresh = CardRefresh;
  exports.CardWidget = CardWidget;
  exports.ControlSidebar = ControlSidebar;
  exports.DirectChat = DirectChat;
  exports.Dropdown = Dropdown;
  exports.Layout = Layout;
  exports.PushMenu = PushMenu;
  exports.Toasts = Toasts;
  exports.TodoList = TodoList;
  exports.Treeview = Treeview;

  Object.defineProperty(exports, '__esModule', { value: true });

})));
//# sourceMappingURL=adminlte.js.map

// Logotipo Gesso cidade nova PDF
window.logoPDF = "data:image/png;base64,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"