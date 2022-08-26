"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_Support_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Footer",
  props: ['asset'],
  data: function data() {
    return {
      date: new Date().getFullYear(),
      showFeatures: false,
      showLegal: false,
      showResource: false,
      showIntegration: false
    };
  },
  methods: {
    toggleShowFeatures: function toggleShowFeatures() {
      this.showFeatures = !this.showFeatures;
    },
    toggleShowLegal: function toggleShowLegal() {
      this.showLegal = !this.showLegal;
    },
    toggleshowResource: function toggleshowResource() {
      this.showResource = !this.showResource;
    },
    toggleshowIntegration: function toggleshowIntegration() {
      this.showIntegration = !this.showIntegration;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/HeaderOne.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/HeaderOne.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _MobileNav_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MobileNav.vue */ "./resources/js/components/MobileNav.vue");
/* harmony import */ var scroll_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! scroll-js */ "./node_modules/scroll-js/dist/scroll.js");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Header",
  props: ['asset'],
  components: {
    MobileNav: _MobileNav_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  emits: ['openLoginModal', 'openRegisterModal'],
  data: function data() {
    return {
      showSolution: false,
      showTryba: false,
      showLearn: false,
      showNav: false,
      loggedIn: window.user.user
    };
  },
  methods: {
    startScrolling: function startScrolling() {
      if (this.$route.name == "Home") {
        var position = document.querySelector('#features'); //.getBoundingClientRect().top;

        (0,scroll_js__WEBPACK_IMPORTED_MODULE_1__.scrollIntoView)(position, document.body, {
          behavior: 'smooth'
        });
      } else {
        var r = this.$router.resolve({
          name: 'Home'
        });
        window.location.assign(r.href);
      }
    },
    toogleNav: function toogleNav() {
      this.showNav = !this.showNav;
    },
    addBackground: function addBackground() {
      var scroll = window.scrollY;
      var menu = document.querySelector("#mobileNavIcon");

      if (scroll > 10) {
        menu.classList.add("fixed");
      } else {
        menu.classList.remove("fixed");
      }
    },
    openLoginModal: function openLoginModal() {
      this.$emit('openLoginModal');
    },
    openRegisterModal: function openRegisterModal() {
      this.$emit('openRegisterModal');
    }
  },
  created: function created() {
    window.addEventListener('scroll', this.addBackground);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  emits: ['closeNav', 'scrollToFeatures', 'LoginModal', 'RegisterModal'],
  data: function data() {
    return {
      loggedIn: window.user.user
    };
  },
  props: ['asset', 'showNav'],
  computed: {
    show: function show() {
      if (this.showNav) {
        this.openNav();
      }

      return this.showNav;
    }
  },
  methods: {
    closeNav: function closeNav() {
      var _this = this;

      this.$refs.menu.classList.add('translate-x-full');
      setTimeout(function () {
        _this.$emit('closeNav');
      }, 300);
    },
    openNav: function openNav() {
      var _this2 = this;

      setTimeout(function () {
        _this2.$refs.menu.classList.remove('translate-x-full');
      }, 100);
    },
    scrollToFeatures: function scrollToFeatures() {
      this.$emit('scrollToFeatures');
      this.closeNav();
    },
    openLoginModal: function openLoginModal() {
      this.$emit('LoginModal');
    },
    openRegisterModal: function openRegisterModal() {
      this.$emit('RegisterModal');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/support/SectionOne.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/support/SectionOne.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Section",
  props: ['asset'],
  data: function data() {
    return {};
  },
  methods: {},
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Support.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Support.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_HeaderOne_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/HeaderOne.vue */ "./resources/js/components/HeaderOne.vue");
/* harmony import */ var _components_Footer_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/Footer.vue */ "./resources/js/components/Footer.vue");
/* harmony import */ var _components_support_SectionOne_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/support/SectionOne.vue */ "./resources/js/components/support/SectionOne.vue");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Support",
  components: {
    Header: _components_HeaderOne_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    Footer: _components_Footer_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    SectionOne: _components_support_SectionOne_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
  },
  data: function data() {
    return {
      assetUrl: window.assetUrl.url
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=template&id=61a7c374":
/*!****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=template&id=61a7c374 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "bg-black/90 overflow-hidden"
};
var _hoisted_2 = {
  "class": "container overflow-hidden mx-auto py-14 px-3 lg:p-24"
};
var _hoisted_3 = {
  "class": "lg:grid px-4 lg:grid-cols-12 lg:gap-6"
};
var _hoisted_4 = {
  "class": "lg:col-span-2"
};
var _hoisted_5 = {
  "class": "flex justify-start -ml-4 lg:justify-start"
};
var _hoisted_6 = ["src"];
var _hoisted_7 = {
  "class": "flex justify-start space-x-4 lg:space-x-0 lg:justify-between my-6 lg:mr-4"
};
var _hoisted_8 = {
  href: "https://facebook.com/tryba.io"
};
var _hoisted_9 = ["src"];
var _hoisted_10 = {
  href: "https://twitter.com/IoTryba"
};
var _hoisted_11 = ["src"];
var _hoisted_12 = {
  href: "https://instagram.com/tryba.io"
};
var _hoisted_13 = ["src"];
var _hoisted_14 = {
  href: "#"
};
var _hoisted_15 = ["src"];

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<div class=\"lg:col-span-10 hidden mt-8 lg:mt-0 lg:grid grid-rows-2 lg:grid-rows-1 lg:grid-flow-row lg:grid-cols-10 grid-flow-col gap-3\"><div class=\"font-inter lg:col-span-2 text-sm\"><h1 class=\"footer-h1 font-semibold\">LEGAL</h1><ul class=\"text-gray-200 my-4 grid grid-rows-1 gap-3 text-sm font-light\"><li><a href=\"terms\" class=\"hover:underline\">Terms and conditions</a></li><li><a href=\"privacy\" class=\"hover:underline\">Privacy Policy</a></li></ul></div><div class=\"font-inter lg:col-span-2 text-sm\"><h1 class=\"footer-h1 font-semibold\">RESOURCES</h1><ul class=\"text-gray-200 my-4 grid grid-rows-1 gap-3 text-sm font-light\"><li><a href=\"faq\" class=\"hover:underline\">FAQs</a></li><li><a href=\"https://helpdesk.tryba.io/\" class=\"hover:underline\">Help Center</a></li></ul></div><div class=\"font-inter lg:col-span-2 text-sm\"><h1 class=\"footer-h1 font-semibold\">INTEGRATIONS</h1><ul class=\"text-gray-200 my-4 grid grid-rows-1 gap-3 text-sm font-light\"><li><a href=\"user/merchant-api\" class=\"hover:underline\">Developers</a></li><li><a href=\"https://tryba.statuspage.io/\" class=\"hover:underline\">System Status</a></li></ul></div><div class=\"font-inter font-light flex flex-col space-y-4 text-xs text-gray-200 lg:col-span-4\"><div> Tryba U.K Limited designs and operates the Tryba websites and app, which offers electronic money (‘e-money’) business current accounts with innovative built-in website and business management functionalities. Modulr FS Limited is authorised and regulated by the Financial Conduct Authority for issuance of electronic money (FRN 900573). </div><div> Tryba card is an electronic money product issued by Modulr FS Limited pursuant to license by Visa Europe. Modulr FS Limited holds an amount equivalent to the money in Tryba’s current accounts in a safeguarding account which gives customers protection against Modulr’s insolvency. </div><div class=\"text-gray-500\"> Tryba © 2022. All Rights Reserved. </div></div></div>", 1);

var _hoisted_17 = {
  "class": "lg:hidden"
};
var _hoisted_18 = {
  "class": "text-gray-200"
};
var _hoisted_19 = {
  "class": "flex flex-col space-y-4 my-6"
};

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "font-bold"
}, "Features", -1
/* HOISTED */
);

var _hoisted_21 = {
  "class": "font-bold"
};

var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "stroke-linecap": "round",
  "stroke-linejoin": "round",
  d: "M19 9l-7 7-7-7"
}, null, -1
/* HOISTED */
);

