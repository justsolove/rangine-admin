(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-827345fe","chunk-2362254c"],{8422:function(e,t,a){"use strict";a.r(t);a("7f7f"),a("ac6a"),a("c5f6"),a("8e6e"),a("7514"),a("456d");var o=a("bd86"),r=(a("28a5"),a("6b54"),a("a320")),i=a("1213"),n=a("ca00");function l(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),a.push.apply(a,r)}return a}var s={data:function(){return{token:{},params:{},uploadUrl:"",parentId:[],parentData:[],parentProps:{value:"storage_id",label:"name",children:"children",checkStrictly:!0}}},watch:{watchToken:{handler:function(e){this.getToken(e)},immediate:!0}},mounted:function(){this.getDirectory()},computed:{watchToken:function(){return{moduleName:this.moduleName,replaceId:this.replaceId}}},methods:{getToken:function(e){var t=this;this.params={},this.replaceId?Object(r.c)(e.replaceId).then(function(e){t.token=e.data?e.data:{},t.uploadUrl=t.token.token.upload_url.upload_url}):Object(r.b)(e.moduleName).then(function(e){t.token=e.data?e.data:{},t.uploadUrl=t.token.token.upload_url.upload_url})},handleRemove:function(e,t){if("success"===e.status&&e.response){var a=e.response.data;if(a&&a[0].storage_id){var r=a[0].storage_id;Object(i.d)(Array.isArray(r)?r:[r])}}this.$emit("upload",t)},handlePreview:function(e){if("success"===e.status){var t=new Image;if(t.src=e.url,0<t.fileSize||0<t.width&&0<t.height)return void this.$preview(t.src)}this.$message.warning("当前模式或资源不支持预览")},handleBeforeUpload:function(a){var r=this;if(!this.token||!this.uploadUrl)return this.$message.error("上传组件初始化中或配置错误"),!1;var e=n.a.stringToByte(this.token.file_size);if(0<e&&a.size>e)return this.$message.error("上传资源大小不能超过 ".concat(this.token.file_size)),!1;var i=a.name.toLowerCase().split(".").splice(-1).toString();if(-1===(this.token.file_ext+","+this.token.image_ext).indexOf(i))return this.$message.error("上传资源的文件后缀不允许上传"),!1;var t=Math.round(new Date/1e3)+100;if(0!==this.token.expires&&t>this.token.expires)return this.$message.error("上传 Token 已过期"),!1;this.token.token.upload_url.param.forEach(function(e){if("file"!==e.name&&(r.params[e.name]=r.token.token.hasOwnProperty(e.name)?r.token.token[e.name]:e.default,!r.replaceId&&("x:filename"===e.name&&(r.params["x:filename"]=a.name),"x:parent_id"===e.name&&(r.params["x:parent_id"]=0,null!==r.storageId?r.params["x:parent_id"]=r.storageId:r.parentId.length&&(r.params["x:parent_id"]=r.parentId[r.parentId.length-1])),"key"===e.name))){var t=n.a.guid();r.params.key="".concat(r.token.token.dir).concat(t,".").concat(i)}}),"careyshop"===this.token.token.upload_url.module&&(this.params.token=n.a.cookies.get("token"),this.params.appkey="86757125",this.params.timestamp=t,this.params.format="json",this.params.method="add.upload.list",this.params.sign=n.a.getSign(function(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?l(a,!0).forEach(function(e){Object(o.a)(t,e,a[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):l(a).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))})}return t}({},this.params))),this.autoUpload&&(this.loading=!0)},handleSuccess:function(e,t,a){if(200===e.status&&e.data)return 200!==e.data[0].status?void this.handleError(e.data[0].message,t,a):(this.$emit("upload",a),void this.handleChange(a));this.handleError(e.message,t,a)},handleError:function(e,t,a){this.$message.error("资源：".concat(t.name," 上传失败")),n.a.log.danger("资源上传失败："+(e||t.response));for(var r=a.length-1;0<=r;r--)if(t===a[r]){a.splice(r,1),this.$emit("upload",a);break}this.handleChange(a)},handleExceed:function(e,t){if(t.length>=this.limit)this.$message.warning("最多只能上传 ".concat(this.limit," 个文件"));else if(e.length+t.length>this.limit){var a=this.limit-t.length;this.$message.warning("上传数量超出限制，最多还能选择 ".concat(a," 个文件"))}},handleChange:function(t){this.autoUpload&&Object.keys(t).every(function(e){return"success"===t[e].status})&&(this.loading=!1)},getDirectory:function(){var r=this;null===this.storageId&&Object(i.e)().then(function(e){r.parentData=e.data.list.length?n.a.formatDataToTree(e.data.list,"storage_id"):[],r.parentData.unshift({storage_id:0,parent_id:0,name:"根目录"});var t=e.data.default;do{var a=e.data.list.find(function(e){return e.storage_id===t});a?(t=a.parent_id,r.parentId.unshift(a.storage_id)):(t=0,r.parentId=[0])}while(t)})}}},d={name:"cs-upload-comp",mixins:[s],props:{uploadTip:{type:String,required:!1,default:"请选择图片进行上传，"},listType:{type:String,required:!1,default:"picture-card"},multiple:{type:Boolean,required:!1,default:!1},showFileList:{type:Boolean,required:!1,default:!0},drag:{type:Boolean,required:!1,default:!1},accept:{type:String,required:!1,default:"image/*"},limit:{type:Number,required:!1,default:0},autoUpload:{type:Boolean,required:!1,default:!0},moduleName:{type:String,required:!1,default:""},fileList:{type:Array,required:!1,default:function(){return[]}},storageId:{type:Number,required:!1,default:null},fileWidth:{type:String,required:!1,default:"30%"}}},u=a("2877"),p=Object(u.a)(d,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("el-upload",{attrs:{action:t.uploadUrl,data:t.params,"file-list":t.fileList,"list-type":t.listType,multiple:t.multiple,"show-file-list":t.showFileList,drag:t.drag,accept:t.accept,limit:t.limit,"auto-upload":t.autoUpload,"on-preview":t.handlePreview,"on-remove":t.handleRemove,"before-upload":t.handleBeforeUpload,"on-success":t.handleSuccess,"on-error":t.handleError,"on-exceed":t.handleExceed}},[a("i",{staticClass:"el-icon-plus"}),a("div",{staticClass:"el-upload__tip",attrs:{slot:"tip"},slot:"tip"},[t._v(t._s(t.uploadTip)+"大小不能超过 "+t._s(this.token.file_size))])]),null===t.storageId?a("el-cascader",{style:"width: "+t.fileWidth,attrs:{options:t.parentData,props:t.parentProps,filterable:""},model:{value:t.parentId,callback:function(e){t.parentId=e},expression:"parentId"}}):t._e()],1)},[],!1,null,null,null).exports,c={name:"cs-upload-slot",mixins:[s],props:{uploadTip:{type:String,required:!1,default:"请选择资源进行(支持拖拽)上传，"},multiple:{type:Boolean,required:!1,default:!0},showFileList:{type:Boolean,required:!1,default:!0},drag:{type:Boolean,required:!1,default:!0},accept:{type:String,required:!1,default:"*/*"},limit:{type:Number,required:!1,default:0},autoUpload:{type:Boolean,required:!1,default:!0},moduleName:{type:String,required:!1,default:""},storageId:{type:Number,required:!1,default:null}},data:function(){return{replaceId:0,visible:!1,loading:!1}},methods:{handleClose:function(){this.replaceId=0,this.visible=!1,this.loading=!1,this.$refs.upload&&this.$refs.upload.clearFiles()},handleConfirm:function(){this.$emit("confirm"),this.handleClose()}}},h=(a("f62f"),Object(u.a)(c,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"upload-control",on:{click:function(e){t.visible=!0}}},[t._t("control"),a("el-dialog",{attrs:{width:"400px",visible:t.visible,"append-to-body":!0,"close-on-click-modal":!1},on:{"update:visible":function(e){t.visible=e},close:t.handleClose}},[a("el-upload",{ref:"upload",attrs:{"list-type":"text",action:t.uploadUrl,data:t.params,multiple:t.multiple,"show-file-list":t.showFileList,drag:t.drag,accept:t.accept,limit:t.limit,"auto-upload":t.autoUpload,"on-preview":t.handlePreview,"on-remove":t.handleRemove,"before-upload":t.handleBeforeUpload,"on-success":t.handleSuccess,"on-error":t.handleError,"on-exceed":t.handleExceed}},[a("i",{staticClass:"el-icon-upload"}),a("div",{staticClass:"el-upload__text"},[t._v("将资源拖到此处，或"),a("em",[t._v("点击上传")])]),a("div",{staticClass:"el-upload__tip",attrs:{slot:"tip"},slot:"tip"},[t._v(t._s(t.uploadTip)+"大小不能超过 "+t._s(this.token.file_size))])]),a("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("div",{staticStyle:{float:"left"}},[null===t.storageId?a("el-cascader",{attrs:{options:t.parentData,props:t.parentProps,size:"small",filterable:""},model:{value:t.parentId,callback:function(e){t.parentId=e},expression:"parentId"}}):t._e()],1),a("el-button",{attrs:{size:"small"},on:{click:t.handleClose}},[t._v("取消")]),a("el-button",{attrs:{loading:t.loading,type:"primary",size:"small"},on:{click:t.handleConfirm}},[t._v("确定")])],1)],1)],2)},[],!1,null,"e2e8e4f2",null).exports),f={name:"cs-upload",props:{value:{type:Array,required:!1,default:function(){return[]}},confirm:{type:Function},type:{type:String,required:!1,default:"comp"}},data:function(){return{fileList:[],source:""}},computed:{component:function(){return"comp"===this.type?p:"slot"===this.type?h:"div"}},render:function(e){var t=this,a=[e("div",this.$slots.default)];return this.$slots.control&&a.push(e("div",{slot:"control"},[this.$slots.control])),e("div",{},[e(this.component,{ref:"upload",props:this.$attrs,on:{upload:function(e){"comp"===t.type&&t.$emit("input",t.getUploadData(e)),"slot"===t.type&&(t.fileList=e)},confirm:function(){"slot"===t.type&&(t.$emit("confirm",t.fileList,t.source),t.fileList=[])}}},a)])},methods:{getUploadData:function(e){var t=[];return e.forEach(function(e){e.response?t.push({name:e.response.data[0].name,source:e.response.data[0].url,url:"//"+e.response.data[0].url}):t.push({name:e.name,source:e.source,url:e.url})}),t},handleUploadDlg:function(e){var t=0<arguments.length&&void 0!==e?e:"";"slot"===this.type&&(this.$refs.upload.visible=!0,this.source=t)},setReplaceId:function(e){this.$refs.upload.replaceId=e}}},m=Object(u.a)(f,void 0,void 0,!1,null,null,null);t.default=m.exports},a320:function(e,t,a){"use strict";a.d(t,"a",function(){return i}),a.d(t,"b",function(){return o}),a.d(t,"c",function(){return n});var r=a("b775");function i(){return Object(r.a)({url:"/v1/upload",method:"post",params:{method:"get.upload.module"}})}function o(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:void 0,t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:"web";return Object(r.a)({url:"/v1/upload",method:"post",params:{method:"get.upload.token"},data:{module:e,type:t}})}function n(e){return Object(r.a)({url:"/v1/upload",method:"post",params:{method:"replace.upload.item"},data:{storage_id:e}})}},adaa:function(e,t,a){},f62f:function(e,t,a){"use strict";var r=a("adaa");a.n(r).a}}]);