(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_Features_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
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

"use strict";
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionOne.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionOne.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue3_youtube__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue3-youtube */ "./node_modules/vue3-youtube/dist/vue3-youtube.umd.min.js");
/* harmony import */ var vue3_youtube__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue3_youtube__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Section",
  props: ['asset'],
  components: {
    YouTube: (vue3_youtube__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      showVideo: false
    };
  },
  methods: {
    onReady: function onReady() {// this.$refs.youtube.playVideo()
    },
    toogleVideo: function toogleVideo() {
      this.showVideo = !this.showVideo;

      if (this.showVideo) {
        this.$refs.youtube.playVideo();
      }
    }
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionTwo.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionTwo.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Features.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Features.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_HeaderOne_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/HeaderOne.vue */ "./resources/js/components/HeaderOne.vue");
/* harmony import */ var _components_Footer_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/Footer.vue */ "./resources/js/components/Footer.vue");
/* harmony import */ var _components_features_SectionOne_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/features/SectionOne.vue */ "./resources/js/components/features/SectionOne.vue");
/* harmony import */ var _components_features_SectionTwo_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/features/SectionTwo.vue */ "./resources/js/components/features/SectionTwo.vue");
/* harmony import */ var _components_features_SectionThree_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/features/SectionThree.vue */ "./resources/js/components/features/SectionThree.vue");





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Header: _components_HeaderOne_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    Footer: _components_Footer_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
    SectionOne: _components_features_SectionOne_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    SectionTwo: _components_features_SectionTwo_vue__WEBPACK_IMPORTED_MODULE_3__["default"],
    SectionThree: _components_features_SectionThree_vue__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  data: function data() {
    return {
      assetUrl: window.assetUrl.url
    };
  },
  methods: {
    toggleLogin: function toggleLogin() {
      this.$emit("openLoginModal");
    },
    toggleRegister: function toggleRegister() {
      this.$emit("openRegisterModal");
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=template&id=61a7c374":
/*!****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/Footer.vue?vue&type=template&id=61a7c374 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
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

"use strict";
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionOne.vue?vue&type=template&id=2207d6f8":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionOne.vue?vue&type=template&id=2207d6f8 ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "container overflow-hidden mx-auto py-8 px-3 lg:px-14"
};
var _hoisted_2 = {
  "class": "lg:grid lg:grid-cols-3"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex item-center py-3 lg:py-24 lg:col-span-2"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-bold text-center lg:text-left lg:leading-[70px] text-3xl lg:text-6xl"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "text-brand"
}, "Amazing features "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" that makes banking and Business easy for You ")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter hidden font-semibold text-xl lg:block lg:my-4 my-2"
}, "Built for freelancers, contractors and limited companies ")])], -1
/* HOISTED */
);

var _hoisted_4 = {
  "class": "flex justify-center lg:justify-end"
};
var _hoisted_5 = ["src"];

var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter text-base text-center font-medium lg:hidden block my-6"
}, "Built for freelancers, contractors and limited companies", -1
/* HOISTED */
);

var _hoisted_7 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h1", {
  "class": "text-3xl font-semibold text-center mb-6"
}, "Features", -1
/* HOISTED */
);

var _hoisted_8 = {
  "class": "bg-gray-100"
};
var _hoisted_9 = {
  "class": "container overflow-hidden mx-auto py-8 px-6 lg:px-14"
};
var _hoisted_10 = {
  "class": "flex flex-col-reverse lg:grid lg:grid-cols-2"
};

var _hoisted_11 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex item-center py-3 lg:py-24"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-bold text-center lg:text-left text-2xl lg:text-5xl"
}, " Web and Store builder with Custom domain "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter text-center lg:text-left font-medium lg:block lg:my-4 my-2"
}, " Create a business website that allows your customers to know more about your product and services ")])], -1
/* HOISTED */
);

var _hoisted_12 = {
  "class": "flex justify-center lg:justify-end"
};
var _hoisted_13 = {
  "class": "p-4"
};
var _hoisted_14 = ["src"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/undraw_features_overview_re_2w78 1.svg',
    "class": "lg:h-[500] w-auto",
    alt: "subscription"
  }, null, 8
  /* PROPS */
  , _hoisted_5)])])]), _hoisted_6]), _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [_hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/image480.png',
    "class": "h-[229px] lg:h-[360px]",
    alt: "subscription"
  }, null, 8
  /* PROPS */
  , _hoisted_14)])])])])])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=template&id=41f91bb0":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=template&id=41f91bb0 ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "container overflow-hidden mx-auto py-8 px-6 lg:px-14"
};
var _hoisted_2 = {
  "class": "lg:grid lg:grid-cols-7"
};
var _hoisted_3 = {
  "class": "flex justify-center lg:justify-start lg:col-span-3"
};
var _hoisted_4 = ["src"];

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex item-center py-3 lg:py-24 col-span-4"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-bold text-center lg:text-left text-2xl lg:text-5xl"
}, " Invoicing and payment Links "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter text-center lg:text-left font-medium lg:my-4 my-2"
}, " Create and manage invoice sent to your cutomers saved email addresses which is one of the most reliable way to get paid quickly. ")])], -1
/* HOISTED */
);

var _hoisted_6 = {
  "class": "bg-gray-100"
};
var _hoisted_7 = {
  "class": "container overflow-hidden mx-auto py-8 px-6 lg:px-14"
};
var _hoisted_8 = {
  "class": "flex flex-col-reverse lg:grid gap-14 lg:grid-cols-7"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex justify-center item-center py-2 lg:py-24 col-span-4"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-bold text-center lg:text-left text-2xl lg:text-5xl"
}, " Business bank accounts and cards "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter hidden font-medium lg:block lg:my-4 my-2"
}, " Download the Tryba app to apply for your business account creation, most commonly within 3-4 minutes, then receive your contactless Visacard. All you'll need is proof of ID and a selfie. ")])], -1
/* HOISTED */
);

var _hoisted_10 = {
  "class": "flex justify-center lg:justify-end col-span-3"
};
var _hoisted_11 = ["src"];

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter text-center lg:text-left text-sm lg:hidden block"
}, " Download the Tryba app to apply for your business account creation, most commonly within 3-4 minutes, then receive your contactless Visacard. All you'll need is proof of ID and a selfie. ", -1
/* HOISTED */
);

var _hoisted_13 = {
  "class": "container overflow-hidden mx-auto py-14 px-6 lg:px-14"
};
var _hoisted_14 = {
  "class": "lg:grid lg:grid-cols-2"
};
var _hoisted_15 = {
  "class": "flex justify-center lg:justify-start items-center"
};
var _hoisted_16 = ["src"];

var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex item-center py-3 lg:py-24"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-bold text-center lg:text-left text-2xl lg:text-5xl"
}, " Developers "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter text-center lg:text-left font-medium lg:my-4 my-2"
}, " Create and manage invoice sent to your cutomers saved email addresseswhich is one of the most reliable way to get paid quickly. ")])], -1
/* HOISTED */
);

var _hoisted_18 = {
  "class": "container overflow-hidden mx-auto mb-14 py-8 px-6 lg:px-14"
};

var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h1", {
  "class": "lg:text-5xl text-2xl font-semibold text-center mb-6"
}, "Why Tryba? (in 1:34 mins)", -1
/* HOISTED */
);