var _hoisted_23 = [_hoisted_22];
var _hoisted_24 = {
  key: 0
};

var _hoisted_25 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<ul class=\"flex flex-col space-y-4\"><li><a href=\"#\">Website</a></li><li><a href=\"#\">Hosted payment links</a></li><li><a href=\"#\">Invoicing</a></li><li><a href=\"#\">Bookings</a></li><li><a href=\"#\">Expense and budgeting</a></li><li><a href=\"#\">Connect to marketplace</a></li></ul>", 1);

var _hoisted_26 = [_hoisted_25];

var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "font-bold"
}, "Legal", -1
/* HOISTED */
);

var _hoisted_28 = {
  "class": "font-bold"
};

var _hoisted_29 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "stroke-linecap": "round",
  "stroke-linejoin": "round",
  d: "M19 9l-7 7-7-7"
}, null, -1
/* HOISTED */
);

var _hoisted_30 = [_hoisted_29];
var _hoisted_31 = {
  key: 1
};

var _hoisted_32 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", {
  "class": "flex flex-col space-y-4"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "terms",
  "class": "hover:underline"
}, "Terms and conditions")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "privacy",
  "class": "hover:underline"
}, "Privacy Policy")])], -1
/* HOISTED */
);

var _hoisted_33 = [_hoisted_32];

