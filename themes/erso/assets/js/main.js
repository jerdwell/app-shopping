/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./themes/erso/src/js/main.js":
/*!************************************!*\
  !*** ./themes/erso/src/js/main.js ***!
  \************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_Slide__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/Slide */ "./themes/erso/src/js/modules/Slide.js");
/* harmony import */ var _modules_Slide__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_modules_Slide__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _modules_Navbar__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/Navbar */ "./themes/erso/src/js/modules/Navbar.js");
/* harmony import */ var _modules_Navbar__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_modules_Navbar__WEBPACK_IMPORTED_MODULE_1__);


_modules_Slide__WEBPACK_IMPORTED_MODULE_0___default.a.init('main-slide', 8000);

window.onload = function () {
  _modules_Navbar__WEBPACK_IMPORTED_MODULE_1___default.a.init();
};

/***/ }),

/***/ "./themes/erso/src/js/modules/Navbar.js":
/*!**********************************************!*\
  !*** ./themes/erso/src/js/modules/Navbar.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var Navbar = {
  data: {
    class_navbar_fixed: 'navbar-main-erso-fixed',
    class_navbar: 'navbar-main-erso',
    navbar: document.querySelector('.navbar-main-erso'),
    icon_main_menu: document.querySelector('.icon-menu-navbar-erso'),
    main_menu: document.querySelector('.main-menu-erso'),
    main_menu_inactive: 'navbar-main-inactive-erso',
    max_scroll: 300
  },
  init: function init() {
    var _this = this;

    var navbar = this.data.navbar;

    document.onscroll = function () {
      return _this.toggleNavbar();
    };

    this.data.icon_main_menu.addEventListener('click', function () {
      return _this.toggleMainMenu();
    });
  },
  toggleNavbar: function toggleNavbar() {
    var scroll = window.scrollY;

    if (scroll >= this.data.max_scroll) {
      if (!this.data.navbar.classList.contains(this.data.class_navbar_fixed)) this.data.navbar.classList.add(this.data.class_navbar_fixed);
    } else {
      if (this.data.navbar.classList.contains(this.data.class_navbar_fixed)) this.data.navbar.classList.remove(this.data.class_navbar_fixed);
    }
  },
  toggleMainMenu: function toggleMainMenu() {
    var contains = this.data.main_menu.classList.contains(this.data.main_menu_inactive);

    if (!contains) {
      this.data.main_menu.classList.add(this.data.main_menu_inactive);
    } else {
      this.data.main_menu.classList.remove(this.data.main_menu_inactive);
    }
  }
};
module.exports = Navbar;

/***/ }),

/***/ "./themes/erso/src/js/modules/Slide.js":
/*!*********************************************!*\
  !*** ./themes/erso/src/js/modules/Slide.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var Slide = {
  data: {
    target: '',
    slide_container: 'slide-container',
    slide_items: 'slide-item',
    time: null,
    next: 'slide-controls-next',
    prev: 'slide-controls-prev',
    dots: 'dot-indicator',
    index: 0
  },
  init: function init(target, time) {
    var _this = this;

    this.data.target = target;
    this.data.time = time;
    this.sizeSlide();
    window.addEventListener('resize', this.sizeSlide());
    this.slideInterval();
    document.getElementById(this.data.next).addEventListener('click', function () {
      _this.actionControls('next');
    });
    document.getElementById(this.data.prev).addEventListener('click', function () {
      _this.actionControls('prev');
    });
  },

  /**
   * actions in prev and next buttons
   */
  actionControls: function actionControls(action) {
    this.data.index = action == 'next' ? this.data.index + 1 : this.data.index - 1;
    this.moveSlide();
  },

  /**
   * move slide from side
   */
  moveSlide: function moveSlide() {
    var childs = document.querySelectorAll(".".concat(this.data.slide_items));
    if (this.data.index >= childs.length) this.data.index = 0;
    if (this.data.index < 0) this.data.index = childs.length - 1;
    var container = document.querySelector(".".concat(this.data.slide_container));
    container.style.marginLeft = '-' + this.data.index * window.innerWidth + 'px';
    this.setStateDots();
  },

  /**
   * change active - inactive in dots
   */
  setStateDots: function setStateDots() {
    var dots = document.querySelectorAll(".".concat(this.data.dots));
    dots[0].classList.add("".concat(this.data.dots, "-active"));

    for (var dot in Array.from(dots)) {
      if (dots[dot].classList.contains("".concat(this.data.dots, "-active"))) dots[dot].classList.remove("".concat(this.data.dots, "-active"));
    }

    dots[this.data.index].classList.add("".concat(this.data.dots, "-active"));
  },

  /**
   * set the timer to repeat action
   */
  slideInterval: function slideInterval() {
    var _this2 = this;

    var intrvl = setInterval(function () {
      _this2.data.index++;

      _this2.moveSlide();
    }, this.data.time);
    var dots = document.querySelectorAll(".".concat(this.data.dots));
    dots.forEach(function (e) {
      e.addEventListener('click', function (event) {
        var el = event.target;
        _this2.data.index = el.getAttribute('data-index');
        _this2;

        _this2.moveSlide(); //move the slide


        clearInterval(intrvl); //cleart timer to interval

        _this2.slideInterval(); //recursive to restart interval

      });
    });
  },

  /**
   * set the size in slide
   */
  sizeSlide: function sizeSlide() {
    var items = document.querySelectorAll(".".concat(this.data.slide_items));
    var nItems = items.length;
    var container = document.querySelector(".".concat(this.data.slide_container));
    container.style.width = "".concat(nItems * 100, "%");
  }
};
module.exports = Slide; // TODO(erdwell): Add features to touch events

/***/ }),

/***/ "./themes/erso/src/scss/app.sass":
/*!***************************************!*\
  !*** ./themes/erso/src/scss/app.sass ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!**************************************************************************!*\
  !*** multi ./themes/erso/src/js/main.js ./themes/erso/src/scss/app.sass ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/erdwell/Sites/app-shopping/themes/erso/src/js/main.js */"./themes/erso/src/js/main.js");
module.exports = __webpack_require__(/*! /Users/erdwell/Sites/app-shopping/themes/erso/src/scss/app.sass */"./themes/erso/src/scss/app.sass");


/***/ })

/******/ });