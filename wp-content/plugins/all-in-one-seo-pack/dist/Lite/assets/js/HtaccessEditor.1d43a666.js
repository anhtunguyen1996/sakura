import{e as u,u as _}from"./links.4e9269a4.js";import{B as m}from"./Editor.87ec1d9f.js";import{C as h}from"./index.cd7fac8b.js";import{C as f}from"./Card.37225977.js";import{C as g}from"./SettingsRow.2432af31.js";import{r as t,c as y,d as s,w as r,o as a,a as w,b as v,g as b,t as x,f as C}from"./vue.runtime.esm-bundler.1bf81f69.js";import{_ as E}from"./_plugin-vue_export-helper.4292a25a.js";import"./default-i18n.41786823.js";import"./isArrayLikeObject.76f0d098.js";import"./tags.9c0199b3.js";import"./Caret.0b57d359.js";import"./Tooltip.fc81232d.js";import"./Slide.c4e68d01.js";import"./Row.1358a527.js";/* empty css                                            */const S={setup(){return{optionsStore:u(),rootStore:_()}},components:{BaseEditor:m,CoreAlert:h,CoreCard:f,CoreSettingsRow:g},data(){return{strings:{htaccessEditor:this.$t.__(".htaccess Editor",this.$td),editHtaccess:this.$t.__("Edit .htaccess",this.$td),description:this.$t.sprintf(this.$t.__("This allows you to edit the .htaccess file for your site. All WordPress sites on an Apache server have a .htaccess file and we have provided you with a convenient way of editing it. Care should always be taken when editing important files from within WordPress as an incorrect change could cause WordPress to become inaccessible. %1$sBe sure to make a backup before making changes and ensure that you have FTP access to your web server and know how to access and edit files via FTP.%2$s",this.$td),"<strong>","</strong>")}}}},k={class:"aioseo-tools-htaccess-editor"},B=["innerHTML"];function H(V,n,A,e,o,P){const i=t("core-alert"),c=t("base-editor"),d=t("core-settings-row"),l=t("core-card");return a(),y("div",k,[s(l,{slug:"htaccessEditor","header-text":o.strings.htaccessEditor},{default:r(()=>[w("div",{class:"aioseo-settings-row aioseo-section-description",innerHTML:o.strings.description},null,8,B),s(d,{name:o.strings.editHtaccess,align:""},{content:r(()=>[e.optionsStore.htaccessError?(a(),v(i,{key:0,type:"red"},{default:r(()=>[b(x(e.optionsStore.htaccessError),1)]),_:1})):C("",!0),s(c,{class:"htaccess-editor",disabled:!e.rootStore.aioseo.user.unfilteredHtml,modelValue:e.rootStore.aioseo.data.htaccess,"onUpdate:modelValue":n[0]||(n[0]=p=>e.rootStore.aioseo.data.htaccess=p),"line-numbers":"",monospace:"","preserve-whitespace":""},null,8,["disabled","modelValue"])]),_:1},8,["name"])]),_:1},8,["header-text"])])}const I=E(S,[["render",H]]);export{I as default};