var _hoisted_34 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "font-bold"
}, "Resources", -1
/* HOISTED */
);

var _hoisted_35 = {
  "class": "font-bold"
};

var _hoisted_36 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "stroke-linecap": "round",
  "stroke-linejoin": "round",
  d: "M19 9l-7 7-7-7"
}, null, -1
/* HOISTED */
);

var _hoisted_37 = [_hoisted_36];
var _hoisted_38 = {
  key: 2
};

var _hoisted_39 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", {
  "class": "flex flex-col space-y-4"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "faq",
  "class": "hover:underline"
}, "FAQs")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "https://helpdesk.tryba.io/",
  "class": "hover:underline"
}, "Help Center")])], -1
/* HOISTED */
);

var _hoisted_40 = [_hoisted_39];

var _hoisted_41 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "font-bold"
}, "Integration", -1
/* HOISTED */
);

var _hoisted_42 = {
  "class": "font-bold"
};

var _hoisted_43 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "stroke-linecap": "round",
  "stroke-linejoin": "round",
  d: "M19 9l-7 7-7-7"
}, null, -1
/* HOISTED */
);

var _hoisted_44 = [_hoisted_43];
var _hoisted_45 = {
  key: 3
};

var _hoisted_46 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", {
  "class": "flex flex-col space-y-4"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "user/merchant-api",
  "class": "hover:underline"
}, "Developers")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "https://tryba.statuspage.io/",
  "class": "hover:underline"
}, "System Status")])], -1
/* HOISTED */
);

var _hoisted_47 = [_hoisted_46];

var _hoisted_48 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "font-inter font-light flex flex-col space-y-4 text-xs text-gray-200 lg:col-span-4"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, " Tryba U.K Limited designs and operates the Tryba websites and app, which offers electronic money (‘e-money’) business current accounts with innovative built-in website and business management functionalities. Modulr FS Limited is authorised and regulated by the Financial Conduct Authority for issuance of electronic money (FRN 900573). "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, " Tryba card is an electronic money product issued by Modulr FS Limited pursuant to license by Visa Europe. Modulr FS Limited holds an amount equivalent to the money in Tryba’s current accounts in a safeguarding account which gives customers protection against Modulr’s insolvency. "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "text-gray-500"
}, " Tryba © 2022. All Rights Reserved. ")], -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/logo-white.svg',
    "class": "h-10 w-auto",
    alt: ""
  }, null, 8
  /* PROPS */
  , _hoisted_6)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/facebook.svg',
    "class": "h-4 w-auto",
    alt: ""
  }, null, 8
  /* PROPS */
  , _hoisted_9)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/twitter.svg',
    "class": "h-4 w-auto",
    alt: ""
  }, null, 8
  /* PROPS */
  , _hoisted_11)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/instagram.svg',
    "class": "h-4 w-auto",
    alt: ""
  }, null, 8
  /* PROPS */
  , _hoisted_13)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/linkedin.svg',
    "class": "h-4 w-auto",
    alt: ""
  }, null, 8
  /* PROPS */
  , _hoisted_15)])])])]), _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.toggleShowFeatures && $options.toggleShowFeatures.apply($options, arguments);
    }),
    "class": "flex justify-between py-3"
  }, [_hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
      'rotate-180': $data.showFeatures
    }, "h-6 w-6 text-gray-100"]),
    fill: "none",
    viewBox: "0 0 24 24",
    stroke: "currentColor",
    "stroke-width": "2"
  }, _hoisted_23, 2
  /* CLASS */
  ))])]), $data.showFeatures ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_24, _hoisted_26)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    onClick: _cache[1] || (_cache[1] = function () {
      return $options.toggleShowLegal && $options.toggleShowLegal.apply($options, arguments);
    }),
    "class": "flex justify-between py-3"
  }, [_hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_28, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
      'rotate-180': $data.showLegal
    }, "h-6 w-6 text-gray-100"]),
    fill: "none",
    viewBox: "0 0 24 24",
    stroke: "currentColor",
    "stroke-width": "2"
  }, _hoisted_30, 2
  /* CLASS */
  ))])]), $data.showLegal ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_31, _hoisted_33)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    onClick: _cache[2] || (_cache[2] = function () {
      return $options.toggleshowResource && $options.toggleshowResource.apply($options, arguments);
    }),
    "class": "flex justify-between py-3"
  }, [_hoisted_34, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
      'rotate-180': $data.showResource
    }, "h-6 w-6 text-gray-100"]),
    fill: "none",
    viewBox: "0 0 24 24",
    stroke: "currentColor",
    "stroke-width": "2"
  }, _hoisted_37, 2
  /* CLASS */
  ))])]), $data.showResource ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_38, _hoisted_40)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    onClick: _cache[3] || (_cache[3] = function () {
      return $options.toggleshowIntegration && $options.toggleshowIntegration.apply($options, arguments);
    }),
    "class": "flex justify-between py-3"
  }, [_hoisted_41, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_42, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("svg", {
    xmlns: "http://www.w3.org/2000/svg",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
      'rotate-180': $data.showIntegration
    }, "h-6 w-6 text-gray-100"]),
    fill: "none",
    viewBox: "0 0 24 24",
    stroke: "currentColor",
    "stroke-width": "2"
  }, _hoisted_44, 2
  /* CLASS */
  ))])]), $data.showIntegration ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_45, _hoisted_47)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]), _hoisted_48])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/HeaderOne.vue?vue&type=template&id=6dbc3b84":
