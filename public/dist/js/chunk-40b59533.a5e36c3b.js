(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-40b59533"],{"2e23":function(e,t,a){"use strict";a.r(t);a("8e6e"),a("456d");var r=a("bd86"),i=(a("ac6a"),a("e558")),o=a("ca00"),n=a("f86b");function s(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),a.push.apply(a,r)}return a}function l(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?s(a,!0).forEach(function(e){Object(r.a)(t,e,a[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):s(a).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))})}return t}var d={props:{loading:{default:!1},addressId:{default:0},tableData:{default:function(){return[]}}},data:function(){return{currentTableData:[],dialogLoading:!1,dialogFormVisible:!1,dialogStatus:"",textMap:{update:"编辑地址",create:"新增地址"},form:{client_id:void 0,consignee:void 0,regions:void 0,address:void 0,zipcode:void 0,tel:void 0,mobile:void 0,is_default:void 0},rules:{consignee:[{required:!0,message:"姓名不能为空",trigger:"blur"},{max:30,message:"姓名不能大于 30 个字符",trigger:"blur"}],regions:[{required:!0,message:"所在地区不能为空",trigger:"change"}],address:[{required:!0,message:"详细地址不能为空",trigger:"blur"},{max:255,message:"详细地址不能大于 255 个字符",trigger:"blur"}],mobile:[{required:!0,message:"手机不能为空",trigger:"blur"},{min:7,max:15,message:"长度在 7 到 15 个字符",trigger:"blur"}],zipcode:[{max:20,message:"邮编不能大于 20 个字符",trigger:"blur"}],tel:[{max:20,message:"电话不能大于 20 个字符",trigger:"blur"}]},treeData:[],treeProps:{value:"region_id",label:"region_name",children:"children"}}},watch:{tableData:{handler:function(e){this.currentTableData=e}}},methods:{handleDelete:function(e){var t=this;this.$confirm("确定要执行该操作吗?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning",closeOnClickModal:!1}).then(function(){Object(i.b)(t.$route.params.client_id,[t.currentTableData[e].user_address_id]).then(function(){t.currentTableData.splice(e,1),t.$message.success("操作成功")})}).catch(function(){})},handleDefault:function(e){var t=this;this.$confirm("确定要执行该操作吗?","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning",closeOnClickModal:!1}).then(function(){Object(i.e)(e).then(function(){t.$emit("update:addressId",e),t.$message.success("操作成功")})}).catch(function(){})},openDialog:function(){var t=this;this.treeData.length||Object(n.d)({region_id:1}).then(function(e){t.treeData=e.data.length?o.a.formatDataToTree(e.data,"region_id","parent_id",{key:"parent_id",value:[1]}):[]})},handleCreate:function(){var e=this;Object(i.d)(this.$route.params.client_id).then(function(){e.form={client_id:e.$route.params.client_id,consignee:void 0,regions:void 0,address:void 0,zipcode:void 0,tel:void 0,mobile:void 0,is_default:0},e.$nextTick(function(){e.$refs.form.clearValidate()}),e.dialogStatus="create",e.dialogLoading=!1,e.dialogFormVisible=!0}).catch(function(){e.dialogFormVisible=!1})},create:function(){var a=this;this.$refs.form.validate(function(e){e&&(a.form.regions.forEach(function(e,t){switch(t){case 0:a.form.province=e;break;case 1:a.form.city=e;break;case 2:a.form.district=e}}),a.dialogLoading=!0,Object(i.a)(l({},a.form)).then(function(e){1===a.form.is_default&&a.$emit("update:addressId",e.data.user_address_id),a.currentTableData.push(e.data),a.dialogFormVisible=!1,a.$message.success("操作成功")}).catch(function(){a.dialogLoading=!1}))})},handleUpdate:function(e){var t=this;this.currentIndex=e,this.form=l({},this.currentTableData[e],{client_id:this.$route.params.client_id}),this.form.regions=[this.form.province||0,this.form.city||0,this.form.district||0],this.$nextTick(function(){t.$refs.form.clearValidate()}),this.dialogStatus="update",this.dialogLoading=!1,this.dialogFormVisible=!0},update:function(){var a=this;this.$refs.form.validate(function(e){e&&(a.form.regions.forEach(function(e,t){switch(t){case 0:a.form.province=e;break;case 1:a.form.city=e;break;case 2:a.form.district=e}}),a.dialogLoading=!0,Object(i.f)(l({},a.form)).then(function(e){1===a.form.is_default&&a.$emit("update:addressId",e.data.user_address_id),a.$set(a.currentTableData,a.currentIndex,l({},a.currentTableData[a.currentIndex],{},e.data)),a.dialogFormVisible=!1,a.$message.success("操作成功")}).catch(function(){a.dialogLoading=!1}))})}}},c=a("2877"),u=Object(c.a)(d,function(){var a=this,e=a.$createElement,r=a._self._c||e;return r("div",{staticClass:"cs-p"},[r("el-form",{attrs:{inline:!0,size:"small"}},[r("el-form-item",{directives:[{name:"has",rawName:"v-has",value:"/member/user/address/add",expression:"'/member/user/address/add'"}]},[r("el-button",{attrs:{disabled:a.loading},on:{click:a.handleCreate}},[r("cs-icon",{attrs:{name:"plus"}}),a._v("\n        新增地址\n      ")],1)],1),r("cs-help",{staticStyle:{"padding-bottom":"19px"},attrs:{router:a.$route.path}})],1),r("el-table",{directives:[{name:"loading",rawName:"v-loading",value:a.loading,expression:"loading"}],attrs:{data:a.currentTableData}},[r("el-table-column",{attrs:{label:"收货人",prop:"consignee",width:"100"}}),r("el-table-column",{attrs:{label:"所在地区",prop:"region","min-width":"150","show-overflow-tooltip":!0}}),r("el-table-column",{attrs:{label:"详细地址",prop:"address","min-width":"200","show-overflow-tooltip":!0}}),r("el-table-column",{attrs:{label:"邮编",prop:"zipcode"}}),r("el-table-column",{attrs:{label:"手机",prop:"mobile",width:"120"}}),r("el-table-column",{attrs:{label:"电话",prop:"tel",width:"120"}}),r("el-table-column",{attrs:{label:"操作",align:"center","min-width":"150"},scopedSlots:a._u([{key:"default",fn:function(t){return[r("el-button",{directives:[{name:"has",rawName:"v-has",value:"/member/user/address/set",expression:"'/member/user/address/set'"}],attrs:{size:"small",type:"text"},on:{click:function(e){return a.handleUpdate(t.$index)}}},[a._v("编辑")]),r("el-button",{directives:[{name:"has",rawName:"v-has",value:"/member/user/address/del",expression:"'/member/user/address/del'"}],attrs:{size:"small",type:"text"},on:{click:function(e){return a.handleDelete(t.$index)}}},[a._v("删除")]),r("el-button",{directives:[{name:"has",rawName:"v-has",value:"/member/user/address/default",expression:"'/member/user/address/default'"}],attrs:{disabled:t.row.user_address_id===a.addressId,size:"small",type:"text"},on:{click:function(e){return a.handleDefault(t.row.user_address_id)}}},[a._v("\n          "+a._s(t.row.user_address_id===a.addressId?"默认地址":"设为默认")+"\n        ")])]}}])})],1),r("el-dialog",{attrs:{title:a.textMap[a.dialogStatus],visible:a.dialogFormVisible,"append-to-body":!0,"close-on-click-modal":!1,width:"600px"},on:{"update:visible":function(e){a.dialogFormVisible=e},open:a.openDialog}},[r("el-form",{ref:"form",attrs:{model:a.form,rules:a.rules,"label-width":"80px"}},[r("el-form-item",{attrs:{label:"姓名",prop:"consignee"}},[r("el-input",{attrs:{placeholder:"请输入姓名",clearable:!0},model:{value:a.form.consignee,callback:function(e){a.$set(a.form,"consignee",e)},expression:"form.consignee"}})],1),r("el-form-item",{attrs:{label:"所在地区",prop:"regions"}},[r("el-cascader",{staticStyle:{width:"100%"},attrs:{placeholder:"请选择所在地区",options:a.treeData,props:a.treeProps,clearable:""},model:{value:a.form.regions,callback:function(e){a.$set(a.form,"regions",e)},expression:"form.regions"}})],1),r("el-form-item",{attrs:{label:"详细地址",prop:"address"}},[r("el-input",{attrs:{placeholder:"请输入详细地址",clearable:!0},model:{value:a.form.address,callback:function(e){a.$set(a.form,"address",e)},expression:"form.address"}})],1),r("el-form-item",{attrs:{label:"邮编",prop:"zipcode"}},[r("el-input",{attrs:{placeholder:"可输入邮编",clearable:!0},model:{value:a.form.zipcode,callback:function(e){a.$set(a.form,"zipcode",e)},expression:"form.zipcode"}})],1),r("el-form-item",{attrs:{label:"手机",prop:"mobile"}},[r("el-input",{attrs:{placeholder:"请输入手机",clearable:!0},model:{value:a.form.mobile,callback:function(e){a.$set(a.form,"mobile",e)},expression:"form.mobile"}})],1),r("el-form-item",{attrs:{label:"电话",prop:"tel"}},[r("el-input",{attrs:{placeholder:"可输入电话",clearable:!0},model:{value:a.form.tel,callback:function(e){a.$set(a.form,"tel",e)},expression:"form.tel"}})],1),a.form.user_address_id!==a.addressId?r("el-form-item",{attrs:{prop:"is_default"}},[r("el-checkbox",{attrs:{"true-label":1,"false-label":0},model:{value:a.form.is_default,callback:function(e){a.$set(a.form,"is_default",e)},expression:"form.is_default"}},[a._v("\n          是否设为默认收货地址\n        ")])],1):a._e()],1),r("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[r("el-button",{attrs:{size:"small"},on:{click:function(e){a.dialogFormVisible=!1}}},[a._v("取消")]),"create"===a.dialogStatus?r("el-button",{attrs:{type:"primary",loading:a.dialogLoading,size:"small"},on:{click:a.create}},[a._v("确定")]):r("el-button",{attrs:{type:"primary",loading:a.dialogLoading,size:"small"},on:{click:a.update}},[a._v("修改")])],1)],1)],1)},[],!1,null,null,null);t.default=u.exports},f86b:function(e,t,a){"use strict";a.d(t,"a",function(){return i}),a.d(t,"f",function(){return o}),a.d(t,"b",function(){return n}),a.d(t,"c",function(){return s}),a.d(t,"d",function(){return l}),a.d(t,"e",function(){return d});var r=a("b775");function i(e){return Object(r.a)({url:"/admin/region/add",method:"post",params:{},data:e})}function o(e){return Object(r.a)({url:"/admin/region/set",method:"post",params:{},data:e})}function n(e){return Object(r.a)({url:"/admin/region/delete",method:"post",params:{},data:{region_id:e}})}function s(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:null;return Object(r.a)({url:"/v1/region",method:"post",params:{method:"get.region.list"},data:e})}function l(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:null;return Object(r.a)({url:"/admin/region/list",method:"post",params:{},data:e})}function d(e){return Object(r.a)({url:"/admin/region/index",method:"post",params:{},data:{region_id:e}})}}}]);