var _hoisted_20 = {
  "class": "flex justify-center"
};
var _hoisted_21 = ["src"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_YouTube = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("YouTube");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/image478.png',
    "class": "h-[233px] lg:h-[363px] w-auto",
    alt: "invoicing"
  }, null, 8
  /* PROPS */
  , _hoisted_4)])]), _hoisted_5])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/card-iphone.png',
    "class": "h[336px] w-auto",
    alt: "bank accounts"
  }, null, 8
  /* PROPS */
  , _hoisted_11)])])]), _hoisted_12])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_13, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/undraw_developer_activity_re_39tg 1.svg',
    "class": "h-[269px] w-auto",
    alt: "invoicing"
  }, null, 8
  /* PROPS */
  , _hoisted_16)])]), _hoisted_17])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_18, [_hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_YouTube, {
    src: "https://www.youtube.com/watch?v=KPF8wiAW8Q4",
    onReady: $options.onReady,
    width: "640",
    height: "360",
    ref: "youtube"
  }, null, 8
  /* PROPS */
  , ["onReady"])], 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vShow, $data.showVideo]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.toogleVideo && $options.toogleVideo.apply($options, arguments);
    })
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/TV.svg',
    "class": "w-auto",
    alt: "youtube"
  }, null, 8
  /* PROPS */
  , _hoisted_21)])], 512
  /* NEED_PATCH */
  ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vShow, $data.showVideo == false]])])])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionTwo.vue?vue&type=template&id=3a6f87de":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionTwo.vue?vue&type=template&id=3a6f87de ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "container overflow-hidden mx-auto py-8 px-6 lg:px-14"
};
var _hoisted_2 = {
  "class": "lg:grid lg:grid-cols-7"
};
var _hoisted_3 = {
  "class": "flex justify-center lg:justify-start lg:col-span-3"
};
var _hoisted_4 = ["src"];

var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex item-center pt-3 lg:py-24 lg:col-span-4"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-bold text-center lg:text-left text-2xl lg:text-5xl"
}, " Booking and appointment "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter text-center lg:text-left font-medium lg:block lg:my-4 my-2"
}, " Download the Tryba app to create custom made booking and appointment tailored to your style of business ")])], -1
/* HOISTED */
);

var _hoisted_6 = {
  "class": "bg-gray-100"
};
var _hoisted_7 = {
  "class": "container overflow-hidden mx-auto py-8 px-6 lg:px-14"
};
var _hoisted_8 = {
  "class": "flex flex-col-reverse lg:grid lg:grid-cols-2"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex justify-center lg:justify-start item-center py-2 lg:py-24"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-bold text-center lg:text-left text-2xl lg:text-5xl"
}, " Expense and Budgeting "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter hidden font-medium lg:block lg:my-4 my-2"
}, " Download the Tryba app to be in charge on how ans where you money goes but creating your personal expense and budgeting scheduls all by yourself ")])], -1
/* HOISTED */
);

var _hoisted_10 = {
  "class": "flex justify-center lg:justify-end"
};
var _hoisted_11 = ["src"];

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "font-inter text-center lg:text-lefta text-sm lg:hidden block"
}, " Download the Tryba app to be in charge on how ans where you money goes but creating your personal expense and budgeting scheduls all by yourself ", -1
/* HOISTED */
);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/image482.png',
    "class": "h-[232px] lg:h-[360px] w-auto",
    alt: "booking"
  }, null, 8
  /* PROPS */
  , _hoisted_4)])]), _hoisted_5])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
    src: $props.asset + 'asset/new_homepage/icons/image482.png',
    "class": "h-[232px] lg:h-[360px] w-auto",
    alt: "subscription"
  }, null, 8
  /* PROPS */
  , _hoisted_11)])])]), _hoisted_12])])], 64
  /* STABLE_FRAGMENT */
  );
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Features.vue?vue&type=template&id=d792fc48":
/*!*************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Features.vue?vue&type=template&id=d792fc48 ***!
  \*************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Header = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Header");

  var _component_SectionOne = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SectionOne");

  var _component_SectionTwo = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SectionTwo");

  var _component_SectionThree = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SectionThree");

  var _component_Footer = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Footer");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Header, {
    onOpenLoginModal: $options.toggleLogin,
    onOpenRegisterModal: $options.toggleRegister,
    asset: $data.assetUrl
  }, null, 8
  /* PROPS */
  , ["onOpenLoginModal", "onOpenRegisterModal", "asset"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_SectionOne, {
    asset: $data.assetUrl
  }, null, 8
  /* PROPS */
  , ["asset"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_SectionTwo, {
    asset: $data.assetUrl
  }, null, 8
  /* PROPS */
  , ["asset"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_SectionThree, {
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

"use strict";
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n@media (max-width: 789px) {\niframe{\r\n        width:340px !important;\r\n        height: 350px  !important;\r\n        margin:auto;\n}\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/scroll-js/dist/scroll.js":
/*!***********************************************!*\
  !*** ./node_modules/scroll-js/dist/scroll.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
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

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionThree_vue_vue_type_style_index_0_id_41f91bb0_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionThree_vue_vue_type_style_index_0_id_41f91bb0_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionThree_vue_vue_type_style_index_0_id_41f91bb0_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/Footer.vue":
/*!********************************************!*\
  !*** ./resources/js/components/Footer.vue ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
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

"use strict";
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

/***/ "./resources/js/components/features/SectionOne.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/features/SectionOne.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SectionOne_vue_vue_type_template_id_2207d6f8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SectionOne.vue?vue&type=template&id=2207d6f8 */ "./resources/js/components/features/SectionOne.vue?vue&type=template&id=2207d6f8");
/* harmony import */ var _SectionOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SectionOne.vue?vue&type=script&lang=js */ "./resources/js/components/features/SectionOne.vue?vue&type=script&lang=js");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_SectionOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_SectionOne_vue_vue_type_template_id_2207d6f8__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/features/SectionOne.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/features/SectionThree.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/features/SectionThree.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SectionThree_vue_vue_type_template_id_41f91bb0__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SectionThree.vue?vue&type=template&id=41f91bb0 */ "./resources/js/components/features/SectionThree.vue?vue&type=template&id=41f91bb0");
/* harmony import */ var _SectionThree_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SectionThree.vue?vue&type=script&lang=js */ "./resources/js/components/features/SectionThree.vue?vue&type=script&lang=js");
/* harmony import */ var _SectionThree_vue_vue_type_style_index_0_id_41f91bb0_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css */ "./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_SectionThree_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_SectionThree_vue_vue_type_template_id_41f91bb0__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/features/SectionThree.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/features/SectionTwo.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/features/SectionTwo.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SectionTwo_vue_vue_type_template_id_3a6f87de__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SectionTwo.vue?vue&type=template&id=3a6f87de */ "./resources/js/components/features/SectionTwo.vue?vue&type=template&id=3a6f87de");
/* harmony import */ var _SectionTwo_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SectionTwo.vue?vue&type=script&lang=js */ "./resources/js/components/features/SectionTwo.vue?vue&type=script&lang=js");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_SectionTwo_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_SectionTwo_vue_vue_type_template_id_3a6f87de__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/components/features/SectionTwo.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/Features.vue":
/*!*****************************************!*\
  !*** ./resources/js/views/Features.vue ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Features_vue_vue_type_template_id_d792fc48__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Features.vue?vue&type=template&id=d792fc48 */ "./resources/js/views/Features.vue?vue&type=template&id=d792fc48");
/* harmony import */ var _Features_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Features.vue?vue&type=script&lang=js */ "./resources/js/views/Features.vue?vue&type=script&lang=js");
/* harmony import */ var C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_Users_HP_Documents_Laravel_tryba_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Features_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Features_vue_vue_type_template_id_d792fc48__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/Features.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/components/Footer.vue?vue&type=script&lang=js":
/*!********************************************************************!*\
  !*** ./resources/js/components/Footer.vue?vue&type=script&lang=js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
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

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MobileNav.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/features/SectionOne.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/features/SectionOne.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionOne_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionOne.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionOne.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/features/SectionThree.vue?vue&type=script&lang=js":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/features/SectionThree.vue?vue&type=script&lang=js ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionThree_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionThree_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionThree.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/features/SectionTwo.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/features/SectionTwo.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionTwo_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionTwo_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionTwo.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionTwo.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/Features.vue?vue&type=script&lang=js":
/*!*****************************************************************!*\
  !*** ./resources/js/views/Features.vue?vue&type=script&lang=js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Features_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Features_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Features.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Features.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/components/Footer.vue?vue&type=template&id=61a7c374":
/*!**************************************************************************!*\
  !*** ./resources/js/components/Footer.vue?vue&type=template&id=61a7c374 ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
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

"use strict";
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

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_template_id_d3811274__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_template_id_d3811274__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MobileNav.vue?vue&type=template&id=d3811274 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=template&id=d3811274");


/***/ }),