/*!*******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/HeaderOne.vue?vue&type=template&id=6dbc3b84 ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  id: "header",
  "class": "z-50 text-sm sticky"
};
var _hoisted_2 = {
  "class": "container mx-auto py-4 lg:py-6 lg:px-14 px-3"
};
var _hoisted_3 = {
  "class": "flex justify-between items-center"
};
var _hoisted_4 = {
  "class": ""
};
var _hoisted_5 = {
  href: "/"
};
var _hoisted_6 = ["src"];
var _hoisted_7 = {
  "class": "hidden lg:block"
};
var _hoisted_8 = {
  "class": "flex space-x-16 text-sm font-medium"
};
var _hoisted_9 = {
  key: 0,
  "class": "relative"
};
var _hoisted_10 = {
  href: "/",
  "class": "flex space-x-2 items-center"
};
var _hoisted_11 = {
  "class": "relative"
};
var _hoisted_12 = {
  href: "features",
  "class": "flex space-x-2 items-center"
};
var _hoisted_13 = {
  href: "pricing",
  "class": "flex space-x-2 items-center"
};
var _hoisted_14 = {
  "class": "relative"
};
var _hoisted_15 = {
  href: "https://helpdesk.tryba.io",
  "class": "flex space-x-2 items-center"
};
var _hoisted_16 = {
  id: "mobileNavIcon",
  "class": "lg:hidden top-2 right-2"
};

var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  "class": "h-6 w-6 text-white",
  fill: "none",
  viewBox: "0 0 24 24",
  stroke: "currentColor"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "stroke-linecap": "round",
  "stroke-linejoin": "round",
  "stroke-width": "2",
  d: "M4 6h16M4 12h16M4 18h16"
})], -1
/* HOISTED */
);

var _hoisted_18 = [_hoisted_17];
var _hoisted_19 = {
  "class": "hidden lg:flex space-x-4"
};
var _hoisted_20 = {
  key: 1,
  href: "login",
  "class": "border-brand border py-3 font-medium lg:px-6 px-4 text-sm lg:text-base rounded-md lg:rounded-lg text-brand transition duration-300 hover:opacity-70"
};
var _hoisted_21 = {
  key: 1,
  href: "login",
  "class": "bg-brand py-3 font-medium lg:px-6 px-4 text-sm lg:text-base rounded-md lg:rounded-lg text-gray-100 transition duration-300 hover:opacity-70"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_MobileNav = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("MobileNav");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/logo.svg',
    "class": "w-auto h-8",
    alt: "tryba"
  }, null, 8
  /* PROPS */
  , _hoisted_6)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_8, [this.$route.name != 'Home' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("li", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
      'border-b-2 pb-1 border-brand': this.$route.name == 'Home'
    })
  }, "Home", 2
  /* CLASS */
  )])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
      'border-b-2 pb-1 border-brand': this.$route.name == 'Features'
    })
  }, "Features", 2
  /* CLASS */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
      'border-b-2 pb-1 border-brand': this.$route.name == 'Pricing'
    })
  }, "Pricing", 2
  /* CLASS */
  )])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li class=\"relative\">\r\n                    <a href=\"https://tryba.io/blog\" class=\"flex space-x-3 items-center\" >\r\n                      <p class=\"\">Resources</p> \r\n                    </a>\r\n                  </li> "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
      'border-b-2 pb-1 border-brand': this.$route.name == 'Support'
    })
  }, "Support", 2
  /* CLASS */
  )])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.toogleNav && $options.toogleNav.apply($options, arguments);
    }),
    "class": "bg-brand rounded-full p-3"
  }, _hoisted_18)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [!$data.loggedIn ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", {
    key: 0,
    href: "javascript:void(0)",
    onClick: _cache[1] || (_cache[1] = function () {
      return $options.openLoginModal && $options.openLoginModal.apply($options, arguments);
    }),
    "class": "border-brand border py-3 font-medium lg:px-6 px-4 text-sm lg:text-base rounded-md lg:rounded-lg text-brand transition duration-300 hover:opacity-70"
  }, "Sign up")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", _hoisted_20, "Sign up"))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [!$data.loggedIn ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", {
    key: 0,
    href: "javascript:void(0)",
    onClick: _cache[2] || (_cache[2] = function () {
      return $options.openLoginModal && $options.openLoginModal.apply($options, arguments);
    }),
    "class": "bg-brand py-3 font-medium lg:px-6 px-4 text-sm lg:text-base rounded-md lg:rounded-lg text-gray-100 transition duration-300 hover:opacity-70"
  }, "Sign in")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", _hoisted_21, "Sign in"))])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_MobileNav, {
    onRegisterModal: $options.openRegisterModal,
    onLoginModal: $options.openLoginModal,
    showNav: $data.showNav,
    asset: $props.asset,
    onScrollToFeatures: $options.startScrolling,
    onCloseNav: $options.toogleNav
  }, null, 8
  /* PROPS */
  , ["onRegisterModal", "onLoginModal", "showNav", "asset", "onScrollToFeatures", "onCloseNav"]), [[vue__WEBPACK_IMPORTED_MODULE_0__.vShow, $data.showNav]])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=template&id=d3811274":
