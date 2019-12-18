(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-00d8b8b3"],{"2fab5":function(e,t,o){},3093:function(e,t,o){"use strict";o.r(t);o("8e6e"),o("456d");var a=o("bd86"),r=(o("ac6a"),o("5df3"),o("ca00")),n=o("4239"),l=o("c54e");function s(t,e){var o=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),o.push.apply(o,r)}return o}var i={props:{loading:{default:!1}},data:function(){return{brandData:[],catData:[],cascaderProps:{value:"goods_category_id",label:"name",children:"children",checkStrictly:!0},form:{goods_category_id:void 0,keywords:void 0,goods_code:void 0,brand_id:void 0,store_qty:[],is_postage:void 0,is_integral:void 0,is_recommend:void 0,is_new:void 0,is_hot:void 0}}},mounted:function(){var t=this;Promise.all([Object(n.d)({order_field:"phonetic"}),Object(l.d)(null)]).then(function(e){t.brandData=e[0].data,t.catData=e[1].data.length?r.a.formatDataToTree(e[1].data,"goods_category_id"):[]})},methods:{handleFormSubmit:function(e){var t=0<arguments.length&&void 0!==e&&e,o=function(t){for(var e=1;e<arguments.length;e++){var o=null!=arguments[e]?arguments[e]:{};e%2?s(o,!0).forEach(function(e){Object(a.a)(t,e,o[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(o)):s(o).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(o,e))})}return t}({},this.form),r=o.goods_category_id;r&&(o.goods_category_id=0<r.length?r[r.length-1]:void 0),o.store_qty[0]||o.store_qty[1]||(o.store_qty=void 0),this.$emit("submit",o,t)},handleFormReset:function(){this.$refs.form.resetFields()}}},d=(o("5791"),o("2877")),c=Object(d.a)(i,function(){var o=this,e=o.$createElement,r=o._self._c||e;return r("el-form",{ref:"form",staticStyle:{"margin-bottom":"-18px"},attrs:{inline:!0,model:o.form,size:"mini"}},[r("el-form-item",{attrs:{label:"分类",prop:"goods_category_id"}},[r("el-cascader",{staticStyle:{width:"180px"},attrs:{placeholder:"试试搜索：分类",options:o.catData,props:o.cascaderProps,"show-all-levels":!1,filterable:"",clearable:""},model:{value:o.form.goods_category_id,callback:function(e){o.$set(o.form,"goods_category_id",e)},expression:"form.goods_category_id"}})],1),r("el-form-item",{attrs:{label:"关键词",prop:"keywords"}},[r("el-input",{attrs:{"prefix-icon":"el-icon-search",placeholder:"商品关键词（可空格间隔）",clearable:!0},nativeOn:{keyup:function(e){return!e.type.indexOf("key")&&o._k(e.keyCode,"enter",13,e.key,"Enter")?null:o.handleFormSubmit(!0)}},model:{value:o.form.keywords,callback:function(e){o.$set(o.form,"keywords",e)},expression:"form.keywords"}})],1),r("el-form-item",{attrs:{label:"编码",prop:"goods_code"}},[r("el-input",{attrs:{"prefix-icon":"el-icon-search",placeholder:"货号、条码、SKU、SPU",clearable:!0},nativeOn:{keyup:function(e){return!e.type.indexOf("key")&&o._k(e.keyCode,"enter",13,e.key,"Enter")?null:o.handleFormSubmit(!0)}},model:{value:o.form.goods_code,callback:function(e){o.$set(o.form,"goods_code",e)},expression:"form.goods_code"}})],1),r("el-form-item",[r("el-button",{attrs:{type:"primary",disabled:o.loading},on:{click:function(e){return o.handleFormSubmit(!0)}}},[r("cs-icon",{attrs:{name:"search"}}),o._v("\n      查询\n    ")],1)],1),r("el-form-item",[r("el-button",{on:{click:o.handleFormReset}},[r("cs-icon",{attrs:{name:"refresh"}}),o._v("\n      重置\n    ")],1)],1),r("el-form-item",[r("el-popover",{attrs:{width:"388",placement:"bottom",trigger:"click"}},[r("div",{staticClass:"more-filter"},[r("el-form-item",{attrs:{label:"品牌",prop:"brand_id"}},[r("el-select",{staticStyle:{width:"320px"},attrs:{placeholder:"请选择",multiple:"",clearable:"",value:""},model:{value:o.form.brand_id,callback:function(e){o.$set(o.form,"brand_id",e)},expression:"form.brand_id"}},o._l(o.brandData,function(e,t){return r("el-option",{key:t,attrs:{label:e.name,value:e.brand_id}},[r("span",{staticClass:"brand-name"},[o._v(o._s(e.name))]),r("span",{staticClass:"brand-category"},[o._v(o._s(e.category_name))])])}),1)],1),r("el-form-item",{attrs:{label:"库存",prop:"store_qty"}},[r("el-input-number",{attrs:{"controls-position":"right"},nativeOn:{keyup:function(e){return!e.type.indexOf("key")&&o._k(e.keyCode,"enter",13,e.key,"Enter")?null:o.handleFormSubmit(!0)}},model:{value:o.form.store_qty[0],callback:function(e){o.$set(o.form.store_qty,0,e)},expression:"form.store_qty[0]"}}),r("span",[o._v(" 至 ")]),r("el-input-number",{attrs:{"controls-position":"right"},nativeOn:{keyup:function(e){return!e.type.indexOf("key")&&o._k(e.keyCode,"enter",13,e.key,"Enter")?null:o.handleFormSubmit(!0)}},model:{value:o.form.store_qty[1],callback:function(e){o.$set(o.form.store_qty,1,e)},expression:"form.store_qty[1]"}})],1),r("el-form-item",{attrs:{label:"是否包邮",prop:"is_postage"}},[r("el-select",{attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:o.form.is_postage,callback:function(e){o.$set(o.form,"is_postage",e)},expression:"form.is_postage"}},[r("el-option",{attrs:{label:"是",value:"1"}}),r("el-option",{attrs:{label:"否",value:"0"}})],1)],1),r("el-form-item",{attrs:{label:"积分抵扣",prop:"is_integral"}},[r("el-select",{attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:o.form.is_integral,callback:function(e){o.$set(o.form,"is_integral",e)},expression:"form.is_integral"}},[r("el-option",{attrs:{label:"可抵扣",value:"1"}}),r("el-option",{attrs:{label:"不抵扣",value:"0"}})],1)],1),r("el-form-item",{attrs:{label:"是否推荐",prop:"is_recommend"}},[r("el-select",{attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:o.form.is_recommend,callback:function(e){o.$set(o.form,"is_recommend",e)},expression:"form.is_recommend"}},[r("el-option",{attrs:{label:"是",value:"1"}}),r("el-option",{attrs:{label:"否",value:"0"}})],1)],1),r("el-form-item",{attrs:{label:"是否新品",prop:"is_new"}},[r("el-select",{attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:o.form.is_new,callback:function(e){o.$set(o.form,"is_new",e)},expression:"form.is_new"}},[r("el-option",{attrs:{label:"是",value:"1"}}),r("el-option",{attrs:{label:"否",value:"0"}})],1)],1),r("el-form-item",{attrs:{label:"是否热卖",prop:"is_hot"}},[r("el-select",{attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:o.form.is_hot,callback:function(e){o.$set(o.form,"is_hot",e)},expression:"form.is_hot"}},[r("el-option",{attrs:{label:"是",value:"1"}}),r("el-option",{attrs:{label:"否",value:"0"}})],1)],1)],1),r("el-button",{attrs:{slot:"reference",type:"text"},slot:"reference"},[o._v("\n        更多筛选\n        "),r("cs-icon",{attrs:{name:"angle-down"}})],1)],1)],1)],1)},[],!1,null,"1121c4a2",null);t.default=c.exports},4239:function(e,t,o){"use strict";o.d(t,"a",function(){return a}),o.d(t,"e",function(){return n}),o.d(t,"b",function(){return l}),o.d(t,"g",function(){return s}),o.d(t,"c",function(){return i}),o.d(t,"d",function(){return d}),o.d(t,"f",function(){return c});var r=o("b775");function a(e){return Object(r.a)({url:"/v1/brand",method:"post",params:{method:"add.brand.item"},data:e})}function n(e){return Object(r.a)({url:"/v1/brand",method:"post",params:{method:"set.brand.item"},data:e})}function l(e){return Object(r.a)({url:"/v1/brand",method:"post",params:{method:"del.brand.list"},data:{brand_id:e}})}function s(e,t){return Object(r.a)({url:"/v1/brand",method:"post",params:{method:"set.brand.status"},data:{brand_id:e,status:t}})}function i(e){return Object(r.a)({url:"/v1/brand",method:"post",params:{method:"get.brand.list"},data:e})}function d(e){return Object(r.a)({url:"/v1/brand",method:"post",params:{method:"get.brand.select"},data:e})}function c(e,t){return Object(r.a)({url:"/v1/brand",method:"post",params:{method:"set.brand.sort"},data:{brand_id:e,sort:t}})}},5791:function(e,t,o){"use strict";var r=o("2fab5");o.n(r).a},c54e:function(e,t,o){"use strict";o.d(t,"a",function(){return a}),o.d(t,"f",function(){return n}),o.d(t,"b",function(){return l}),o.d(t,"c",function(){return s}),o.d(t,"d",function(){return i}),o.d(t,"g",function(){return d}),o.d(t,"e",function(){return c});var r=o("b775");function a(e){return Object(r.a)({url:"/v1/goods_category",method:"post",params:{method:"add.goods.category.item"},data:e})}function n(e){return Object(r.a)({url:"/v1/goods_category",method:"post",params:{method:"set.goods.category.item"},data:e})}function l(e){var t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:0;return Object(r.a)({url:"/v1/goods_category",method:"post",params:{method:"del.goods.category.list"},data:{goods_category_id:e,not_empty:t}})}function s(e){return Object(r.a)({url:"/v1/goods_category",method:"post",params:{method:"get.goods.category.item"},data:{goods_category_id:e}})}function i(e){return Object(r.a)({url:"/v1/goods_category",method:"post",params:{method:"get.goods.category.list"},data:e})}function d(e,t){return Object(r.a)({url:"/v1/goods_category",method:"post",params:{method:"set.goods.category.status"},data:{goods_category_id:e,status:t}})}function c(e){return Object(r.a)({url:"/v1/goods_category",method:"post",params:{method:"set.goods.category.index"},data:{goods_category_id:e}})}}}]);