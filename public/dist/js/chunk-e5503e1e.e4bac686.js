(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-e5503e1e"],{"3cbd":function(e,t,a){},"80a1":function(e,t,a){"use strict";var r=a("3cbd");a.n(r).a},f4e9:function(e,t,a){"use strict";a.r(t);a("8e6e"),a("456d"),a("ac6a"),a("6b54");var r=a("bd86"),o=(a("7f7f"),a("a308"));function n(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),a.push.apply(a,r)}return a}function i(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?n(a,!0).forEach(function(e){Object(r.a)(t,e,a[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):n(a).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))})}return t}var s={props:{treeData:{default:function(){return[]}},loading:{default:!1},module:{default:""}},data:function(){return{hackReset:!0,isExpandAll:!1,expanded:[],filterText:"",treeModule:{},treeProps:{label:"name",children:"children"},cascaderProps:{value:"menu_id",label:"name",children:"children",checkStrictly:!0},auth:{add:!1,del:!1,set:!1,status:!1,move:!1},form:{parent_id:void 0,name:void 0,alias:void 0,icon:void 0,remark:void 0,type:"0",url:void 0,params:void 0,target:"_self",is_navi:"0",sort:50},rules:{name:[{required:!0,message:"名称不能为空",trigger:"blur"},{max:32,message:"长度不能大于 32 个字符",trigger:"blur"}],alias:[{max:16,message:"长度不能大于 16 个字符",trigger:"blur"}],sort:[{type:"number",message:"必须为数字值",trigger:"blur"}],type:[{required:!0,message:"链接类型不能为空",trigger:"blur"}],url:[{max:255,message:"长度不能大于 255 个字符",trigger:"blur"}],params:[{max:255,message:"长度不能大于 255 个字符",trigger:"blur"}],remark:[{max:255,message:"长度不能大于 255 个字符",trigger:"blur"}]},formStatus:"create",formLoading:!1,textMap:{create:"新增菜单",update:"编辑菜单"}}},watch:{filterText:function(e){this.$refs.tree.filter(e)}},mounted:function(){var t=this;Object(o.e)().then(function(e){t.treeModule=e}).then(function(){t._validationAuth()})},methods:{_validationAuth:function(){this.auth.add=this.$has("/system/auth/menu/add"),this.auth.del=this.$has("/system/auth/menu/del"),this.auth.set=this.$has("/system/auth/menu/set"),this.auth.status=this.$has("/system/auth/menu/status"),this.auth.move=this.$has("/system/auth/menu/move")},_getParentId:function(){var e=this.form.parent_id;return Array.isArray(e)?0<e.length?e[e.length-1]:0:e},filterNode:function(e,t){return!e||-1!==t.name.indexOf(e)},checkedNodes:function(e){var t=this;this.filterText="",this.expanded=[],this.hackReset=!1,this.$nextTick(function(){t.isExpandAll=e,t.hackReset=!0})},resetForm:function(){this.form={parent_id:[],name:"",alias:"",icon:"",remark:"",type:"0",url:"",params:"",target:"_self",is_navi:"0",sort:50}},resetElements:function(e){var t=this,a=0<arguments.length&&void 0!==e?e:"create";this.$nextTick(function(){t.$refs.form.clearValidate()}),this.formStatus=a,this.formLoading=!1},handleNodeClick:function(e){(this.auth.add||this.auth.set)&&(this.resetForm(),this.resetElements("update"),this.form=i({},e,{type:e.type.toString(),is_navi:e.is_navi.toString()}))},handleCreate:function(e){this.resetForm(),this.resetElements(e),this.$refs.tree.getCurrentKey()&&this.$refs.tree.setCurrentKey(null)},handleAppend:function(e){this.handleCreate("create"),this.$refs.tree.setCurrentKey(e),this.form.parent_id=e},create:function(){var t=this;this.$refs.form.validate(function(e){e&&(t.formLoading=!0,Object(o.a)(i({},t.form,{parent_id:t._getParentId(),module:t.module})).then(function(e){t.isExpandAll||(t.expanded=[e.data.parent_id||e.data.menu_id]),t.$emit("refresh"),t.$message.success("操作成功")}).catch(function(){t.formLoading=!1}))})},update:function(){var t=this;this.$refs.form.validate(function(e){e&&(t.formLoading=!0,Object(o.g)(i({},t.form,{parent_id:t._getParentId()})).then(function(e){t.isExpandAll||(t.expanded=[e.data.parent_id||e.data.menu_id]),t.$emit("refresh"),t.$message.success("操作成功")}).catch(function(){t.formLoading=!1}))})},remove:function(e){var t=this;this.$confirm("确定要执行该操作吗?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning",closeOnClickModal:!1}).then(function(){Object(o.b)(e).then(function(){t.$refs.tree.remove(t.$refs.tree.getNode(e)),t.handleCreate("create"),t.$message.success("操作成功")})}).catch(function(){})},enable:function(e,t){var a=this;this.$confirm("状态的切换会影响上下级菜单，是否确认操作?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning",closeOnClickModal:!1}).then(function(){Object(o.h)(e,t?0:1).then(function(){a.isExpandAll||(a.expanded=[a.$refs.tree.getNode(e).data.parent_id||e]),a.$emit("refresh"),a.$message.success("操作成功")})}).catch(function(){})},handleDrop:function(t,e,a){var r=this,n={menu_id:t.data.menu_id,parent_id:t.data.parent_id},s=[];"inner"===a?n.parent_id=e.key:(n.parent_id=e.data.parent_id,e.parent.childNodes.forEach(function(e,t){s.push(e.key),e.data.sort=t+1})),Object(o.g)(i({},n)).then(function(e){t.data.parent_id=e.data.parent_id}).catch(function(){r.$emit("refresh")}),0<s.length&&Object(o.f)(s).catch(function(){r.$emit("refresh")})},allowDrag:function(){return this.auth.move}}},l=(a("80a1"),a("2877")),c=Object(l.a)(s,function(){var r=this,e=r.$createElement,n=r._self._c||e;return n("div",{staticClass:"cs-p"},[n("el-form",{attrs:{inline:!0,size:"small"},nativeOn:{submit:function(e){e.preventDefault()}}},[r.auth.add?n("el-form-item",[n("el-button",{attrs:{disabled:r.loading},on:{click:function(e){return r.handleCreate("create")}}},[n("cs-icon",{attrs:{name:"plus"}}),r._v("\n        新增顶层菜单\n      ")],1)],1):r._e(),n("el-form-item",[n("el-button-group",[n("el-button",{attrs:{disabled:r.loading},on:{click:function(e){return r.checkedNodes(!0)}}},[n("cs-icon",{attrs:{name:"plus-square-o"}}),r._v("\n          展开\n        ")],1),n("el-button",{attrs:{disabled:r.loading},on:{click:function(e){return r.checkedNodes(!1)}}},[n("cs-icon",{attrs:{name:"minus-square-o"}}),r._v("\n          收起\n        ")],1)],1)],1),n("el-form-item",{attrs:{label:"过滤"}},[n("el-input",{staticStyle:{width:"180px"},attrs:{disabled:r.loading,placeholder:"输入关键字进行过滤","prefix-icon":"el-icon-search",clearable:!0},model:{value:r.filterText,callback:function(e){r.filterText=e},expression:"filterText"}})],1),n("cs-help",{staticStyle:{"padding-bottom":"19px"},attrs:{router:r.$route.path}})],1),n("el-row",{attrs:{gutter:20}},[n("el-col",{directives:[{name:"loading",rawName:"v-loading",value:r.loading,expression:"loading"}],attrs:{span:10}},[r.hackReset?n("el-tree",{ref:"tree",staticClass:"tree-scroll",attrs:{"node-key":"menu_id",data:r.treeData,props:r.treeProps,"filter-node-method":r.filterNode,"highlight-current":!0,"default-expand-all":r.isExpandAll,"default-expanded-keys":r.expanded,"allow-drag":r.allowDrag,draggable:!0},on:{"node-click":r.handleNodeClick,"node-drop":r.handleDrop},scopedSlots:r._u([{key:"default",fn:function(e){var t=e.node,a=e.data;return n("span",{staticClass:"custom-tree-node action"},[n("span",{staticClass:"brother-showing",class:{"status-tree":!a.status}},[r.auth.move?n("i",{staticClass:"fa fa-align-justify move-tree cs-mr-10"}):r._e(),a.icon?n("i",{class:"fa fa-"+a.icon}):a.children?n("i",{class:"fa fa-folder-"+(t.expanded?"open-o":"o")}):n("i",{staticClass:"fa fa-file-o"}),r._v("\n            "+r._s(t.label)+"\n          ")]),n("span",{staticClass:"active"},[r.auth.add?n("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(e){return e.stopPropagation(),r.handleAppend(a.menu_id)}}},[r._v("\n              新增\n            ")]):r._e(),r.auth.status?n("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(e){return e.stopPropagation(),r.enable(a.menu_id,a.status)}}},[r._v("\n              "+r._s(a.status?"禁用":"启用")+"\n            ")]):r._e(),r.auth.del?n("el-button",{attrs:{type:"text",size:"mini"},on:{click:function(e){return e.stopPropagation(),r.remove(a.menu_id)}}},[r._v("\n              删除\n            ")]):r._e()],1)])}}],null,!1,642407263)}):r._e()],1),n("el-col",{attrs:{span:14}},[r.auth.add||r.auth.set?n("el-card",{staticClass:"box-card",attrs:{shadow:"never"}},[n("div",{attrs:{slot:"header"},slot:"header"},[n("span",[r._v(r._s(r.textMap[r.formStatus]))]),"create"===r.formStatus&&r.auth.add?n("el-button",{staticStyle:{float:"right",padding:"3px 0"},attrs:{type:"text",loading:r.formLoading},on:{click:r.create}},[r._v("确定")]):"update"===r.formStatus&&r.auth.set?n("el-button",{staticStyle:{float:"right",padding:"3px 0"},attrs:{type:"text",loading:r.formLoading},on:{click:r.update}},[r._v("修改")]):r._e()],1),n("el-form",{ref:"form",attrs:{model:r.form,rules:r.rules,"label-width":"80px"}},[n("el-form-item",{attrs:{label:"上级菜单",prop:"parent_id"}},[n("el-cascader",{staticStyle:{width:"100%"},attrs:{placeholder:"不选择表示顶层菜单 试试搜索：首页",options:r.treeData,props:r.cascaderProps,filterable:"",clearable:""},model:{value:r.form.parent_id,callback:function(e){r.$set(r.form,"parent_id",e)},expression:"form.parent_id"}})],1),n("el-row",{attrs:{gutter:20}},[n("el-col",{attrs:{span:12}},[n("el-form-item",{attrs:{label:"名称",prop:"name"}},[n("el-input",{attrs:{placeholder:"请输入菜单名称",clearable:!0},model:{value:r.form.name,callback:function(e){r.$set(r.form,"name",e)},expression:"form.name"}})],1)],1),n("el-col",{attrs:{span:12}},[n("el-form-item",{attrs:{label:"别名",prop:"alias"}},[n("el-input",{attrs:{placeholder:"可输入菜单别名",clearable:!0},model:{value:r.form.alias,callback:function(e){r.$set(r.form,"alias",e)},expression:"form.alias"}})],1)],1)],1),n("el-row",{attrs:{gutter:20}},[n("el-col",{attrs:{span:12}},[n("el-form-item",{attrs:{label:"图标",prop:"icon"}},[n("cs-icon-select",{attrs:{"user-input":!0,placeholder:"可选择菜单图标"},model:{value:r.form.icon,callback:function(e){r.$set(r.form,"icon",e)},expression:"form.icon"}})],1)],1),n("el-col",{attrs:{span:12}},[n("el-form-item",{attrs:{label:"排序",prop:"sort"}},[n("el-input-number",{staticStyle:{width:"120px"},attrs:{min:0,max:255,"controls-position":"right"},model:{value:r.form.sort,callback:function(e){r.$set(r.form,"sort",e)},expression:"form.sort"}})],1)],1)],1),n("el-row",{attrs:{gutter:20}},[n("el-col",{attrs:{span:12}},[n("el-form-item",{attrs:{label:"模块"}},[n("el-radio-group",{attrs:{size:"small"},model:{value:r.module,callback:function(e){r.module=e},expression:"module"}},r._l(r.treeModule,function(e,t){return n("el-radio-button",{key:t,attrs:{label:t,disabled:r.module!==t}},[r._v(r._s(e))])}),1)],1)],1),n("el-col",{attrs:{span:12}},[n("el-form-item",{attrs:{label:"导航",prop:"is_navi"}},[n("el-switch",{attrs:{"active-value":"1","inactive-value":"0"},model:{value:r.form.is_navi,callback:function(e){r.$set(r.form,"is_navi",e)},expression:"form.is_navi"}})],1)],1)],1),n("el-row",{attrs:{gutter:20}},[n("el-col",{attrs:{span:12}},[n("el-form-item",{attrs:{label:"链接类型",prop:"type"}},[n("el-radio-group",{model:{value:r.form.type,callback:function(e){r.$set(r.form,"type",e)},expression:"form.type"}},[n("el-radio",{attrs:{label:"0"}},[r._v("模块")]),n("el-radio",{attrs:{label:"1"}},[r._v("外链")])],1)],1)],1),n("el-col",{attrs:{span:12}},[n("el-form-item",{attrs:{label:"打开方式",prop:"target"}},[n("el-radio-group",{model:{value:r.form.target,callback:function(e){r.$set(r.form,"target",e)},expression:"form.target"}},[n("el-radio",{attrs:{label:"_self"}},[r._v("当前窗口")]),n("el-radio",{attrs:{label:"_blank"}},[r._v("新窗口")])],1)],1)],1)],1),n("el-form-item",{attrs:{label:"URL",prop:"url"}},[n("el-input",{attrs:{placeholder:"可输入链接地址",clearable:!0},model:{value:r.form.url,callback:function(e){r.$set(r.form,"url",e)},expression:"form.url"}})],1),n("el-form-item",{attrs:{label:"参数",prop:"params"}},[n("el-input",{attrs:{placeholder:"可输入链接参数",clearable:!0},model:{value:r.form.params,callback:function(e){r.$set(r.form,"params",e)},expression:"form.params"}})],1),n("el-form-item",{attrs:{label:"备注",prop:"remark"}},[n("el-input",{attrs:{placeholder:"可输入菜单备注",type:"textarea",rows:3},model:{value:r.form.remark,callback:function(e){r.$set(r.form,"remark",e)},expression:"form.remark"}})],1)],1)],1):r._e()],1)],1)],1)},[],!1,null,"4d9538f8",null);t.default=c.exports}}]);