/*!*******************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=template&id=d3811274 ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "flex justify-end"
};
var _hoisted_2 = {
  ref: "menu",
  "class": "bg-white h-screen w-264 px-3 transition-transform duration-300 translate-x-full"
};
var _hoisted_3 = {
  "class": "py-5 px-3 flex justify-between flex-grow"
};
var _hoisted_4 = {
  "class": ""
};
var _hoisted_5 = {
  href: "/"
};
var _hoisted_6 = ["src"];

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  "class": "h-6 w-6 text-brand",
  fill: "none",
  viewBox: "0 0 24 24",
  stroke: "currentColor"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  "stroke-linecap": "round",
  "stroke-linejoin": "round",
  "stroke-width": "2",
  d: "M6 18L18 6M6 6l12 12"
})], -1
/* HOISTED */
);

var _hoisted_8 = [_hoisted_7];
var _hoisted_9 = {
  "class": "font-inter my-4 grid grid-rows-2 gap-4"
};
var _hoisted_10 = {
  key: 1,
  href: "register",
  "class": "bg-brand py-3 text-center w-full text-white rounded-lg"
};
var _hoisted_11 = {
  key: 3,
  href: "login",
  "class": "text-brand text-center border-brand border py-3 w-full rounded-lg"
};
var _hoisted_12 = {
  "class": "grid grid-rows-1 gap-8 pt-4 mt-4 font-inter px-3 font-semibold"
};

var _hoisted_13 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
  href: "https://helpdesk.tryba.io/en/",
  "class": "font-semibold flex space-x-3"
}, " Support ")], -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
    onClick: _cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {
      return $options.closeNav && $options.closeNav.apply($options, arguments);
    }, ["self"])),
    "class": "fixed lg:relative lg:hidden top-0 left-0 h-full w-full bg-overlay z-50"
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/logo.svg',
    "class": "lg:h-8 w-auto h-6",
    alt: "tryba"
  }, null, 8
  /* PROPS */
  , _hoisted_6)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.closeNav && $options.closeNav.apply($options, arguments);
    })
  }, _hoisted_8)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [!$data.loggedIn ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", {
    key: 0,
    href: "javascript:void(0)",
    onClick: _cache[1] || (_cache[1] = function () {
      return $options.openRegisterModal && $options.openRegisterModal.apply($options, arguments);
    }),
    "class": "bg-brand py-3 text-center w-full text-white rounded-lg"
  }, "Open an account")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", _hoisted_10, "Open an account")), !$data.loggedIn ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", {
    key: 2,
    href: "javascript:void(0)",
    onClick: _cache[2] || (_cache[2] = function () {
      return $options.openLoginModal && $options.openLoginModal.apply($options, arguments);
    }),
    "class": "text-brand text-center border-brand border py-3 w-full rounded-lg"
  }, "Log in")) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("a", _hoisted_11, "Log in"))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    href: "/",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
      'text-brand': this.$route.name == 'Home'
    }, "font-semibold flex space-x-3"])
  }, " Home ", 2
  /* CLASS */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    href: "features",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
      'text-brand': this.$route.name == 'Features'
    }, "font-semibold flex space-x-3"])
  }, " Features ", 2
  /* CLASS */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
    href: "/pricing",
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([{
      'text-brand': this.$route.name == 'Pricing'
    }, "font-semibold flex space-x-3"])
  }, " Pricing ", 2
  /* CLASS */
  )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <li>\r\n                    <a href=\"https://tryba.io/blog\" class=\"font-semibold flex space-x-3\">\r\n                       Resources\r\n                    </a> \r\n                </li> "), _hoisted_13])], 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vShow, $options.show]])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/support/SectionOne.vue?vue&type=template&id=933dc6a8":