/***/ "./resources/js/components/features/SectionOne.vue?vue&type=template&id=2207d6f8":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/features/SectionOne.vue?vue&type=template&id=2207d6f8 ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionOne_vue_vue_type_template_id_2207d6f8__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionOne_vue_vue_type_template_id_2207d6f8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionOne.vue?vue&type=template&id=2207d6f8 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionOne.vue?vue&type=template&id=2207d6f8");


/***/ }),

/***/ "./resources/js/components/features/SectionThree.vue?vue&type=template&id=41f91bb0":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/features/SectionThree.vue?vue&type=template&id=41f91bb0 ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionThree_vue_vue_type_template_id_41f91bb0__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionThree_vue_vue_type_template_id_41f91bb0__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionThree.vue?vue&type=template&id=41f91bb0 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=template&id=41f91bb0");


/***/ }),

/***/ "./resources/js/components/features/SectionTwo.vue?vue&type=template&id=3a6f87de":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/features/SectionTwo.vue?vue&type=template&id=3a6f87de ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionTwo_vue_vue_type_template_id_3a6f87de__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionTwo_vue_vue_type_template_id_3a6f87de__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionTwo.vue?vue&type=template&id=3a6f87de */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionTwo.vue?vue&type=template&id=3a6f87de");


/***/ }),

/***/ "./resources/js/views/Features.vue?vue&type=template&id=d792fc48":
/*!***********************************************************************!*\
  !*** ./resources/js/views/Features.vue?vue&type=template&id=d792fc48 ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Features_vue_vue_type_template_id_d792fc48__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Features_vue_vue_type_template_id_d792fc48__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Features.vue?vue&type=template&id=d792fc48 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/Features.vue?vue&type=template&id=d792fc48");


/***/ }),

/***/ "./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_MobileNav_vue_vue_type_style_index_0_id_d3811274_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/MobileNav.vue?vue&type=style&index=0&id=d3811274&lang=css");


/***/ }),

/***/ "./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_10_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_10_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_SectionThree_vue_vue_type_style_index_0_id_41f91bb0_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!../../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-10.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-10.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/components/features/SectionThree.vue?vue&type=style&index=0&id=41f91bb0&lang=css");


/***/ }),

