(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-104674c4"],{"50c8":function(e,t,l){"use strict";l.r(t);var a={props:{platformTable:{default:function(){return[]}},loading:{default:!1}},data:function(){return{form:{name:void 0,code:void 0,type:void 0,display:void 0,status:void 0,platform:void 0}}},methods:{handleFormSubmit:function(e){var t=0<arguments.length&&void 0!==e&&e;this.$emit("submit",this.form,t)},handleFormReset:function(){this.$refs.form.resetFields()}}},o=(l("7713"),l("2877")),r=Object(o.a)(a,function(){var t=this,e=t.$createElement,l=t._self._c||e;return l("el-form",{ref:"form",staticStyle:{"margin-bottom":"-18px"},attrs:{inline:!0,model:t.form,size:"mini"}},[l("el-form-item",{attrs:{label:"名称",prop:"name"}},[l("el-input",{staticStyle:{width:"200px"},attrs:{"prefix-icon":"el-icon-search",placeholder:"广告位置名称",clearable:!0},nativeOn:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.handleFormSubmit(!0)}},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1),l("el-form-item",{attrs:{label:"编码",prop:"code"}},[l("el-input",{staticStyle:{width:"140px"},attrs:{"prefix-icon":"el-icon-search",placeholder:"广告位置编码",clearable:!0},nativeOn:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.handleFormSubmit(!0)}},model:{value:t.form.code,callback:function(e){t.$set(t.form,"code",e)},expression:"form.code"}})],1),l("el-form-item",{attrs:{label:"类型",prop:"type"}},[l("el-select",{staticStyle:{width:"120px"},attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:t.form.type,callback:function(e){t.$set(t.form,"type",e)},expression:"form.type"}},[l("el-option",{attrs:{label:"图片",value:"0"}}),l("el-option",{attrs:{label:"代码",value:"1"}})],1)],1),l("el-form-item",[l("el-button",{attrs:{type:"primary",disabled:t.loading},on:{click:function(e){return t.handleFormSubmit(!0)}}},[l("cs-icon",{attrs:{name:"search"}}),t._v("\n      查询\n    ")],1)],1),l("el-form-item",[l("el-button",{on:{click:t.handleFormReset}},[l("cs-icon",{attrs:{name:"refresh"}}),t._v("\n      重置\n    ")],1)],1),l("el-form-item",[l("el-popover",{attrs:{width:"261",placement:"bottom",trigger:"click"}},[l("div",{staticClass:"more-filter"},[l("el-form-item",{attrs:{label:"平台",prop:"platform"}},[l("el-select",{attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:t.form.platform,callback:function(e){t.$set(t.form,"platform",e)},expression:"form.platform"}},t._l(t.platformTable,function(e,t){return l("el-option",{key:t,attrs:{label:e,value:t}})}),1)],1),l("el-form-item",{attrs:{label:"展示方式",prop:"display"}},[l("el-select",{attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:t.form.display,callback:function(e){t.$set(t.form,"display",e)},expression:"form.display"}},[l("el-option",{attrs:{label:"多个广告",value:"0"}}),l("el-option",{attrs:{label:"单个广告",value:"1"}}),l("el-option",{attrs:{label:"随机多个",value:"2"}}),l("el-option",{attrs:{label:"随机单个",value:"3"}})],1)],1),l("el-form-item",{attrs:{label:"状态",prop:"status"}},[l("el-select",{attrs:{placeholder:"请选择",clearable:"",value:""},model:{value:t.form.status,callback:function(e){t.$set(t.form,"status",e)},expression:"form.status"}},[l("el-option",{attrs:{label:"启用",value:"1"}}),l("el-option",{attrs:{label:"禁用",value:"0"}})],1)],1)],1),l("el-button",{attrs:{slot:"reference",type:"text"},slot:"reference"},[t._v("\n        更多筛选\n        "),l("cs-icon",{attrs:{name:"angle-down"}})],1)],1)],1)],1)},[],!1,null,"eee47234",null);t.default=r.exports},7713:function(e,t,l){"use strict";var a=l("9d46");l.n(a).a},"9d46":function(e,t,l){}}]);