/*!****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/support/SectionOne.vue?vue&type=template&id=933dc6a8 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "container overflow-hidden mx-auto py-8 px-8 lg:px-14"
};
var _hoisted_2 = {
  "class": "grid grid-rows-1 lg:grid-cols-2"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex item-center py-3 lg:py-24"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-semibold text-center lg:text-left text-4xl lg:text-5xl"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" We are always here to support you "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-brand"
}, "Ask Us Anything")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter hidden lg:block lg:my-4 my-2"
}, "Contact us on any challenge you are facing as touching our product and services, we will always provide support")])], -1
/* HOISTED */
);

var _hoisted_4 = {
  "class": "flex justify-end"
};
var _hoisted_5 = ["src"];

var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter text-sm lg:hidden block my-6"
}, "Contact us on any challenge you are facing as touching our product and services, we will always provide support", -1
/* HOISTED */
);

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<section class=\"container overflow-hidden mx-auto py-8 px-8 lg:px-14\"><div class=\"grid lg:grid-cols-2 gap-3 mb-4\"><div><input type=\"text\" placeholder=\"Enter your email address\" class=\"p-4 font-inter text-sm w-full bg-gray-200 rounded\"></div></div><div class=\"mb-4\"><textarea name=\"\" class=\"p-4 font-inter text-sm w-full bg-gray-200 rounded\" placeholder=\"Enter your query here\" id=\"\" cols=\"30\" rows=\"10\"></textarea></div><div class=\"text-right\"><button type=\"submit\" class=\"px-8 text-sm font-inter py-3 bg-brand rounded-md text-white\">Submit</button></div></section>", 1);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/undraw_active_support_re_b7sj 1.svg',
    "class": "h-[500] w-auto",
    alt: "subscription"
  }, null, 8
  /* PROPS */
  , _hoisted_5)])]), _hoisted_6]), _hoisted_7], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Support.vue?vue&type=template&id=a66cd700":
/*!************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Support.vue?vue&type=template&id=a66cd700 ***!
  \************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Header = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Header");

  var _component_SectionOne = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SectionOne");

  var _component_Footer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Footer");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Header, {
    asset: $data.assetUrl
  }, null, 8
  /* PROPS */
  , ["asset"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_SectionOne, {
    asset: $data.assetUrl
  }, null, 8
  /* PROPS */
  , ["asset"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Footer, {
    asset: $data.assetUrl
  }, null, 8
  /* PROPS */
  , ["asset"])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.bg-overlay{\r\n    background: rgba(0, 0, 0, 0.8);\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/scroll-js/dist/scroll.js":
/*!***********************************************!*\
  !*** ./node_modules/scroll-js/dist/scroll.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "DEFAULT_DURATION": () => (/* binding */ DEFAULT_DURATION),
/* harmony export */   "easingMap": () => (/* binding */ easingMap),
/* harmony export */   "scrollIntoView": () => (/* binding */ scrollIntoView),
/* harmony export */   "scrollTo": () => (/* binding */ scrollTo),
/* harmony export */   "utils": () => (/* binding */ utils)
/* harmony export */ });
/*! *****************************************************************************
Copyright (c) Microsoft Corporation.

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
***************************************************************************** */

function __awaiter(thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
}