/***/ "./node_modules/vue3-youtube/dist/vue3-youtube.umd.min.js":
/*!****************************************************************!*\
  !*** ./node_modules/vue3-youtube/dist/vue3-youtube.umd.min.js ***!
  \****************************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

(function(t,e){ true?module.exports=e(__webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js")):0})("undefined"!==typeof self?self:this,(function(t){return function(t){var e={};function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}return n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(r,o,function(e){return t[e]}.bind(null,o));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s="fb15")}({"00ee":function(t,e,n){var r=n("b622"),o=r("toStringTag"),i={};i[o]="z",t.exports="[object z]"===String(i)},"0366":function(t,e,n){var r=n("1c0b");t.exports=function(t,e,n){if(r(t),void 0===e)return t;switch(n){case 0:return function(){return t.call(e)};case 1:return function(n){return t.call(e,n)};case 2:return function(n,r){return t.call(e,n,r)};case 3:return function(n,r,o){return t.call(e,n,r,o)}}return function(){return t.apply(e,arguments)}}},"06cf":function(t,e,n){var r=n("83ab"),o=n("d1e7"),i=n("5c6c"),c=n("fc6a"),u=n("c04e"),a=n("5135"),f=n("0cfb"),s=Object.getOwnPropertyDescriptor;e.f=r?s:function(t,e){if(t=c(t),e=u(e,!0),f)try{return s(t,e)}catch(n){}if(a(t,e))return i(!o.f.call(t,e),t[e])}},"0cfb":function(t,e,n){var r=n("83ab"),o=n("d039"),i=n("cc12");t.exports=!r&&!o((function(){return 7!=Object.defineProperty(i("div"),"a",{get:function(){return 7}}).a}))},"159b":function(t,e,n){var r=n("da84"),o=n("fdbc"),i=n("17c2"),c=n("9112");for(var u in o){var a=r[u],f=a&&a.prototype;if(f&&f.forEach!==i)try{c(f,"forEach",i)}catch(s){f.forEach=i}}},"17c2":function(t,e,n){"use strict";var r=n("b727").forEach,o=n("a640"),i=n("ae40"),c=o("forEach"),u=i("forEach");t.exports=c&&u?[].forEach:function(t){return r(this,t,arguments.length>1?arguments[1]:void 0)}},"19aa":function(t,e){t.exports=function(t,e,n){if(!(t instanceof e))throw TypeError("Incorrect "+(n?n+" ":"")+"invocation");return t}},"1be4":function(t,e,n){var r=n("d066");t.exports=r("document","documentElement")},"1c0b":function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(String(t)+" is not a function");return t}},"1c7e":function(t,e,n){var r=n("b622"),o=r("iterator"),i=!1;try{var c=0,u={next:function(){return{done:!!c++}},return:function(){i=!0}};u[o]=function(){return this},Array.from(u,(function(){throw 2}))}catch(a){}t.exports=function(t,e){if(!e&&!i)return!1;var n=!1;try{var r={};r[o]=function(){return{next:function(){return{done:n=!0}}}},t(r)}catch(a){}return n}},"1cdc":function(t,e,n){var r=n("342f");t.exports=/(iphone|ipod|ipad).*applewebkit/i.test(r)},"1d80":function(t,e){t.exports=function(t){if(void 0==t)throw TypeError("Can't call method on "+t);return t}},2266:function(t,e,n){var r=n("825a"),o=n("e95a"),i=n("50c4"),c=n("0366"),u=n("35a1"),a=n("9bdd"),f=function(t,e){this.stopped=t,this.result=e},s=t.exports=function(t,e,n,s,l){var p,d,v,h,y,b,g,m=c(e,n,s?2:1);if(l)p=t;else{if(d=u(t),"function"!=typeof d)throw TypeError("Target is not iterable");if(o(d)){for(v=0,h=i(t.length);h>v;v++)if(y=s?m(r(g=t[v])[0],g[1]):m(t[v]),y&&y instanceof f)return y;return new f(!1)}p=d.call(t)}b=p.next;while(!(g=b.call(p)).done)if(y=a(p,m,g.value,s),"object"==typeof y&&y&&y instanceof f)return y;return new f(!1)};s.stop=function(t){return new f(!0,t)}},"23cb":function(t,e,n){var r=n("a691"),o=Math.max,i=Math.min;t.exports=function(t,e){var n=r(t);return n<0?o(n+e,0):i(n,e)}},"23e7":function(t,e,n){var r=n("da84"),o=n("06cf").f,i=n("9112"),c=n("6eeb"),u=n("ce4e"),a=n("e893"),f=n("94ca");t.exports=function(t,e){var n,s,l,p,d,v,h=t.target,y=t.global,b=t.stat;if(s=y?r:b?r[h]||u(h,{}):(r[h]||{}).prototype,s)for(l in e){if(d=e[l],t.noTargetGet?(v=o(s,l),p=v&&v.value):p=s[l],n=f(y?l:h+(b?".":"#")+l,t.forced),!n&&void 0!==p){if(typeof d===typeof p)continue;a(d,p)}(t.sham||p&&p.sham)&&i(d,"sham",!0),c(s,l,d,t)}}},"241c":function(t,e,n){var r=n("ca84"),o=n("7839"),i=o.concat("length","prototype");e.f=Object.getOwnPropertyNames||function(t){return r(t,i)}},2626:function(t,e,n){"use strict";var r=n("d066"),o=n("9bf2"),i=n("b622"),c=n("83ab"),u=i("species");t.exports=function(t){var e=r(t),n=o.f;c&&e&&!e[u]&&n(e,u,{configurable:!0,get:function(){return this}})}},"2cf4":function(t,e,n){var r,o,i,c=n("da84"),u=n("d039"),a=n("c6b6"),f=n("0366"),s=n("1be4"),l=n("cc12"),p=n("1cdc"),d=c.location,v=c.setImmediate,h=c.clearImmediate,y=c.process,b=c.MessageChannel,g=c.Dispatch,m=0,x={},w="onreadystatechange",S=function(t){if(x.hasOwnProperty(t)){var e=x[t];delete x[t],e()}},j=function(t){return function(){S(t)}},P=function(t){S(t.data)},E=function(t){c.postMessage(t+"",d.protocol+"//"+d.host)};v&&h||(v=function(t){var e=[],n=1;while(arguments.length>n)e.push(arguments[n++]);return x[++m]=function(){("function"==typeof t?t:Function(t)).apply(void 0,e)},r(m),m},h=function(t){delete x[t]},"process"==a(y)?r=function(t){y.nextTick(j(t))}:g&&g.now?r=function(t){g.now(j(t))}:b&&!p?(o=new b,i=o.port2,o.port1.onmessage=P,r=f(i.postMessage,i,1)):!c.addEventListener||"function"!=typeof postMessage||c.importScripts||u(E)||"file:"===d.protocol?r=w in l("script")?function(t){s.appendChild(l("script"))[w]=function(){s.removeChild(this),S(t)}}:function(t){setTimeout(j(t),0)}:(r=E,c.addEventListener("message",P,!1))),t.exports={set:v,clear:h}},"2d00":function(t,e,n){var r,o,i=n("da84"),c=n("342f"),u=i.process,a=u&&u.versions,f=a&&a.v8;f?(r=f.split("."),o=r[0]+r[1]):c&&(r=c.match(/Edge\/(\d+)/),(!r||r[1]>=74)&&(r=c.match(/Chrome\/(\d+)/),r&&(o=r[1]))),t.exports=o&&+o},"342f":function(t,e,n){var r=n("d066");t.exports=r("navigator","userAgent")||""},"35a1":function(t,e,n){var r=n("f5df"),o=n("3f8c"),i=n("b622"),c=i("iterator");t.exports=function(t){if(void 0!=t)return t[c]||t["@@iterator"]||o[r(t)]}},"37e8":function(t,e,n){var r=n("83ab"),o=n("9bf2"),i=n("825a"),c=n("df75");t.exports=r?Object.defineProperties:function(t,e){i(t);var n,r=c(e),u=r.length,a=0;while(u>a)o.f(t,n=r[a++],e[n]);return t}},"3bbe":function(t,e,n){var r=n("861d");t.exports=function(t){if(!r(t)&&null!==t)throw TypeError("Can't set "+String(t)+" as a prototype");return t}},"3f8c":function(t,e){t.exports={}},4160:function(t,e,n){"use strict";var r=n("23e7"),o=n("17c2");r({target:"Array",proto:!0,forced:[].forEach!=o},{forEach:o})},"428f":function(t,e,n){var r=n("da84");t.exports=r},"44ad":function(t,e,n){var r=n("d039"),o=n("c6b6"),i="".split;t.exports=r((function(){return!Object("z").propertyIsEnumerable(0)}))?function(t){return"String"==o(t)?i.call(t,""):Object(t)}:Object},"44de":function(t,e,n){var r=n("da84");t.exports=function(t,e){var n=r.console;n&&n.error&&(1===arguments.length?n.error(t):n.error(t,e))}},4840:function(t,e,n){var r=n("825a"),o=n("1c0b"),i=n("b622"),c=i("species");t.exports=function(t,e){var n,i=r(t).constructor;return void 0===i||void 0==(n=r(i)[c])?e:o(n)}},4930:function(t,e,n){var r=n("d039");t.exports=!!Object.getOwnPropertySymbols&&!r((function(){return!String(Symbol())}))},"4d64":function(t,e,n){var r=n("fc6a"),o=n("50c4"),i=n("23cb"),c=function(t){return function(e,n,c){var u,a=r(e),f=o(a.length),s=i(c,f);if(t&&n!=n){while(f>s)if(u=a[s++],u!=u)return!0}else for(;f>s;s++)if((t||s in a)&&a[s]===n)return t||s||0;return!t&&-1}};t.exports={includes:c(!0),indexOf:c(!1)}},"50c4":function(t,e,n){var r=n("a691"),o=Math.min;t.exports=function(t){return t>0?o(r(t),9007199254740991):0}},5135:function(t,e){var n={}.hasOwnProperty;t.exports=function(t,e){return n.call(t,e)}},5692:function(t,e,n){var r=n("c430"),o=n("c6cd");(t.exports=function(t,e){return o[t]||(o[t]=void 0!==e?e:{})})("versions",[]).push({version:"3.6.5",mode:r?"pure":"global",copyright:"© 2020 Denis Pushkarev (zloirock.ru)"})},"56ef":function(t,e,n){var r=n("d066"),o=n("241c"),i=n("7418"),c=n("825a");t.exports=r("Reflect","ownKeys")||function(t){var e=o.f(c(t)),n=i.f;return n?e.concat(n(t)):e}},5899:function(t,e){t.exports="\t\n\v\f\r                　\u2028\u2029\ufeff"},"58a8":function(t,e,n){var r=n("1d80"),o=n("5899"),i="["+o+"]",c=RegExp("^"+i+i+"*"),u=RegExp(i+i+"*$"),a=function(t){return function(e){var n=String(r(e));return 1&t&&(n=n.replace(c,"")),2&t&&(n=n.replace(u,"")),n}};t.exports={start:a(1),end:a(2),trim:a(3)}},"5c6c":function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},"65f0":function(t,e,n){var r=n("861d"),o=n("e8b5"),i=n("b622"),c=i("species");t.exports=function(t,e){var n;return o(t)&&(n=t.constructor,"function"!=typeof n||n!==Array&&!o(n.prototype)?r(n)&&(n=n[c],null===n&&(n=void 0)):n=void 0),new(void 0===n?Array:n)(0===e?0:e)}},"69f3":function(t,e,n){var r,o,i,c=n("7f9a"),u=n("da84"),a=n("861d"),f=n("9112"),s=n("5135"),l=n("f772"),p=n("d012"),d=u.WeakMap,v=function(t){return i(t)?o(t):r(t,{})},h=function(t){return function(e){var n;if(!a(e)||(n=o(e)).type!==t)throw TypeError("Incompatible receiver, "+t+" required");return n}};if(c){var y=new d,b=y.get,g=y.has,m=y.set;r=function(t,e){return m.call(y,t,e),e},o=function(t){return b.call(y,t)||{}},i=function(t){return g.call(y,t)}}else{var x=l("state");p[x]=!0,r=function(t,e){return f(t,x,e),e},o=function(t){return s(t,x)?t[x]:{}},i=function(t){return s(t,x)}}t.exports={set:r,get:o,has:i,enforce:v,getterFor:h}},"6eeb":function(t,e,n){var r=n("da84"),o=n("9112"),i=n("5135"),c=n("ce4e"),u=n("8925"),a=n("69f3"),f=a.get,s=a.enforce,l=String(String).split("String");(t.exports=function(t,e,n,u){var a=!!u&&!!u.unsafe,f=!!u&&!!u.enumerable,p=!!u&&!!u.noTargetGet;"function"==typeof n&&("string"!=typeof e||i(n,"name")||o(n,"name",e),s(n).source=l.join("string"==typeof e?e:"")),t!==r?(a?!p&&t[e]&&(f=!0):delete t[e],f?t[e]=n:o(t,e,n)):f?t[e]=n:c(e,n)})(Function.prototype,"toString",(function(){return"function"==typeof this&&f(this).source||u(this)}))},7156:function(t,e,n){var r=n("861d"),o=n("d2bb");t.exports=function(t,e,n){var i,c;return o&&"function"==typeof(i=e.constructor)&&i!==n&&r(c=i.prototype)&&c!==n.prototype&&o(t,c),t}},7418:function(t,e){e.f=Object.getOwnPropertySymbols},7839:function(t,e){t.exports=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"]},"7b0b":function(t,e,n){var r=n("1d80");t.exports=function(t){return Object(r(t))}},"7c73":function(t,e,n){var r,o=n("825a"),i=n("37e8"),c=n("7839"),u=n("d012"),a=n("1be4"),f=n("cc12"),s=n("f772"),l=">",p="<",d="prototype",v="script",h=s("IE_PROTO"),y=function(){},b=function(t){return p+v+l+t+p+"/"+v+l},g=function(t){t.write(b("")),t.close();var e=t.parentWindow.Object;return t=null,e},m=function(){var t,e=f("iframe"),n="java"+v+":";return e.style.display="none",a.appendChild(e),e.src=String(n),t=e.contentWindow.document,t.open(),t.write(b("document.F=Object")),t.close(),t.F},x=function(){try{r=document.domain&&new ActiveXObject("htmlfile")}catch(e){}x=r?g(r):m();var t=c.length;while(t--)delete x[d][c[t]];return x()};u[h]=!0,t.exports=Object.create||function(t,e){var n;return null!==t?(y[d]=o(t),n=new y,y[d]=null,n[h]=t):n=x(),void 0===e?n:i(n,e)}},"7f9a":function(t,e,n){var r=n("da84"),o=n("8925"),i=r.WeakMap;t.exports="function"===typeof i&&/native code/.test(o(i))},"825a":function(t,e,n){var r=n("861d");t.exports=function(t){if(!r(t))throw TypeError(String(t)+" is not an object");return t}},"83ab":function(t,e,n){var r=n("d039");t.exports=!r((function(){return 7!=Object.defineProperty({},1,{get:function(){return 7}})[1]}))},"861d":function(t,e){t.exports=function(t){return"object"===typeof t?null!==t:"function"===typeof t}},8875:function(t,e,n){var r,o,i;(function(n,c){o=[],r=c,i="function"===typeof r?r.apply(e,o):r,void 0===i||(t.exports=i)})("undefined"!==typeof self&&self,(function(){function t(){var e=Object.getOwnPropertyDescriptor(document,"currentScript");if(!e&&"currentScript"in document&&document.currentScript)return document.currentScript;if(e&&e.get!==t&&document.currentScript)return document.currentScript;try{throw new Error}catch(d){var n,r,o,i=/.*at [^(]*\((.*):(.+):(.+)\)$/gi,c=/@([^@]*):(\d+):(\d+)\s*$/gi,u=i.exec(d.stack)||c.exec(d.stack),a=u&&u[1]||!1,f=u&&u[2]||!1,s=document.location.href.replace(document.location.hash,""),l=document.getElementsByTagName("script");a===s&&(n=document.documentElement.outerHTML,r=new RegExp("(?:[^\\n]+?\\n){0,"+(f-2)+"}[^<]*<script>([\\d\\D]*?)<\\/script>[\\d\\D]*","i"),o=n.replace(r,"$1").trim());for(var p=0;p<l.length;p++){if("interactive"===l[p].readyState)return l[p];if(l[p].src===a)return l[p];if(a===s&&l[p].innerHTML&&l[p].innerHTML.trim()===o)return l[p]}return null}}return t}))},8925:function(t,e,n){var r=n("c6cd"),o=Function.toString;"function"!=typeof r.inspectSource&&(r.inspectSource=function(t){return o.call(t)}),t.exports=r.inspectSource},"8bbf":function(e,n){e.exports=t},"90e3":function(t,e){var n=0,r=Math.random();t.exports=function(t){return"Symbol("+String(void 0===t?"":t)+")_"+(++n+r).toString(36)}},9112:function(t,e,n){var r=n("83ab"),o=n("9bf2"),i=n("5c6c");t.exports=r?function(t,e,n){return o.f(t,e,i(1,n))}:function(t,e,n){return t[e]=n,t}},"94ca":function(t,e,n){var r=n("d039"),o=/#|\.prototype\./,i=function(t,e){var n=u[c(t)];return n==f||n!=a&&("function"==typeof e?r(e):!!e)},c=i.normalize=function(t){return String(t).replace(o,".").toLowerCase()},u=i.data={},a=i.NATIVE="N",f=i.POLYFILL="P";t.exports=i},"9bdd":function(t,e,n){var r=n("825a");t.exports=function(t,e,n,o){try{return o?e(r(n)[0],n[1]):e(n)}catch(c){var i=t["return"];throw void 0!==i&&r(i.call(t)),c}}},"9bf2":function(t,e,n){var r=n("83ab"),o=n("0cfb"),i=n("825a"),c=n("c04e"),u=Object.defineProperty;e.f=r?u:function(t,e,n){if(i(t),e=c(e,!0),i(n),o)try{return u(t,e,n)}catch(r){}if("get"in n||"set"in n)throw TypeError("Accessors not supported");return"value"in n&&(t[e]=n.value),t}},"9fab":function(t,e,n){(function(e,n){t.exports=n()})(0,(function(t){return function(t,e){if(void 0==e&&(e={fuzzy:!0}),/youtu\.?be/.test(t)){var n,r=[/youtu\.be\/([^#\&\?]{11})/,/\?v=([^#\&\?]{11})/,/\&v=([^#\&\?]{11})/,/embed\/([^#\&\?]{11})/,/\/v\/([^#\&\?]{11})/];for(n=0;n<r.length;++n)if(r[n].test(t))return r[n].exec(t)[1];if(e.fuzzy){var o=t.split(/[\/\&\?=#\.\s]/g);for(n=0;n<o.length;++n)if(/^[^#\&\?]{11}$/.test(o[n]))return o[n]}}return null}}))},a640:function(t,e,n){"use strict";var r=n("d039");t.exports=function(t,e){var n=[][t];return!!n&&r((function(){n.call(null,e||function(){throw 1},1)}))}},a691:function(t,e){var n=Math.ceil,r=Math.floor;t.exports=function(t){return isNaN(t=+t)?0:(t>0?r:n)(t)}},a9e3:function(t,e,n){"use strict";var r=n("83ab"),o=n("da84"),i=n("94ca"),c=n("6eeb"),u=n("5135"),a=n("c6b6"),f=n("7156"),s=n("c04e"),l=n("d039"),p=n("7c73"),d=n("241c").f,v=n("06cf").f,h=n("9bf2").f,y=n("58a8").trim,b="Number",g=o[b],m=g.prototype,x=a(p(m))==b,w=function(t){var e,n,r,o,i,c,u,a,f=s(t,!1);if("string"==typeof f&&f.length>2)if(f=y(f),e=f.charCodeAt(0),43===e||45===e){if(n=f.charCodeAt(2),88===n||120===n)return NaN}else if(48===e){switch(f.charCodeAt(1)){case 66:case 98:r=2,o=49;break;case 79:case 111:r=8,o=55;break;default:return+f}for(i=f.slice(2),c=i.length,u=0;u<c;u++)if(a=i.charCodeAt(u),a<48||a>o)return NaN;return parseInt(i,r)}return+f};if(i(b,!g(" 0o1")||!g("0b1")||g("+0x1"))){for(var S,j=function(t){var e=arguments.length<1?0:t,n=this;return n instanceof j&&(x?l((function(){m.valueOf.call(n)})):a(n)!=b)?f(new g(w(e)),n,j):w(e)},P=r?d(g):"MAX_VALUE,MIN_VALUE,NaN,NEGATIVE_INFINITY,POSITIVE_INFINITY,EPSILON,isFinite,isInteger,isNaN,isSafeInteger,MAX_SAFE_INTEGER,MIN_SAFE_INTEGER,parseFloat,parseInt,isInteger".split(","),E=0;P.length>E;E++)u(g,S=P[E])&&!u(j,S)&&h(j,S,v(g,S));j.prototype=m,m.constructor=j,c(o,b,j)}},ae40:function(t,e,n){var r=n("83ab"),o=n("d039"),i=n("5135"),c=Object.defineProperty,u={},a=function(t){throw t};t.exports=function(t,e){if(i(u,t))return u[t];e||(e={});var n=[][t],f=!!i(e,"ACCESSORS")&&e.ACCESSORS,s=i(e,0)?e[0]:a,l=i(e,1)?e[1]:void 0;return u[t]=!!n&&!o((function(){if(f&&!r)return!0;var t={length:-1};f?c(t,1,{enumerable:!0,get:a}):t[1]=1,n.call(t,s,l)}))}},b041:function(t,e,n){"use strict";var r=n("00ee"),o=n("f5df");t.exports=r?{}.toString:function(){return"[object "+o(this)+"]"}},b575:function(t,e,n){var r,o,i,c,u,a,f,s,l=n("da84"),p=n("06cf").f,d=n("c6b6"),v=n("2cf4").set,h=n("1cdc"),y=l.MutationObserver||l.WebKitMutationObserver,b=l.process,g=l.Promise,m="process"==d(b),x=p(l,"queueMicrotask"),w=x&&x.value;w||(r=function(){var t,e;m&&(t=b.domain)&&t.exit();while(o){e=o.fn,o=o.next;try{e()}catch(n){throw o?c():i=void 0,n}}i=void 0,t&&t.enter()},m?c=function(){b.nextTick(r)}:y&&!h?(u=!0,a=document.createTextNode(""),new y(r).observe(a,{characterData:!0}),c=function(){a.data=u=!u}):g&&g.resolve?(f=g.resolve(void 0),s=f.then,c=function(){s.call(f,r)}):c=function(){v.call(l,r)}),t.exports=w||function(t){var e={fn:t,next:void 0};i&&(i.next=e),o||(o=e,c()),i=e}},b622:function(t,e,n){var r=n("da84"),o=n("5692"),i=n("5135"),c=n("90e3"),u=n("4930"),a=n("fdbf"),f=o("wks"),s=r.Symbol,l=a?s:s&&s.withoutSetter||c;t.exports=function(t){return i(f,t)||(u&&i(s,t)?f[t]=s[t]:f[t]=l("Symbol."+t)),f[t]}},b727:function(t,e,n){var r=n("0366"),o=n("44ad"),i=n("7b0b"),c=n("50c4"),u=n("65f0"),a=[].push,f=function(t){var e=1==t,n=2==t,f=3==t,s=4==t,l=6==t,p=5==t||l;return function(d,v,h,y){for(var b,g,m=i(d),x=o(m),w=r(v,h,3),S=c(x.length),j=0,P=y||u,E=e?P(d,S):n?P(d,0):void 0;S>j;j++)if((p||j in x)&&(b=x[j],g=w(b,j,m),t))if(e)E[j]=g;else if(g)switch(t){case 3:return!0;case 5:return b;case 6:return j;case 2:a.call(E,b)}else if(s)return!1;return l?-1:f||s?s:E}};t.exports={forEach:f(0),map:f(1),filter:f(2),some:f(3),every:f(4),find:f(5),findIndex:f(6)}},c04e:function(t,e,n){var r=n("861d");t.exports=function(t,e){if(!r(t))return t;var n,o;if(e&&"function"==typeof(n=t.toString)&&!r(o=n.call(t)))return o;if("function"==typeof(n=t.valueOf)&&!r(o=n.call(t)))return o;if(!e&&"function"==typeof(n=t.toString)&&!r(o=n.call(t)))return o;throw TypeError("Can't convert object to primitive value")}},c430:function(t,e){t.exports=!1},c6b6:function(t,e){var n={}.toString;t.exports=function(t){return n.call(t).slice(8,-1)}},c6cd:function(t,e,n){var r=n("da84"),o=n("ce4e"),i="__core-js_shared__",c=r[i]||o(i,{});t.exports=c},c8ba:function(t,e){var n;n=function(){return this}();try{n=n||new Function("return this")()}catch(r){"object"===typeof window&&(n=window)}t.exports=n},ca84:function(t,e,n){var r=n("5135"),o=n("fc6a"),i=n("4d64").indexOf,c=n("d012");t.exports=function(t,e){var n,u=o(t),a=0,f=[];for(n in u)!r(c,n)&&r(u,n)&&f.push(n);while(e.length>a)r(u,n=e[a++])&&(~i(f,n)||f.push(n));return f}},cc12:function(t,e,n){var r=n("da84"),o=n("861d"),i=r.document,c=o(i)&&o(i.createElement);t.exports=function(t){return c?i.createElement(t):{}}},cdf9:function(t,e,n){var r=n("825a"),o=n("861d"),i=n("f069");t.exports=function(t,e){if(r(t),o(e)&&e.constructor===t)return e;var n=i.f(t),c=n.resolve;return c(e),n.promise}},ce4e:function(t,e,n){var r=n("da84"),o=n("9112");t.exports=function(t,e){try{o(r,t,e)}catch(n){r[t]=e}return e}},d012:function(t,e){t.exports={}},d039:function(t,e){t.exports=function(t){try{return!!t()}catch(e){return!0}}},d066:function(t,e,n){var r=n("428f"),o=n("da84"),i=function(t){return"function"==typeof t?t:void 0};t.exports=function(t,e){return arguments.length<2?i(r[t])||i(o[t]):r[t]&&r[t][e]||o[t]&&o[t][e]}},d1e7:function(t,e,n){"use strict";var r={}.propertyIsEnumerable,o=Object.getOwnPropertyDescriptor,i=o&&!r.call({1:2},1);e.f=i?function(t){var e=o(this,t);return!!e&&e.enumerable}:r},d2bb:function(t,e,n){var r=n("825a"),o=n("3bbe");t.exports=Object.setPrototypeOf||("__proto__"in{}?function(){var t,e=!1,n={};try{t=Object.getOwnPropertyDescriptor(Object.prototype,"__proto__").set,t.call(n,[]),e=n instanceof Array}catch(i){}return function(n,i){return r(n),o(i),e?t.call(n,i):n.__proto__=i,n}}():void 0)},d3b7:function(t,e,n){var r=n("00ee"),o=n("6eeb"),i=n("b041");r||o(Object.prototype,"toString",i,{unsafe:!0})},d44e:function(t,e,n){var r=n("9bf2").f,o=n("5135"),i=n("b622"),c=i("toStringTag");t.exports=function(t,e,n){t&&!o(t=n?t:t.prototype,c)&&r(t,c,{configurable:!0,value:e})}},da84:function(t,e,n){(function(e){var n=function(t){return t&&t.Math==Math&&t};t.exports=n("object"==typeof globalThis&&globalThis)||n("object"==typeof window&&window)||n("object"==typeof self&&self)||n("object"==typeof e&&e)||Function("return this")()}).call(this,n("c8ba"))},df75:function(t,e,n){var r=n("ca84"),o=n("7839");t.exports=Object.keys||function(t){return r(t,o)}},e2cc:function(t,e,n){var r=n("6eeb");t.exports=function(t,e,n){for(var o in e)r(t,o,e[o],n);return t}},e667:function(t,e){t.exports=function(t){try{return{error:!1,value:t()}}catch(e){return{error:!0,value:e}}}},e6cf:function(t,e,n){"use strict";var r,o,i,c,u=n("23e7"),a=n("c430"),f=n("da84"),s=n("d066"),l=n("fea9"),p=n("6eeb"),d=n("e2cc"),v=n("d44e"),h=n("2626"),y=n("861d"),b=n("1c0b"),g=n("19aa"),m=n("c6b6"),x=n("8925"),w=n("2266"),S=n("1c7e"),j=n("4840"),P=n("2cf4").set,E=n("b575"),O=n("cdf9"),T=n("44de"),I=n("f069"),A=n("e667"),L=n("69f3"),V=n("94ca"),M=n("b622"),N=n("2d00"),k=M("species"),R="Promise",C=L.get,_=L.set,D=L.getterFor(R),F=l,B=f.TypeError,U=f.document,G=f.process,$=s("fetch"),Y=I.f,z=Y,H="process"==m(G),q=!!(U&&U.createEvent&&f.dispatchEvent),Q="unhandledrejection",W="rejectionhandled",X=0,K=1,J=2,Z=1,tt=2,et=V(R,(function(){var t=x(F)!==String(F);if(!t){if(66===N)return!0;if(!H&&"function"!=typeof PromiseRejectionEvent)return!0}if(a&&!F.prototype["finally"])return!0;if(N>=51&&/native code/.test(F))return!1;var e=F.resolve(1),n=function(t){t((function(){}),(function(){}))},r=e.constructor={};return r[k]=n,!(e.then((function(){}))instanceof n)})),nt=et||!S((function(t){F.all(t)["catch"]((function(){}))})),rt=function(t){var e;return!(!y(t)||"function"!=typeof(e=t.then))&&e},ot=function(t,e,n){if(!e.notified){e.notified=!0;var r=e.reactions;E((function(){var o=e.value,i=e.state==K,c=0;while(r.length>c){var u,a,f,s=r[c++],l=i?s.ok:s.fail,p=s.resolve,d=s.reject,v=s.domain;try{l?(i||(e.rejection===tt&&at(t,e),e.rejection=Z),!0===l?u=o:(v&&v.enter(),u=l(o),v&&(v.exit(),f=!0)),u===s.promise?d(B("Promise-chain cycle")):(a=rt(u))?a.call(u,p,d):p(u)):d(o)}catch(h){v&&!f&&v.exit(),d(h)}}e.reactions=[],e.notified=!1,n&&!e.rejection&&ct(t,e)}))}},it=function(t,e,n){var r,o;q?(r=U.createEvent("Event"),r.promise=e,r.reason=n,r.initEvent(t,!1,!0),f.dispatchEvent(r)):r={promise:e,reason:n},(o=f["on"+t])?o(r):t===Q&&T("Unhandled promise rejection",n)},ct=function(t,e){P.call(f,(function(){var n,r=e.value,o=ut(e);if(o&&(n=A((function(){H?G.emit("unhandledRejection",r,t):it(Q,t,r)})),e.rejection=H||ut(e)?tt:Z,n.error))throw n.value}))},ut=function(t){return t.rejection!==Z&&!t.parent},at=function(t,e){P.call(f,(function(){H?G.emit("rejectionHandled",t):it(W,t,e.value)}))},ft=function(t,e,n,r){return function(o){t(e,n,o,r)}},st=function(t,e,n,r){e.done||(e.done=!0,r&&(e=r),e.value=n,e.state=J,ot(t,e,!0))},lt=function(t,e,n,r){if(!e.done){e.done=!0,r&&(e=r);try{if(t===n)throw B("Promise can't be resolved itself");var o=rt(n);o?E((function(){var r={done:!1};try{o.call(n,ft(lt,t,r,e),ft(st,t,r,e))}catch(i){st(t,r,i,e)}})):(e.value=n,e.state=K,ot(t,e,!1))}catch(i){st(t,{done:!1},i,e)}}};et&&(F=function(t){g(this,F,R),b(t),r.call(this);var e=C(this);try{t(ft(lt,this,e),ft(st,this,e))}catch(n){st(this,e,n)}},r=function(t){_(this,{type:R,done:!1,notified:!1,parent:!1,reactions:[],rejection:!1,state:X,value:void 0})},r.prototype=d(F.prototype,{then:function(t,e){var n=D(this),r=Y(j(this,F));return r.ok="function"!=typeof t||t,r.fail="function"==typeof e&&e,r.domain=H?G.domain:void 0,n.parent=!0,n.reactions.push(r),n.state!=X&&ot(this,n,!1),r.promise},catch:function(t){return this.then(void 0,t)}}),o=function(){var t=new r,e=C(t);this.promise=t,this.resolve=ft(lt,t,e),this.reject=ft(st,t,e)},I.f=Y=function(t){return t===F||t===i?new o(t):z(t)},a||"function"!=typeof l||(c=l.prototype.then,p(l.prototype,"then",(function(t,e){var n=this;return new F((function(t,e){c.call(n,t,e)})).then(t,e)}),{unsafe:!0}),"function"==typeof $&&u({global:!0,enumerable:!0,forced:!0},{fetch:function(t){return O(F,$.apply(f,arguments))}}))),u({global:!0,wrap:!0,forced:et},{Promise:F}),v(F,R,!1,!0),h(R),i=s(R),u({target:R,stat:!0,forced:et},{reject:function(t){var e=Y(this);return e.reject.call(void 0,t),e.promise}}),u({target:R,stat:!0,forced:a||et},{resolve:function(t){return O(a&&this===i?F:this,t)}}),u({target:R,stat:!0,forced:nt},{all:function(t){var e=this,n=Y(e),r=n.resolve,o=n.reject,i=A((function(){var n=b(e.resolve),i=[],c=0,u=1;w(t,(function(t){var a=c++,f=!1;i.push(void 0),u++,n.call(e,t).then((function(t){f||(f=!0,i[a]=t,--u||r(i))}),o)})),--u||r(i)}));return i.error&&o(i.value),n.promise},race:function(t){var e=this,n=Y(e),r=n.reject,o=A((function(){var o=b(e.resolve);w(t,(function(t){o.call(e,t).then(n.resolve,r)}))}));return o.error&&r(o.value),n.promise}})},e893:function(t,e,n){var r=n("5135"),o=n("56ef"),i=n("06cf"),c=n("9bf2");t.exports=function(t,e){for(var n=o(e),u=c.f,a=i.f,f=0;f<n.length;f++){var s=n[f];r(t,s)||u(t,s,a(e,s))}}},e8b5:function(t,e,n){var r=n("c6b6");t.exports=Array.isArray||function(t){return"Array"==r(t)}},e95a:function(t,e,n){var r=n("b622"),o=n("3f8c"),i=r("iterator"),c=Array.prototype;t.exports=function(t){return void 0!==t&&(o.Array===t||c[i]===t)}},f069:function(t,e,n){"use strict";var r=n("1c0b"),o=function(t){var e,n;this.promise=new t((function(t,r){if(void 0!==e||void 0!==n)throw TypeError("Bad Promise constructor");e=t,n=r})),this.resolve=r(e),this.reject=r(n)};t.exports.f=function(t){return new o(t)}},f5df:function(t,e,n){var r=n("00ee"),o=n("c6b6"),i=n("b622"),c=i("toStringTag"),u="Arguments"==o(function(){return arguments}()),a=function(t,e){try{return t[e]}catch(n){}};t.exports=r?o:function(t){var e,n,r;return void 0===t?"Undefined":null===t?"Null":"string"==typeof(n=a(e=Object(t),c))?n:u?o(e):"Object"==(r=o(e))&&"function"==typeof e.callee?"Arguments":r}},f772:function(t,e,n){var r=n("5692"),o=n("90e3"),i=r("keys");t.exports=function(t){return i[t]||(i[t]=o(t))}},fb15:function(t,e,n){"use strict";if(n.r(e),n.d(e,"PlayerState",(function(){return s})),"undefined"!==typeof window){var r=window.document.currentScript,o=n("8875");r=o(),"currentScript"in document||Object.defineProperty(document,"currentScript",{get:o});var i=r&&r.src.match(/(.+\/)[^/]+\.js(\?.*)?$/);i&&(n.p=i[1])}var c=n("8bbf");function u(t,e,n,r,o,i){return Object(c["openBlock"])(),Object(c["createBlock"])("div",{style:t.wrapperStyle},[Object(c["createVNode"])("div",{ref:"youtube",style:t.wrapperStyle},null,4)],4)}n("4160"),n("a9e3"),n("d3b7"),n("e6cf"),n("159b");var a=n("9fab"),f=n.n(a),s={UNSTARTED:-1,ENDED:0,PLAYING:1,PAUSED:2,BUFFERING:3,CUED:5},l=Object(c["defineComponent"])({name:"YouTube",props:{src:{type:String,required:!0},height:{type:[Number,String],default:360},width:{type:[Number,String],default:640},host:{type:String,default:"https://www.youtube.com"},vars:Object},computed:{id:function(){return f()(this.src)||this.src},wrapperStyle:function(){return{width:"".concat(this.width,"px"),height:"".concat(this.height,"px"),position:"relative"}}},data:function(){var t=function(){},e=new Promise((function(e){t=e})),n={promise:e,resolver:t,player:null,initiated:!1,ready:!1,iframeStyle:{position:"absolute",top:"0",left:"0",width:"100%",height:"100%"}};return n},mounted:function(){var t=this;window.onYouTubeIframeAPIReadyResolvers||(window.onYouTubeIframeAPIReadyResolvers=[]),window.onYouTubeIframeAPIReady||(window.onYouTubeIframeAPIReady=function(){var t;null===(t=window.onYouTubeIframeAPIReadyResolvers)||void 0===t||t.forEach((function(t){t()}))}),this.promise.then((function(){return t.initPlayer()}));var e="youtube-iframe-js-api-script",n=document.getElementById(e);if(n)this.resolver();else{var r;null===(r=window.onYouTubeIframeAPIReadyResolvers)||void 0===r||r.push(this.resolver),n=document.createElement("script"),n.id=e,n.src="https://www.youtube.com/iframe_api";var o=document.getElementsByTagName("script")[0];o&&o.parentNode&&o.parentNode.insertBefore(n,o)}},methods:{initPlayer:function(){var t=this;this.initiated=!0,this.player=new YT.Player(this.$refs.youtube,{height:this.height,width:this.width,videoId:this.id,host:this.host,playerVars:this.vars,events:{onReady:function(e){t.ready=!0,setTimeout((function(){return t.$emit("ready",e)}))},onStateChange:function(e){return t.$emit("state-change",e)},onPlaybackQualityChange:function(e){return t.$emit("playback-quality-change",e)},onPlaybackRateChange:function(e){return t.$emit("playback-rate-change",e)},onError:function(e){return t.$emit("error",e)},onApiChange:function(e){return t.$emit("api-change",e)}}})},cueVideoById:function(t,e,n){var r;null===(r=this.player)||void 0===r||r.cueVideoById(t,e,n)},loadVideoById:function(t,e,n){var r;null===(r=this.player)||void 0===r||r.loadVideoById(t,e,n)},cueVideoByUrl:function(t,e,n){var r;null===(r=this.player)||void 0===r||r.cueVideoByUrl(t,e,n)},loadVideoByUrl:function(t,e,n){var r;null===(r=this.player)||void 0===r||r.loadVideoByUrl(t,e,n)},cuePlaylist:function(t,e,n,r){var o;null===(o=this.player)||void 0===o||o.cuePlaylist(t,e,n,r)},loadPlaylist:function(t,e,n,r){var o;null===(o=this.player)||void 0===o||o.loadPlaylist(t,e,n,r)},playVideo:function(){var t;null===(t=this.player)||void 0===t||t.playVideo()},pauseVideo:function(){var t;null===(t=this.player)||void 0===t||t.pauseVideo()},stopVideo:function(){var t;null===(t=this.player)||void 0===t||t.stopVideo()},seekTo:function(t,e){var n;null===(n=this.player)||void 0===n||n.seekTo(t,e)},nextVideo:function(){var t;null===(t=this.player)||void 0===t||t.nextVideo()},previousVideo:function(){var t;null===(t=this.player)||void 0===t||t.previousVideo()},playVideoAt:function(t){var e;null===(e=this.player)||void 0===e||e.playVideoAt(t)},mute:function(){var t;null===(t=this.player)||void 0===t||t.mute()},unMute:function(){var t;null===(t=this.player)||void 0===t||t.unMute()},isMuted:function(){return!!this.player&&this.player.isMuted()},setVolume:function(t){var e;null===(e=this.player)||void 0===e||e.setVolume(t)},getVolume:function(){return this.player?this.player.getVolume():0},getPlaybackRate:function(){return this.player?this.player.getPlaybackRate():0},setPlaybackRate:function(t){var e;null===(e=this.player)||void 0===e||e.setPlaybackRate(t)},getAvailablePlaybackRates:function(){return this.player?this.player.getAvailablePlaybackRates():[]},setLoop:function(t){var e;null===(e=this.player)||void 0===e||e.setLoop(t)},setShuffle:function(t){var e;null===(e=this.player)||void 0===e||e.setShuffle(t)},getVideoLoadedFraction:function(){return this.player?this.player.getVideoLoadedFraction():0},getPlayerState:function(){return this.player?this.player.getPlayerState():s.UNSTARTED},getCurrentTime:function(){return this.player?this.player.getCurrentTime():0},getPlaybackQuality:function(){return this.player?this.player.getPlaybackQuality():"default"},setPlaybackQuality:function(t){var e;null===(e=this.player)||void 0===e||e.setPlaybackQuality(t)},getAvailableQualityLevels:function(){return this.player?this.player.getAvailableQualityLevels():[]},getDuration:function(){return this.player?this.player.getDuration():0},getVideoUrl:function(){return this.player?this.player.getVideoUrl():""},getVideoEmbedCode:function(){return this.player?this.player.getVideoEmbedCode():""},getPlaylist:function(){return this.player?this.player.getPlaylist():[]},getPlaylistIndex:function(){return this.player?this.player.getPlaylistIndex():0}},watch:{width:function(){var t;null===(t=this.player)||void 0===t||t.setSize(+this.width,+this.height)},height:function(){var t;null===(t=this.player)||void 0===t||t.setSize(+this.width,+this.height)},src:function(){this.initiated&&this.player&&this.player.loadVideoById(this.id)}},beforeUnmount:function(){var t;null===(t=this.player)||void 0===t||t.destroy()}}),p=l;p.render=u;var d=p;e["default"]=d},fc6a:function(t,e,n){var r=n("44ad"),o=n("1d80");t.exports=function(t){return r(o(t))}},fdbc:function(t,e){t.exports={CSSRuleList:0,CSSStyleDeclaration:0,CSSValueList:0,ClientRectList:0,DOMRectList:0,DOMStringList:0,DOMTokenList:1,DataTransferItemList:0,FileList:0,HTMLAllCollection:0,HTMLCollection:0,HTMLFormElement:0,HTMLSelectElement:0,MediaList:0,MimeTypeArray:0,NamedNodeMap:0,NodeList:1,PaintRequestList:0,Plugin:0,PluginArray:0,SVGLengthList:0,SVGNumberList:0,SVGPathSegList:0,SVGPointList:0,SVGStringList:0,SVGTransformList:0,SourceBufferList:0,StyleSheetList:0,TextTrackCueList:0,TextTrackList:0,TouchList:0}},fdbf:function(t,e,n){var r=n("4930");t.exports=r&&!Symbol.sham&&"symbol"==typeof Symbol.iterator},fea9:function(t,e,n){var r=n("da84");t.exports=r.Promise}})["default"]}));
//# sourceMappingURL=vue3-youtube.umd.min.js.map

/***/ })

}]);