const DEFAULT_DURATION = 300;
function scrollTo(el, options = {}) {
    return __awaiter(this, void 0, void 0, function* () {
        if (!(el instanceof Element) && !(el instanceof Window)) {
            throw new Error(`element passed to scrollTo() must be either the window or a DOM element, you passed ${el}!`);
        }
        options = sanitizeScrollOptions(options);
        const scroll = (from, to, prop, startTime, duration = DEFAULT_DURATION, easeFunc, callback) => {
            window.requestAnimationFrame(() => {
                const currentTime = Date.now();
                const time = Math.min(1, (currentTime - startTime) / duration);
                if (from === to) {
                    return callback ? callback() : null;
                }
                setScrollPosition(el, easeFunc(time) * (to - from) + from);
                /* prevent scrolling, if already there, or at end */
                if (time < 1) {
                    scroll(from, to, prop, startTime, duration, easeFunc, callback);
                }
                else if (callback) {
                    callback();
                }
            });
        };
        const currentScrollPosition = getScrollPosition(el);
        const scrollProperty = getScrollPropertyByElement(el);
        return new Promise((resolve) => {
            scroll(currentScrollPosition, typeof options.top === 'number'
                ? options.top
                : currentScrollPosition, scrollProperty, Date.now(), options.duration, getEasing(options.easing), resolve);
        });
    });
}
function scrollIntoView(element, scroller, options) {
    validateElement(element);
    if (scroller && !(scroller instanceof Element)) {
        options = scroller;
        scroller = undefined;
    }
    const { duration, easing } = sanitizeScrollOptions(options);
    scroller = scroller || utils.getDocument().body;
    let currentContainerScrollYPos = 0;
    let elementScrollYPos = element ? element.offsetTop : 0;
    const document = utils.getDocument();
    // if the container is the document body or document itself, we'll
    // need a different set of coordinates for accuracy
    if (scroller === document.body || scroller === document.documentElement) {
        // using pageYOffset for cross-browser compatibility
        currentContainerScrollYPos = window.pageYOffset;
        // must add containers scroll y position to ensure an absolute value that does not change
        elementScrollYPos =
            element.getBoundingClientRect().top + currentContainerScrollYPos;
    }
    return scrollTo(scroller, {
        top: elementScrollYPos,
        left: 0,
        duration,
        easing,
    });
}
function validateElement(element) {
    if (element === undefined) {
        const errorMsg = 'The element passed to scrollIntoView() was undefined.';
        throw new Error(errorMsg);
    }
    if (!(element instanceof HTMLElement)) {
        throw new Error(`The element passed to scrollIntoView() must be a valid element. You passed ${element}.`);
    }
}
function getScrollPropertyByElement(el) {
    const props = {
        window: {
            y: 'scrollY',
            x: 'scrollX',
        },
        element: {
            y: 'scrollTop',
            x: 'scrollLeft',
        },
    };
    const axis = 'y';
    if (el instanceof Window) {
        return props.window[axis];
    }
    else {
        return props.element[axis];
    }
}
function sanitizeScrollOptions(options = {}) {
    if (options.behavior === 'smooth') {
        options.easing = 'ease-in-out';
        options.duration = DEFAULT_DURATION;
    }
    if (options.behavior === 'auto') {
        options.duration = 0;
        options.easing = 'linear';
    }
    return options;
}
function getScrollPosition(el) {
    const document = utils.getDocument();
    if (el === document.body ||
        el === document.documentElement ||
        el instanceof Window) {
        return document.body.scrollTop || document.documentElement.scrollTop;
    }
    else {
        return el.scrollTop;
    }
}
function setScrollPosition(el, value) {
    const document = utils.getDocument();
    if (el === document.body ||
        el === document.documentElement ||
        el instanceof Window) {
        document.body.scrollTop = value;
        document.documentElement.scrollTop = value;
    }
    else {
        el.scrollTop = value;
    }
}
const utils = {
    // we're really just exporting this so that tests can mock the document.documentElement
    getDocument() {
        return document;
    },
};
const easingMap = {
    linear(t) {
        return t;
    },
    'ease-in'(t) {
        return t * t;
    },
    'ease-out'(t) {
        return t * (2 - t);
    },
    'ease-in-out'(t) {
        return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
    },
};
const getEasing = (easing) => {
    const defaultEasing = 'linear';
    const easeFunc = easingMap[easing || defaultEasing];
    if (!easeFunc) {
        const options = Object.keys(easingMap).join(',');
        throw new Error(`Scroll error: scroller does not support an easing option of "${easing}". Supported options are ${options}`);
    }
    return easeFunc;
};




/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_style_index_0_id_d3811274_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_style_index_0_id_d3811274_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_style_index_0_id_d3811274_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/Footer.vue":
/*!********************************************!*\
  !*** ./resources/js/components/Footer.vue ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Footer_vue_vue_type_template_id_61a7c374__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Footer.vue?vue&type=template&id=61a7c374 */ "./resources/js/components/Footer.vue?vue&type=template&id=61a7c374");
/* harmony import */ var _Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Footer.vue?vue&type=script&lang=js */ "./resources/js/components/Footer.vue?vue&type=script&lang=js");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Footer_vue_vue_type_template_id_61a7c374__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/Footer.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/HeaderOne.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/HeaderOne.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _HeaderOne_vue_vue_type_template_id_6dbc3b84__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HeaderOne.vue?vue&type=template&id=6dbc3b84 */ "./resources/js/components/HeaderOne.vue?vue&type=template&id=6dbc3b84");
/* harmony import */ var _HeaderOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HeaderOne.vue?vue&type=script&lang=js */ "./resources/js/components/HeaderOne.vue?vue&type=script&lang=js");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_HeaderOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_HeaderOne_vue_vue_type_template_id_6dbc3b84__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/HeaderOne.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/MobileNav.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/MobileNav.vue ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _MobileNav_vue_vue_type_template_id_d3811274__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MobileNav.vue?vue&type=template&id=d3811274 */ "./resources/js/components/MobileNav.vue?vue&type=template&id=d3811274");
/* harmony import */ var _MobileNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MobileNav.vue?vue&type=script&lang=js */ "./resources/js/components/MobileNav.vue?vue&type=script&lang=js");
/* harmony import */ var _MobileNav_vue_vue_type_style_index_0_id_d3811274_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css */ "./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_MobileNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_MobileNav_vue_vue_type_template_id_d3811274__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/MobileNav.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/support/SectionOne.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/support/SectionOne.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SectionOne_vue_vue_type_template_id_933dc6a8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SectionOne.vue?vue&type=template&id=933dc6a8 */ "./resources/js/components/support/SectionOne.vue?vue&type=template&id=933dc6a8");
/* harmony import */ var _SectionOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SectionOne.vue?vue&type=script&lang=js */ "./resources/js/components/support/SectionOne.vue?vue&type=script&lang=js");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_SectionOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_SectionOne_vue_vue_type_template_id_933dc6a8__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/support/SectionOne.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/Support.vue":
/*!****************************************!*\
  !*** ./resources/js/views/Support.vue ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Support_vue_vue_type_template_id_a66cd700__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Support.vue?vue&type=template&id=a66cd700 */ "./resources/js/views/Support.vue?vue&type=template&id=a66cd700");
/* harmony import */ var _Support_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Support.vue?vue&type=script&lang=js */ "./resources/js/views/Support.vue?vue&type=script&lang=js");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Support_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Support_vue_vue_type_template_id_a66cd700__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/Support.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Footer.vue?vue&type=script&lang=js":
/*!********************************************************************!*\
  !*** ./resources/js/components/Footer.vue?vue&type=script&lang=js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Footer.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/HeaderOne.vue?vue&type=script&lang=js":
/*!***********************************************************************!*\
  !*** ./resources/js/components/HeaderOne.vue?vue&type=script&lang=js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_HeaderOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_HeaderOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./HeaderOne.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/HeaderOne.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/MobileNav.vue?vue&type=script&lang=js":
/*!***********************************************************************!*\
  !*** ./resources/js/components/MobileNav.vue?vue&type=script&lang=js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MobileNav.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/support/SectionOne.vue?vue&type=script&lang=js":
/*!********************************************************************************!*\
  !*** ./resources/js/components/support/SectionOne.vue?vue&type=script&lang=js ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionOne.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/support/SectionOne.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/Support.vue?vue&type=script&lang=js":
/*!****************************************************************!*\
  !*** ./resources/js/views/Support.vue?vue&type=script&lang=js ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Support_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Support_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Support.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Support.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Footer.vue?vue&type=template&id=61a7c374":
/*!**************************************************************************!*\
  !*** ./resources/js/components/Footer.vue?vue&type=template&id=61a7c374 ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_template_id_61a7c374__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Footer_vue_vue_type_template_id_61a7c374__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Footer.vue?vue&type=template&id=61a7c374 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=template&id=61a7c374");


/***/ }),

/***/ "./resources/js/components/HeaderOne.vue?vue&type=template&id=6dbc3b84":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/HeaderOne.vue?vue&type=template&id=6dbc3b84 ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_HeaderOne_vue_vue_type_template_id_6dbc3b84__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_HeaderOne_vue_vue_type_template_id_6dbc3b84__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./HeaderOne.vue?vue&type=template&id=6dbc3b84 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/HeaderOne.vue?vue&type=template&id=6dbc3b84");


/***/ }),

/***/ "./resources/js/components/MobileNav.vue?vue&type=template&id=d3811274":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/MobileNav.vue?vue&type=template&id=d3811274 ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_template_id_d3811274__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_template_id_d3811274__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MobileNav.vue?vue&type=template&id=d3811274 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=template&id=d3811274");


/***/ }),

/***/ "./resources/js/components/support/SectionOne.vue?vue&type=template&id=933dc6a8":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/support/SectionOne.vue?vue&type=template&id=933dc6a8 ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionOne_vue_vue_type_template_id_933dc6a8__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionOne_vue_vue_type_template_id_933dc6a8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionOne.vue?vue&type=template&id=933dc6a8 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/support/SectionOne.vue?vue&type=template&id=933dc6a8");


/***/ }),

/***/ "./resources/js/views/Support.vue?vue&type=template&id=a66cd700":
/*!**********************************************************************!*\
  !*** ./resources/js/views/Support.vue?vue&type=template&id=a66cd700 ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Support_vue_vue_type_template_id_a66cd700__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Support_vue_vue_type_template_id_a66cd700__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Support.vue?vue&type=template&id=a66cd700 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Support.vue?vue&type=template&id=a66cd700");


/***/ }),

/***/ "./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_style_index_0_id_d3811274_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css");


/***/ })

}]);